// Captura, en cada viewport (mobile / tablet / desktop), las vistas clave del
// panel de artículos y del blog público. Las imágenes quedan en
// tests/e2e/screenshots/<viewport>--<vista>.png para revisarlas a ojo.
//
// Requiere la variable de entorno POST_ID (artículo de demostración sembrado
// antes de correr; ver el comando de siembra en el README de e2e).
const { test } = require('@playwright/test');

const postId = process.env.POST_ID;

const views = [
    { name: 'admin-index',   url: '/admin/posts' },
    { name: 'admin-create',  url: '/admin/posts/create' },
    { name: 'admin-edit',    url: `/admin/posts/${postId}/edit` },
    { name: 'admin-preview', url: `/admin/posts/${postId}/preview` },
    { name: 'blog-index',    url: '/blog' },
];

for (const view of views) {
    test(view.name, async ({ page }, testInfo) => {
        await page.goto(view.url, { waitUntil: 'networkidle' });
        // El editor TipTap monta de forma asíncrona; un respiro evita capturarlo a medias.
        await page.waitForTimeout(600);
        await page.screenshot({
            path: `tests/e2e/screenshots/${testInfo.project.name}--${view.name}.png`,
            fullPage: true,
        });
    });
}
