import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/appAdminIndex.css', //Añadido css para panel administrativo (Calendario)
                'resources/css/adminFormStyles.css',
                'resources/js/themeTitleInyector.js' //Estilos para los formularios.
            ],
            refresh: true,
        }),
    ],
});
