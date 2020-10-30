import Vue from 'vue'
import App from './App.vue'
import * as VueGoogleMaps from "vue2-google-maps";

Vue.config.productionTip = false
Vue.config.devtools = true

Vue.use(VueGoogleMaps, {
  load: {
    key: "AIzaSyAvN-whWf7appqINl4lpCStDb6xAsVm44k",
    libraries: "places" 
  }
});

new Vue({
  render: h => h(App),
}).$mount('#app')
