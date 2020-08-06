window.Vue = require('vue');
window.moment = require('moment');

Vue.filter('timeFormat', function (arg){
   return moment(arg).format('MMMM Do YYYY, h:mm:ss a')
});
