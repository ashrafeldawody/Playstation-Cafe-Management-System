const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
    chainWebpack: config => {
        config
            .plugin('html')
            .tap(args => {
                args[0].title = "برنامج اداره محلات البلايستيشن";
                return args;
            })
    },
  transpileDependencies: true,
    lintOnSave: false,
  pluginOptions: {
    vuetify: {
			// https://github.com/vuetifyjs/vuetify-loader/tree/next/packages/vuetify-loader
		}
  }
})
