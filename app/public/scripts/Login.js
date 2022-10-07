$(() => {
    const confirmButton = $('#confirmButton');
    const emailInput = $('#emailInput');
    const passwordInput = $('#passwordInput');

    confirmButton.on('click', () => {
        $.ajax({
            type: 'POST',
            url: '/loginConfirm',
            data: {
                email: emailInput.val(),
                password: passwordInput.val(),
            }
        }).done((response) => {
            document.cookie = 'seaOfRecipesToken=' + response.token;
            window.location.replace('/');
        }).fail((response) => {
            alert(response.responseText);
        });
    });
});