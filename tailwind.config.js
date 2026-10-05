import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
                colors: {
                    //Agregar aqui colores personalizados 
                    'pantone': '#b91116'
                    // 'silver': '#ecebff',
                    // 'bubble-gum': '#ff77e9',
                    // 'bermuda': '#78dcca',
                },
                
            fontFamily: {
                //Añadida fuente para las landpage del sistema.
                sans: ['Source Sans Pro', 'Arial', 'sans-serif','Figtree', ...defaultTheme.fontFamily.sans],
            },

        },
    },
    plugins: [forms, typography], //Revido plugin de libreria flowbite
    
};
