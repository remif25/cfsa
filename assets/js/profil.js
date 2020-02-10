import('../css/plugins/fv.css');
import('./plugins/fv.min');


var zxcvbn = require('zxcvbn');
require('./plugins/fv.min');

$(document).ready(function() {
    let password = document.getElementById('user_plainPassword');
    let $meter = $('#strengthBar');

    password.addEventListener('input', function() {

        var val = password.value,
            result = zxcvbn(val),
            score = result.score,
            message = result.feedback.warning || 'Le mot de passe est faible';


        switch (score) {
            case 0:
                $meter.attr('class', 'progress-bar bg-danger')
                    .css('width', '1%').attr('aria-valuenow', '1%');
                $meter.value = 1;
                break;
            case 1:
                $meter.attr('class', 'progress-bar bg-danger')
                    .css('width', '25%').attr('aria-valuenow', '25%');
                $meter.value = 25;
                break;
            case 2:
                $meter.attr('class', 'progress-bar bg-warning')
                    .css('width', '50%').attr('aria-valuenow', '50%');
                $meter.value = 50;
                break;
            case 3:
                $meter.attr('class', 'progress-bar bg-info')
                    .css('width', '75%').attr('aria-valuenow', '75%');
                $meter.value = 75;
                break;
            case 4:
                $meter.attr('class', 'progress-bar bg-success')
                    .css('width', '100%').attr('aria-valuenow', '100%');
                $meter.value = 100;
                break;
        }

        // We will treat the password as an invalid one if the score is less than 3
        if (score < 2) {
            password.className = 'form-control is-invalid';
            $('#user_save').attr('disabled', true);
            return {
                valid: false,
                message: message
            }
        } else {
            password.className = 'form-control is-valid';
            $('#user_save').attr('disabled', false);
            return {
                valid: true,
                message: message
            }
        }
    });

    $(".reveal").on('click',function() {
        var $pwd = $("#user_plainPassword");
        if ($pwd.attr('type') === 'password') {
            $pwd.attr('type', 'text');
        } else {
            $pwd.attr('type', 'password');
        }
    });
});