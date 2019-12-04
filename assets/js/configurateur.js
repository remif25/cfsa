require('../css/configurateur.css');
require('bootstrap/js/dist/modal');

$(document).ready(function() {
    $('.has-regle').hover(function() {
        let id_regle = $(this).data('regle_id');
        $('.regle_id-' + id_regle).toggleClass('selected-regle');
    });

    $('.has-regle').click(function() {
        let id_regle = $(this).data('regle_id');
        $('#modalRegle' + id_regle).modal();
    });
});