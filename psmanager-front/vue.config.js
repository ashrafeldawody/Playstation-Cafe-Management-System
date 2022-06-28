const {defineConfig} = require('@vue/cli-service')
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
        },
        electronBuilder: {
            // option: default // description
            disableMainProcessTypescript: false, // Manually disable typescript plugin for main process. Enable if you want to use regular js for the main process (src/background.js by default).
            mainProcessTypeChecking: false // Manually enable type checking during webpack bundling for background file.
        }

    },
})

