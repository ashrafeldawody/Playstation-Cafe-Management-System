// Styles
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'

// Vuetify
import { createVuetify } from 'vuetify'

export default createVuetify(
    {
        rtl: true,
        locale:{
            rtl: true,
            lang: 'ar',
        },
        icons: {
            iconfont: 'mdi',
        },
    }
)
