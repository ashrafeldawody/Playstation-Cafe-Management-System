import 'vuetify/styles' // Global CSS has to be imported
import 'bootstrap/dist/css/bootstrap.min.css'
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { createVuetify } from 'vuetify'
import '@mdi/font/css/materialdesignicons.css'

import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
    components,
    directives,
})

createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(vuetify,{
                rtl: true,
                icons: {
                    iconfont: 'mdi',
                }
            })
            .mount(el)
    },
})
