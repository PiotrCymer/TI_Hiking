import * as Spin from "./spin";


$(function () {

    const target = document.getElementById('spinner');
    const spinner = new Spin.Spinner();


    const loginInput = $('#inputEmail');
    const passwordInput = $('#inputPassword');
    const form = $('#signInForm');

    const errorsContainer = {
        email: $('#emailError'),
        password: $('#passwordError'),
        login: $('#loginError')
    };


    $('#signInBtn').on('click', event => {
        event.preventDefault();

        if (validateLoginForm()) {
            $('#signInBtn').hide();
            $('.registerInfo').hide();
            spinner.spin(target);


            $.ajax({
                url: '/signin',
                method: 'POST',
                data: {
                    action: 'signin',
                    login: loginInput.val(),
                    password: passwordInput.val()
                },
                dataType: 'json',
                statusCode: {
                    200: function (response) {
                        window.location.href = '/profil-uzytkownika';
                    },
                    401: function (response) {
                        errorsContainer.login.show();
                        errorsContainer.login.text(response.responseJSON.message);
                        spinner.stop();
                        $('#signInBtn').show();
                        $('.registerInfo').show();

                    }
                }
            });
        }
    });

    function validateLoginForm() {
        let isValid = true;

        if (loginInput.val() === "") {
            errorsContainer.email.show();
            errorsContainer.email.text('Adres e-mail nie może być pusty');
            isValid = false;
        } else {
            errorsContainer.email.hide();
            errorsContainer.email.text('');
        }

        if (passwordInput.val() === "") {
            errorsContainer.password.show();
            errorsContainer.password.text('Pole z hasłem nie może być puste');
            isValid = false
        } else {
            errorsContainer.password.hide();
            errorsContainer.password.text('');
        }

        return isValid;
    }
});
