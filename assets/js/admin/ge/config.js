import('../../../css/admin/ge/config.css');
require('babel-polyfill');

require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
require('select2');


const $ = require('jquery');
const pdts = getDatas('pdts', 'null');
const activites = getDatas('activites', 'null');

const test = 'test2';

$.fn.select2.amd.define('select2/data/customAdapter',
    ['select2/data/array', 'select2/utils'],
    function (ArrayAdapter, Utils) {
        function CustomDataAdapter ($element, options) {
            CustomDataAdapter.__super__.constructor.call(this, $element, options);
        }
        Utils.Extend(CustomDataAdapter, ArrayAdapter);
        CustomDataAdapter.prototype.updateOptions = function (data) {
            this.$element.find('option').remove(); // remove all options
            this.addOptions(this.convertToOptions(data));
        }
        return CustomDataAdapter;
    }
);

var customAdapter = $.fn.select2.amd.require('select2/data/customAdapter');

async function getDatas(object, constraint) {
    let link = 'api/ge/' + object + '/' + constraint;
    const rawResponse = await fetch(link, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },

    });
    return await rawResponse.json();
}
//import 'jquery-ui';

$(document).ready(function() {
    let gamme_enveloppe_id = $('#gamme_enveloppe_id').val();

     $('.select2-form').change( async function () {
        let type_object = $(this).data('type_object');
        let id_op = $(this).closest('tr').attr('class').split('ligne-')[1];
        let tmpString = '';
        let constraint = '';

        if (type_object === 'pdts')
            tmpString = 'activites';
        else if (type_object === 'activites')
            tmpString = 'pdts';
        else
            tmpString = 'linkregleoperation_' + type_object;

        let select2_ = '#gamme_enveloppe_operations_' + id_op + '_' + tmpString.slice(0, -1);

        if ($(this).val() && tmpString !== 'regles')
            constraint = $(this).children('option:selected').val();
        else if (tmpString === 'regles')
            constraint = $('#gamme_enveloppe_id').val();
        else {
            constraint = 'null';
            try {
                const options = await getDatas(tmpString, constraint);
                if (options.success) {
                    $(this).data('select2').dataAdapter.updateOptions(options.results).trigger('change');
                }
            } catch (error) {
                $(this).val(null);
                console.log(error);
            }
        }
        let value = $(select2_).val();
        try {
            const datas = await getDatas(type_object, constraint);
            if (datas.success) {
                $(select2_).data('select2').dataAdapter.updateOptions(datas.results).trigger('change');
                $(select2_).val(value);
            }
        } catch (error) {
            $(select2_).val(value);
            console.log(error);
        }
    });

    $('.select2-form').select2({
        dataAdapter: customAdapter,
        placeholder: {
            id: '', // the value of the option
            text: 'Choisissez une option'
        },
        allowClear: true,
        multiple: false
    });
    //$('.select2-form').select2('data');

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