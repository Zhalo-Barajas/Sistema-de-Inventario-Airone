<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\DatabaseExport;
use App\Imports\DatabaseImportStep1;
use App\Imports\DatabaseImportStep2;
use App\Models\Element;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel; 
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller implements HasMiddleware
{

    public static function middleware(): array //Nueva función dedicada para utilizar middleware en (Antes en laravel 10 era por medio de unnn metodo constructor)
    {
        //Middleware para comprobar si un usuario puede acceder o no a la vista función de este controlador.
        return [
            
            new Middleware(middleware: 'can:admin.database.index', only: ['index']), //Nueva forma de declarar middleware de laravel 11 dentro del controlador
            new Middleware(middleware: 'can:admin.database.export', only: ['export']),
            new Middleware(middleware: 'can:admin.database.import', only: ['import','upload']),
            new Middleware(middleware: 'can:admin.database.dump', only: ['dump']),
           
        ];

        /*
            Ejemplo de comando de middleware de Laravel 10 a 11
            new Middleware(middleware: 'auth:sanctum', except: ['index', 'show']), //Laravel 11
            $this->middleware('auth:sanctum')->except(['index', 'show']); //Laravel 10
        */
    }

    public function index(){
        return view('admin.database.index');
    }

    public function export(){
        //Generación de fecha actual
        $fecha = Carbon::now()->format('Y-m-d');
        //Generación del documento con el titulo que incluye la fecha actual.
        return Excel::download(new DatabaseExport, 'Listado_Elementos_'.$fecha.'.xlsx');
    }

    public function dump(){
        // Recopilación de variables del ambiente del servidor.

        // Dirección del host (IP/Dominio).
        $mysqlHostName = env('DB_HOST');
        // Nombre del usuario de la base de datos.
        $mysqlUserName = env('DB_USERNAME');
        // Contraseña base de datos.
        $mysqlPassword = env('DB_PASSWORD');
        // Nombre de la base de datos.
        $DbName = env('DB_DATABASE');
        // Puerto del servidor de base de datos Mysql.
        $DbPort = env('DB_PORT');
        // Tablas que va a recuperar en el respaldo.
        $tables = array("users","tags","buildings","categories","ubications","funds","elements","cache","cache_locks", "computing_atributes","conveyances","element_tag","furniture_atributes","images","infrastructure_atributes","job_batches","jobs","lab_equip_atributes","sec_equip_atributes","machinery_atributes","maintenances", "permissions","migrations","roles","model_has_roles","model_has_permissions","password_reset_tokens","personal_access_tokens","role_has_permissions","sessions","events","failed_jobs",);

        //Creación de una nueva 
        $connect = new \PDO("mysql:host=$mysqlHostName;port=$DbPort;dbname=$DbName;charset=utf8", "$mysqlUserName", "$mysqlPassword", array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        // Consulta para obtener todas las tablas de la base de datos.
        $get_all_table_query = "SHOW TABLES";
        $statement = $connect->prepare($get_all_table_query);
        $statement->execute();
        $result = $statement->fetchAll();


        // Variable para almacenar las consultas SQL que se generarán.
        $output = '';



        // Bucle a través de cada tabla seleccionada.
        foreach ($tables as $table) {
            $show_table_query = "SHOW CREATE TABLE " . $table;
            $statement = $connect->prepare($show_table_query);
            $statement->execute();
            $show_table_result = $statement->fetchAll();

            // Añadir la declaración CREATE TABLE al output.
            foreach ($show_table_result as $show_table_row) {
                $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
            }

            // Evitar la exportación de registros para las tablas cache, sessions y cache_locks.
            if (!in_array($table, ['cache', 'cache_locks','sessions','failed_jobs'])) {
            $select_query = "SELECT * FROM " . $table;
            $statement = $connect->prepare($select_query);
            $statement->execute();
            $total_row = $statement->rowCount();

            // Bucle a través de cada registro de la tabla actual.
            for ($count = 0; $count < $total_row; $count++) {
                // Obtener un registro como un array asociativo.
                $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
                // Obtener las claves (nombres de columnas) del registro.
                $table_column_array = array_keys($single_result);
                // Obtener los valores del registro y escapar caracteres especiales.
                $table_value_array = array_map(function($value) {
                    // Escapar barras invertidas y otros caracteres especiales
                    return addslashes($value);
                }, array_values($single_result));

                // Construir la consulta INSERT INTO para el registro actual.
                $output .= "\nINSERT INTO $table (";
                $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
                $output .= "'" . implode("','", $table_value_array) . "');\n";
                }
            }
        }


        // Nombre del archivo de respaldo.
        $file_name = 'Respaldo_BDD_' . date('y-m-d') . '.sql';
        // Crear y abrir un archivo para escribir el respaldo.
        $file_handle = fopen($file_name, 'w+');
        // Escribir las consultas SQL en el archivo.
        fwrite($file_handle, $output);
        // Cerrar el archivo.
        fclose($file_handle);

        // Preparar el archivo para su descarga.
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_name));
        ob_clean();
        flush();

        // Leer el archivo y enviarlo al navegador para su descarga.
        readfile($file_name);
        // Eliminar el archivo después de la descarga.
        unlink($file_name);

//////////////////////////////////////////////////////
    }

    public function import(Request $request){
        $request->validate([
            //Relga de validación para comprobar que le archivo subido es un .xlsx
            'import' => 'required|mimes:xlsx',
        ]);
        // return $request;
        $request->file('import')->storeAs('public/uploads', 'upload.xlsx');
        // Define el rango de IDs que se eliminarán en caso de que falle la transacción
        $startId = Element::latest()->first()->id;

        //Try Catch con el proposito de capturar errores durante el proceso de importación.
        try {
            Excel::import(new DatabaseImportStep1, storage_path('app/public/uploads/upload.xlsx'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             $failures = $e->failures();
             foreach ($failures as $failure) {

                //Retorno del primer error detectado en la excepción.
                return redirect()->route('admin.database.upload',compact('failures'))->with('infoError','Se ha detectado un error en el documento de importación. En la Fila '.$failure->row().' dentro del atributo '.$failure->attribute(). '.' );
             }
             
        }
        try {
            Excel::import(new DatabaseImportStep2, storage_path('app/public/uploads/upload.xlsx'));
            
            return redirect()->route('admin.database.upload')->with('info','Hoja de cálculo importada con éxito');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
             //Captura de todos los errores
            //  return $failures;//Depuración errores completos

            //Si se detecta una falla al momento de importar registros de atributos re eliminarán todos los registros de elemetntos ya creados y se le retornará al usuario el indice para los siguientes elementos.
            //Lógica para eliminar registros de elementos.
            foreach ($failures as $failure) {
            $endId = Element::latest()->first()->id;
            if($startId != $endId){
            // Elimina los registros dentro del rango especificado
                Element::whereBetween('id', [($startId + 1), $endId])->delete();
                return redirect()->route('admin.database.upload',compact('failures'))->with('infoError','Se ha detectado un error en el documento de importación. En la Fila '.$failure->row().' dentro del atributo '.$failure->attribute(). '. No han sido importados los registros de elementos. El Contador de ID de elemento es: '.$endId.', por lo tanto, tu siguiente registro de atributos adicionales debe iniciar con el ID '.($endId + 1).'.' );

            }
                return redirect()->route('admin.database.upload',compact('failures'))->with('infoError','Se han importado los registros de la tabla elementos, pero se ha detectado un error en el documento de importación. En la Fila '.$failure->row().' dentro del atributo '.$failure->attribute(). '. No han sido importados los registros de atributos. Puedes añadirlos manualmente editandolos en el sistema o con una segunda importación la cual contenga únicamente con registros de atributos respectivos.' );
             }
             
        }
    }

    public function upload(){
        return view('admin.database.upload');
    }
}
