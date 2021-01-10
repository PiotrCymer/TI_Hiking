$(document).ready(function() {
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

    $('#sortBtn').on('click', function() {
        let sortOrder = $('#sortOrder').val();

        $.ajax({
            url: '/profil-uzytkownika',
            method: 'post',
            data: {
                action: 'sort',
                sortOrder: sortOrder
            }
        }).done(function(response) {
            console.log(1);
            console.log(response.body);
            $('#tableBody').html(response.body);
        });
    });
});
