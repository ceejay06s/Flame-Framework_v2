const path = require('path')
const Dotenv = require('dotenv-webpack')
const HtmlWebpackPlugin = require('html-webpack-plugin');

module.exports = {
    mode: 'development',
    entry: './src/js/index.js',
    output: {
        filename: 'main.js',
        path: path.resolve(__dirname, 'app/assets/js')
    },
    plugins: [
        new Dotenv(),
        new HtmlWebpackPlugin({
            template: './src/default.html',
            filename: path.resolve(__dirname, 'app/views/layouts/default.layout'),
            inject: 'body'
        })
    ],
    module: {
        rules: [
            {
                test: /\.css$/i,
                use: ['style-loader', 'css-loader'],
            },
        ],
    },
    resolve: {
        fallback: {
            "crypto": false,
            "os": false
        }
    }
}