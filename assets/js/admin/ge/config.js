import('../../../css/admin/ge/config.css');
//import('babel-polyfill');

require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
require('select2');


const $ = require('jquery');
//import 'jquery-ui';

$(document).ready(function() {
    var data = {
        id: 9999999,
        text: ''
    };
    let newOption = new Option(data.text, data.id, false, false);
    $('.select2-form').append(newOption).trigger('change');
    $('.select2-form').val('');
    $('.select2-form').trigger('change');
    $('.select2-form').select2({
        placeholder: {
            id: '', // the value of the option
            text: 'Choisir une option'
        },
        allowClear: true,
    });

    let alltr = $('input[name*="gamme_enveloppe[operations]"], select[name*="gamme_enveloppe[operations]"]').closest('tr');

    alltr.each(function() {
        putRequiredAttr($(this));
    });


    $('input[name*="gamme_enveloppe[operations]"], select[name*="gamme_enveloppe[operations]"]').change(function() {

        let tr  = $(this).closest('tr');
        putRequiredAttr(tr);

    });

});

function putRequiredAttr(element) {
    let isempty = true;

    element.children().each(function(e) {
        if ($(this).children().val() !== '') {
            isempty = false;
        }
    });

    if(isempty) {
        element.children().children().attr('required', false);
    } else {
        element.children().children().attr('required', true);
    }
}
