import * as Spin from "./spin";

$(document).ready(function () {

    const target = document.getElementById('addHikingLoader');
    const spinner = new Spin.Spinner();

    $('#startDate').flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true,
        locale: {
            months: {
                shorthand: ['Sty', 'Lut', 'Mar', 'Kwi', 'Maj', 'Cze', 'Lip', 'Sie', 'Wrz', 'Paź', 'Lis', 'Gru'],
                longhand: ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'],
            },
        },
    });

    $('#endDate').flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true,
        locale: {
            months: {
                shorthand: ['Sty', 'Lut', 'Mar', 'Kwi', 'Maj', 'Cze', 'Lip', 'Sie', 'Wrz', 'Paź', 'Lis', 'Gru'],
                longhand: ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'],
            },
        },
    });

    $('.saveHiking').on('click', function (event) {
        event.preventDefault();
        let form = $('#newHikingForm');
        $('#addHikingLoader').show(200);
        spinner.spin(target);
        $('.saveHiking').hide();
        let formData = form.serialize();

        let x = new FormData($('#newHikingForm').get(0));

        $.ajax({
            url: '/profil-uzytkownika/nowa-wedrowka',
            method: 'post',
            data: x,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            statusCode: {
                200: function (response) {
                    window.location.href = '/profil-uzytkownika';
                },
                400: function (response) {
                    $('#newHikingError').show();
                    $('#newHikingError').text(response.responseJSON.message);
                    $('#addHikingLoader').hide();
                    spinner.stop();
                    $('.saveHiking').show();
                }
            }
        });
    });

    $('#hikingImages').on('change', function (event) {
        previewImages(this);
    });

    $('#hikingVideo').on('change', function (event) {
        previewVideo(this);
    });

    function previewImages(input) {

        if (input.files && input.files[0]) {
            $('.imagesPreview').html('');

            var filesCnt = input.files.length;
            for (let i = 0; i < filesCnt; i++) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.imagesPreview').append("<div class='col-md-4 mt-2'><img class='singleImagePreview' src='" + e.target.result + "' /></div>");
                };
                reader.readAsDataURL(input.files[i]);
            }
        }
    }

    function previewVideo(input) {
        $('.videoPreview').show();
        if (input.files && input.files[0]) {

            $('#hikingVideoPreview').attr('src', URL.createObjectURL(input.files[0]));
        }
    }
});
