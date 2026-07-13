import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/js/app.js",
                "resources/css/app.css",
                "resources/js/assets/plugins/fontawesome-free/css/all.min.css",
                "resources/js/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css",
                "resources/js/assets/dist/css/adminlte.min.css",
                "resources/web/assets/bootstrap-5.3.8-dist/css/bootstrap.min.css",
                "resources/web/assets/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js",
                "resources/web/assets/css/common.css",
                "resources/web/assets/css/style.css",
                "resources/web/assets/js/main.js",
                "resources/web/assets/js/home.js",

                // "resources/js/assets/dist/js/pages/dashboard2.js",
                // "resources/js/assets/plugins/jquery/jquery.min.js",
                // "resources/js/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js",
                // "resources/js/assets/dist/js/adminlte.js",
                // "resources/js/assets/plugins/bootstrap/js/bootstrap.bundle.min.js",
                // "resources/js/assets/plugins/jquery-mousewheel/jquery.mousewheel.js",
                // "resources/js/assets/plugins/raphael/raphael.min.js",
                // "resources/js/assets/plugins/jquery-mapael/jquery.mapael.min.js",
                // "resources/js/assets/plugins/jquery-mapael/maps/usa_states.min.js",
                // "resources/js/assets/plugins/chart.js/Chart.min.js",
            ],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            "@": "/resources/js", // Adjust if your images are elsewhere
        },
    },
});

//bato top button
//footer menu animation
//white vue all button fix
