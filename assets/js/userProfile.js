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
});
