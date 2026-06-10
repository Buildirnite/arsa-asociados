// Inicia sesión en el panel una vez y guarda las cookies (storageState) para
// que todas las capturas se tomen ya autenticadas.
const { chromium } = require('@playwright/test');
const fs = require('fs');

module.exports = async () => {
    fs.mkdirSync('tests/e2e/.auth', { recursive: true });

    const browser = await chromium.launch();
    const page = await browser.newPage();

    await page.goto('http://localhost/admin');
    await page.fill('input[name="password"]', process.env.ADMIN_PASSWORD || 'arsa2024');
    await page.click('button[type="submit"]');
    await page.waitForURL('**/admin/posts**', { timeout: 30000 });

    await page.context().storageState({ path: 'tests/e2e/.auth/state.json' });
    await browser.close();
};
