const esbuild = require('esbuild');
const args = process.argv.slice(2);
const isProduction = args.includes('--production');
const isWatch = args.includes('--watch');

const config = {
    entryPoints: [
        'resources/js/app.js',
        'resources/js/three-scene.js',
    ],
    outdir: 'public/js',
    bundle: true,
    minify: isProduction,
    sourcemap: !isProduction,
    target: 'es2020',
    loader: {
        '.js': 'jsx',
    },
};

async function build() {
    if (isWatch) {
        const ctx = await esbuild.context(config);
        await ctx.watch();
        console.log('Watching for changes...');
    } else {
        await esbuild.build(config);
        console.log('Build complete.');
    }
}

build().catch(() => process.exit(1));
