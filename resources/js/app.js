import {createApp} from 'vue';

import DeviceComponent from "./components/DeviceComponent.vue";
import DevicesPage from "./components/DevicesPage.vue";
import CafeCart from "./components/CafeCart.vue";
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';


const app = createApp({});
app.component('device-component', DeviceComponent);
app.component('devices-page', DevicesPage);
app.component('cafe-cart', CafeCart);
app.use(VueToast,{
    zIndex: 99999,
});
app.use(VueSweetalert2);

app.mount('#app');
