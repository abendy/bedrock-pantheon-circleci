const webpack = require('webpack');
const path = require('path');
const Dotenv = require('dotenv-webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const WebpackShellPlugin = require('webpack-shell-plugin');
const WebpackNotifierPlugin = require('webpack-notifier');

const { WP_ENV = 'development' } = process.env;

const base = {
  entry: {
    main: [
      './web/app/themes/related-blog/src/scripts/main.js',
      './web/app/themes/related-blog/src/styles/main.scss',
    ],
  },
  output: {
    path: path.join(__dirname, 'web/app/themes/related-blog/build/assets/scripts/'),
    filename: '[name].js',
  },
  module: {
    rules: [{
      enforce: 'pre',
      test: /\.js(x)*$/,
      exclude: /node_modules/,
      loader: 'eslint-loader',
      options: {
        'no-debugger': process.env.WP_ENV === 'production' ? 2 : 0,
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
      test: /\.jsx$/,
      exclude: /node_modules/,
      loader: 'babel-loader',
      options: {
        cacheDirectory: true,
        presets: [
          '@babel/preset-react',
        ],
      },
    },
    {
      test: /\.(sa|sc|c)ss$/,
      exclude: /node_modules/,
      use: [
        {
          loader: MiniCssExtractPlugin.loader,
          options: {
            hmr: process.env.WP_ENV === 'development',
          },
        },
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
    new WebpackShellPlugin({
      onBuildStart: [
        'rm -f web/app/themes/related-blog/build/assets/**/*.*',
      ],
    }),
    new MiniCssExtractPlugin({
      filename: '../styles/[name].css',
      chunkFilename: '[id].css',
    }),
    new webpack.LoaderOptionsPlugin({
      minimize: process.env.WP_ENV === 'production',
      debug: process.env.WP_ENV !== 'production',
    }),
  ],
};

const development = {
  ...base,
  mode: 'development',
  watch: true,
  devtool: 'source-map',
  module: {
    ...base.module,
  },
  plugins: [
    ...base.plugins,
    new WebpackNotifierPlugin({ excludeWarnings: true }),
  ],
};

const production = {
  ...base,
  mode: 'production',
  devtool: false,
  module: {
    ...base.module,
  },
  plugins: [
    ...base.plugins,
  ],
};

module.exports = (WP_ENV === 'development' ? development : production);
