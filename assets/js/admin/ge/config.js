import('../../../css/admin/ge/config.css');
//import('babel-polyfill');

require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
require('select2');


const $ = require('jquery');
//import 'jquery-ui';

$(document).ready(function() {
    $('.select2-form').select2();
});
