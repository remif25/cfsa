import('../../../css/admin/ge/config.css');
import('babel-polyfill');

require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
require('select2');


const $ = require('jquery');
//import 'jquery-ui';

$(document).ready(function() {
   let gamme_enveloppe_id = $('#gamme_enveloppe_id').val();
    /*let newOption = new Option(data.text, data.id, false, false);
    $('.select2-form').append(newOption).trigger('change');
    $('.select2-form').val('');
    $('.select2-form').trigger('change');*/
    $('.select2-form').select2({
        placeholder: {
            id: '', // the value of the option
            text: 'Choisir une option'
        },
        allowClear: true,
    });
    $('.select2-form').select2('data');

    let alltr = $('tbody > tr');

    alltr.each(function() {
        putRequiredAttr($(this));
    });

    $('th input[name*="gamme_enveloppe[operations]"], td input[name*="gamme_enveloppe[operations]"], select[name*="gamme_enveloppe[operations]"]').change(function() {

        let tr  = $(this).closest('tr');
        putRequiredAttr(tr);

    });

    $('tbody > tr > td:last-child').click(function() {
        let numero_ligne = $(this).data('key');
        let operation_id = $('.ligne-' + numero_ligne + ' input[name$="[id]"]').val();

        if (deleteOP(operation_id, gamme_enveloppe_id)) {
            $('.ligne-' + numero_ligne).hide(400, function() {
                $(this).remove();
            });
        }

    })

});

function putRequiredAttr(element) {
    let isempty = true;
    let regleIsEmpty = true;

    element.children().each(function() {
        if ($(this).children().val()) {
            isempty = false;
        }
        let name = $(this).children().attr('name');
        if (name) {
            if (name.includes(['regle']) && $(this).children().val()) {
                regleIsEmpty = false;
            }
        }
    });

    if(isempty) {
        element.children().children().attr('required', false);
    } else {
        element.children().children().attr('required', true);
    }

    if(regleIsEmpty) {
        element.children().children('select[name$="[regle]"]').attr('required', false);
        element.children().children('input[name$="[branche]"]').attr('required', false);
    } else {
        element.children().children('select[name$="[regle]"]').attr('required', true);
        element.children().children('input[name$="[branche]"]').attr('required', true);
    }
}

function deleteOP(operation_id, ge_id) {
    let getUrl = window.location;
    let baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    let link = baseUrl + "/api/ge/deleteop";
    if(operation_id) {
        (async () => {
            const rawResponse = await fetch(link, {
                method: 'POST',
                body: JSON.stringify({operation_id: operation_id, ge_id: ge_id})
            });
            const content = await rawResponse.json();


            if (content['status'] === 'ok')
                return true;

            return false;
        })();
    }
    return true;
}