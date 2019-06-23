const webpack = require('webpack');
const path = require('path');
const Dotenv = require('dotenv-webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

const { NODE_ENV = 'development' } = process.env;

const base = {
  entry: {
    main: [
      './src/scripts/main.js',
      './src/styles/main.scss',
    ],
  },
  output: {
    path: path.join(__dirname, 'build/assets/scripts/'),
    filename: '[name].js',
  },
  module: {
    rules: [{
      enforce: 'pre',
      test: /\.js(x)*$/,
      exclude: /node_modules/,
      loader: 'eslint-loader',
      options: {
        'no-debugger': process.env.NODE_ENV === 'production' ? 2 : 0,
      },
    },
    {
      test: /\.js$/,
      exclude: /node_modules/,
      loader: 'babel-loader',
      options: {
        cacheDirectory: true,
        presets: [
          '@babel/preset-env',
        ],
      },
    },
    {
      test: /\.(sa|sc|c)ss$/,
      exclude: /node_modules/,
      use: [
        (NODE_ENV === 'development' ? MiniCssExtractPlugin.loader : 'style-loader'),
        'css-loader',
        'sass-loader',
      ],
    },
    {
      test: /\.(png|jp(e*)g|svg)$/,
      use: [{
        loader: 'url-loader',
        options: {
          limit: 8000, // Convert images < 8kb to base64 strings
          name: 'images/[hash]-[name].[ext]',
        },
      }],
    }],
  },
  plugins: [
    new Dotenv(),
  ],
};

const development = {
  ...base,
  mode: 'development',
  watch: true,
  module: {
    ...base.module,
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: '../styles/[name].css',
      chunkFilename: '[id].css',
    }),
    new webpack.LoaderOptionsPlugin({
      minimize: false,
      debug: true,
    }),
  ],

};

const production = {
  ...base,
  mode: 'production',
  devtool: 'source-map',
  module: {
    ...base.module,
  },
  plugins: [
    new webpack.LoaderOptionsPlugin({
      minimize: true,
      debug: false,
    }),
  ],
};

module.exports = (NODE_ENV === 'development' ? development : production);
