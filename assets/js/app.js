import('../css/bootstrap.css');
import('../css/app.css');
import('../bootstrap-datepicker/css/bootstrap-datepicker.css');

const $ = require('jquery');

require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
require('../bootstrap-datepicker/js/bootstrap-datepicker.js');
require('../bootstrap-datepicker/locales/bootstrap-datepicker.fr.min.js');

$('.js-datepicker').datepicker({
    language: "fr",
    format: "dd/mm/yyyy"
});

// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
