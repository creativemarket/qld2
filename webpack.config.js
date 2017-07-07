const path = require('path');

module.exports = {
    entry: './src/main.js',
    output: {
        path: './dist',
        publicPath: 'dist/',
        filename: 'build.js',
    },
    plugins: [],
    devServer: {
        inline: true,
        port: 9000,
    },
    module: {
        loaders: [{
            test: /\.js?$/,
            exclude: /node_modules/,
            loader: 'babel-loader',
            query: {
                presets: ['es2015'],
            },
        }, {
            test: /\.vue$/,
            loader: 'vue',
        }, {
            test: /\.json$/,
            loader: 'json-loader',
        }],
    },
    vue: {
        loaders: {
            scss: 'style!css!sass'
        }
    },
    externals: [
        'jquery-ui',
        {
            jquery: 'jQuery',
        },
    ],
    resolve: {
        alias: {
            vue$: 'vue/dist/vue.common.js',
            'styles': path.resolve(__dirname, './src/scss/')
        },
        extensions: ['', '.webpack.js', '.web.js', '.js', '.jsx'],
    },
};
