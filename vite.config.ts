import { defineConfig } from 'vite';
import process from 'node:process';

export default defineConfig({
    build: {
        emptyOutDir: false,
        outDir: './webroot',
        manifest: true,
        rollupOptions: {
            input: ['./webroot_src/json-editor.ts'],
        },
    },
    server: {
        host: '0.0.0.0',
        strictPort: true,
        origin: `${process.env.DDEV_PRIMARY_URL?.replace(/:\d+$/, "")}:5173`,
        hmr: true,
    },
});
