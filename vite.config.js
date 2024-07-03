import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: [
                "routes/**",
                "app/Http/**",
                "app/Models/**",
                "resources/views/**",
            ],
        }),
    ],
});
