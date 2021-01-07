import * as Spin from "./spin";

$(function () {
    const target = document.getElementById('spinner');
    const spinner = new Spin.Spinner();

    const emailInput = $('#inputEmail');
    const nameInput = $('#inputNewName');
    const surnameInput = $('#inputNewSurname');
    const passwordInput = $('#inputNewPassword');
    const repeatPasswordInput = $('#inputNewPasswordRepeat');

    const errorsContainer = {
        email: $('#newEmailError'),
        password: $('#newPasswordError'),
        name: $('#newNameError'),
        surname: $('#newSurnameError'),
        passwordRepeat: $('#newPasswordRepeatError'),
        register: $('#registerError')
    };

    $('.registerBtn').on('click', function (event) {
        event.preventDefault();

        if (validateRegisterForm()) {
            $('.registerBtn').hide();
            spinner.spin(target);

            $.ajax({
                url: '/rejestracja',
                method: 'POST',
                data: {
                    action: 'register',
                    email: emailInput.val(),
                    password: passwordInput.val(),
                    name: nameInput.val(),
                    surname: surnameInput.val()
                },
                dataType: 'json',
                statusCode: {
                    200: function (response) {
                        spinner.stop();
                        errorsContainer.register.hide();
                        $("#registerSuccess").show();
                        $("#registerSuccess").html("Rejestracja przebiegła pomyślnie!<br /><a href='/signin'>Klknij tutaj</a> aby się zalogować");
                    },
                    400: function (response) {
                        errorsContainer.register.show();
                        errorsContainer.register.text(response.responseJSON.message);
                        spinner.stop();
                        $('#signInBtn').show();

                    },
                    401: function (response) {
                        errorsContainer.register.show();
                        errorsContainer.register.text(response.responseJSON.message);
                        spinner.stop();
                        $('#signInBtn').show();

                    }
                }
            });
        }


    });

    function validateRegisterForm() {
        let isValid = true;

        if (emailInput.val() == "") {
            errorsContainer.email.show();
            errorsContainer.email.text('Adres e-mail nie może być pusty');
            isValid = false;
        } else {
            errorsContainer.email.hide();
            errorsContainer.email.text('');
        }

        if (nameInput.val() == "") {
            errorsContainer.name.show();
            errorsContainer.name.text('Proszę podać imię');
            isValid = false;
        } else {
            errorsContainer.name.hide();
            errorsContainer.name.text('');
        }

        if (surnameInput.val() == "") {
            errorsContainer.surname.show();
            errorsContainer.surname.text('Proszę podać nazwisko');
            isValid = false;
        } else {
            errorsContainer.surname.hide();
            errorsContainer.surname.text('');
        }

        if (passwordInput.val() == "") {
            errorsContainer.password.show();
            errorsContainer.password.text('Proszę podać hasło');
            isValid = false;
        } else if (passwordInput.val() != repeatPasswordInput.val()) {
            errorsContainer.password.show();
            errorsContainer.password.text('Podane hasła muszą być identyczne');
            isValid = false;
        } else {
            errorsContainer.password.hide();
            errorsContainer.password.text('');
        }

        if (repeatPasswordInput.val() == "") {
            errorsContainer.passwordRepeat.show();
            errorsContainer.passwordRepeat.text('Proszę ponownie wpisać nowe hasło');
            isValid = false;
        } else {
            errorsContainer.passwordRepeat.hide();
            errorsContainer.passwordRepeat.text('');
        }

        return isValid;
    }
});
