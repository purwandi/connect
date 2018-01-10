const mix = require('laravel-mix');
const webpack = require('webpack');
const path = require('path');
const glob = require('glob-all');
const fs = require('fs')

const HtmlWebpackPlugin = require('html-webpack-plugin');
const PurifyCSSPlugin = require('purifycss-webpack');
const SWPrecacheWebpackPlugin = require('sw-precache-webpack-plugin')
const CleanWebpackPlugin = require('clean-webpack-plugin')

mix.setPublicPath('public/')

mix.webpackConfig({
  output: {
    filename: '[name].[chunkhash].js',
    chunkFilename: './js/[name].[chunkhash].js',
  },
  module: {
    loaders: [
      { test: /\.hbs$/, loader: 'handlebars-loader' },
    ]
  },
  plugins: [
    new CleanWebpackPlugin('./public/js/*.js*'),
    new webpack.optimize.CommonsChunkPlugin({
      name: '/js/vendor',
      minChunks: (module) => {
        return module.context && module.context.indexOf('node_modules') !== -1
      }
    }),
    // extract webpack runtime and module manifest to its own file in order to
    // prevent vendor hash from being updated whenever app bundle is updated
    new webpack.optimize.CommonsChunkPlugin({
      name: 'manifest',
      chunks: ['vendor']
    }),
    new PurifyCSSPlugin({
      paths: glob.sync([
        path.join(__dirname, 'resources/js/**/*.pug'),
        path.join(__dirname, 'resources/js/**/*.vue')
      ]),
    }),
    new SWPrecacheWebpackPlugin({
      cacheId: 'tanibox',
      filename: 'service-worker.js',
      staticFileGlobs: ['public/**/*.{js,html,css}'],
      minify: true,
      stripPrefix: 'public/'
    }),
    new HtmlWebpackPlugin({
      filename: '../resources/views/app.blade.php',
      template: './resources/index.hbs',
      inject: true,
      chunkSortMode: 'dependency',
      serviceWorkerLoader: `<script>${fs.readFileSync(path.join(__dirname,
        mix.inProduction() ? './resources/js/service-worker-prod.js' : './resources/js/service-worker-dev.js'), 'utf-8')}</script>`
    })
  ],
  resolve: {
    extensions: [
      ".vue"
    ]
  }
})

mix.js('resources/js/app.js', 'public/js');
mix.sass('resources/sass/app.scss', 'public/css');
