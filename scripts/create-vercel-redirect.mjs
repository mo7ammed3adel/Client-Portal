import { mkdirSync, writeFileSync } from 'node:fs';
import { resolve } from 'node:path';

const railwayUrl = 'https://talba.up.railway.app';
const outputDir = resolve('public/build');

mkdirSync(outputDir, { recursive: true });

writeFileSync(
    resolve(outputDir, 'index.html'),
    `<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="0; url=${railwayUrl}">
    <title>طلبة</title>
    <script>
        const target = ${JSON.stringify(railwayUrl)} + window.location.pathname + window.location.search + window.location.hash;
        window.location.replace(target);
    </script>
</head>
<body>
    <p>Redirecting to <a href="${railwayUrl}">طلبة</a>...</p>
</body>
</html>
`,
    'utf8',
);
