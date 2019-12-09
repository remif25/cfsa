require('../css/configurateur.css');
require('bootstrap/js/dist/modal');

import '../scss/main.scss'


$(document).ready(function() {


    $('.has-regle').hover(function() {
        let id_regle = $(this).data('regle_id');
        $('.regle_id-' + id_regle).toggleClass('selected-regle');
    });
    $('.has-regle').click(function() {
        let id_regle = $(this).data('regle_id');
        $('#modalRegle' + id_regle).modal();
    });
    $('.has-regle').removeClass('selected-regle');

    $('button[name="save"]').click(function() {
        let regle_id  = $(this).data('regle');
        /*$('#modalRegle' + regle_id + ' input').attr('required', true);*/
        let conf = parseInt($('#modalRegle' + regle_id + ' input:checked').val());

        if (conf >= 0) {
            $('#regle-' +regle_id).val(conf);
            hideModalAndOP(regle_id, conf, hideOp);
        }
    });

    function hideOp(regle_id, conf) {
        let configurations = $('.configurateur').data('configurations');
        let regle = configurations.configurations[regle_id];
        regle.forEach(function(item) {
            let ligne = $('.operation-id-' + item.id);
            if(item.linkregleoperation.branches[conf]) {
                ligne.removeClass('no-selected')
                    .removeClass('py-1')
                    .addClass('is-selected')
                    .addClass('py-2');
            } else {
                ligne.addClass('no-selected')
                    .addClass('py-1')
                    .removeClass('is-selected')
                    .removeClass('py-2');
            }
        });
    }
    function hideModalAndOP(regle_id, conf, callback) {
        $('#modalRegle' + regle_id).modal('hide');
        callback(regle_id, conf);
    }

});

