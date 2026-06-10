// Capturas responsive de las vistas del panel y del blog.
// Pensado para correr DENTRO del contenedor Sail (allí está Chromium con sus
// dependencias del sistema). La app responde en http://localhost:80.
const { defineConfig } = require('@playwright/test');

module.exports = defineConfig({
    testDir: './tests/e2e',
    globalSetup: './tests/e2e/global-setup.cjs',
    outputDir: './tests/e2e/.output',
    reporter: [['list']],
    timeout: 60000,

    use: {
        baseURL: 'http://localhost',
        storageState: './tests/e2e/.auth/state.json',
    },

    // Tres anchos representativos. Forzamos chromium (es el único navegador
    // instalado) y usamos isMobile sólo donde lo soporta (chromium).
    projects: [
        {
            name: 'mobile',
            use: {
                browserName: 'chromium',
                viewport: { width: 390, height: 844 }, // ~iPhone 12 / Pixel
                deviceScaleFactor: 3,
                isMobile: true,
                hasTouch: true,
            },
        },
        {
            name: 'tablet',
            use: {
                browserName: 'chromium',
                viewport: { width: 820, height: 1180 }, // ~iPad
                deviceScaleFactor: 2,
                hasTouch: true,
            },
        },
        {
            name: 'desktop',
            use: {
                browserName: 'chromium',
                viewport: { width: 1366, height: 900 },
            },
        },
    ],
});
