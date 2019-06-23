const webpack = require('webpack');
const path = require('path');
const Dotenv = require('dotenv-webpack');

const { NODE_ENV = 'development' } = process.env;

const base = {
  entry: {
    content: [
      './src/scripts/main.js',
      './src/styles/main.scss',
    ],
  },
  output: {
    path: path.join(__dirname, 'build/assets/scripts/'),
    filename: '[name].js',
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
};

const production = {
  ...base,
  mode: 'production',
  module: {
    ...base.module,
  },
};

module.exports = (NODE_ENV === 'development' ? development : production);
