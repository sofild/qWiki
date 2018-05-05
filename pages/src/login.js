// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import Lf from './components/LoginForm'
import iView from 'iview';
import 'iview/dist/styles/iview.css';

Vue.config.productionTip = false

Vue.use(iView);

/* eslint-disable no-new */
let Login = new Vue({
  el: '#app',
  components: { Lf },
  template: '<Lf/>'
})

export default Login
