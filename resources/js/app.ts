import {createApp} from "vue";

import {store} from "./store";
import {router} from "./router";

import App from './App.vue'

const app = createApp(App)
    .use(store)
    .use(router);

app.mount("#app");
