const path = require("path");
const webpack = require("webpack");

module.exports = {
    entry: [
        './webapp/app.js'
    ],
    output: {
        path: path.resolve(__dirname, "public/webapp"),
        filename: "app.js"
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: [
                            '@babel/preset-env',
                            '@babel/preset-react'
                        ],
                        plugins: [
                            '@babel/plugin-transform-runtime'
                        ]
                    }
                }
            },
            {
                test: /\.css$/,
                use: ["style-loader", "css-loader"],
            }
        ]
    },
    resolve: {
        modules: [
            path.resolve(__dirname, 'node_modules'),
            path.resolve(__dirname, 'webapp'),
        ],
        extensions: [".js"]
    },
};
