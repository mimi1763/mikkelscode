const { defineConfig } = require('@vue/cli-service')

module.exports = defineConfig({
  transpileDependencies: true,
  devServer: {
    proxy: {
      '^/customsearch/v1': {
        target: 'https://customsearch.googleapis.com',
        changeOrigin: true,
        secure: false,
        pathRewrite: {'^/customsearch/v1': '/customsearch/v1'},
        logLevel: 'debug'
      }
    },
  }
})