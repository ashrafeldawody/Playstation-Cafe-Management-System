import 'bootstrap/dist/css/bootstrap.rtl.css';
import 'vue-toast-notification/dist/theme-sugar.css';
import { createApp } from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import { loadFonts } from './plugins/webfontloader'
import router from './router'
import VueToast from 'vue-toast-notification';
loadFonts()

createApp(App)
    .use(vuetify)
    .use(router)
    .use(VueToast)
    .mount('#app')
