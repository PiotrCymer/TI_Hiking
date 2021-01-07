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

                    }
                }
            });
        }
    });

    $('.logoutBtn').on('click', function (event) {
        event.preventDefault();
        $.ajax({
            url: '/logout',
            method: 'POST',
            statusCode: {
                200: function (response) {
                    window.location.href = '/signin';
                }
            }
        });
    });

    function validateLoginForm() {
        let isValid = true;

        if (loginInput.val() === "") {
            errorsContainer.email.show();
            errorsContainer.email.text('Email field cannot be empty');
            isValid = false;
        } else {
            errorsContainer.email.hide();
            errorsContainer.email.text('');
        }

        if (passwordInput.val() === "") {
            errorsContainer.password.show();
            errorsContainer.password.text('Password field cannot be empty');
            isValid = false
        } else {
            errorsContainer.password.hide();
            errorsContainer.password.text('');
        }

        return isValid;
    }
});
