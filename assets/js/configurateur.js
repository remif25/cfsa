require('../css/configurateur.css');
require('bootstrap/js/dist/modal');

import '../scss/main.scss'

$(document).ready(function() {

    $('.has-regle').hover(function() {
        let id_regle = $(this).data('regle_id');
        $('.regle_id-' + id_regle).addClass('selected-regle');
    });
    $('.has-regle').mouseout(function() {
        let id_regle = $(this).data('regle_id');
        $('.regle_id-' + id_regle).removeClass('selected-regle');
    });

    $('.has-regle').click(function() {
        let id_regle = $(this).data('regle_id');
        $('#modalRegle' + id_regle).modal();
    });
    $('.has-regle').removeClass('selected-regle');
});