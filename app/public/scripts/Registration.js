$(() => {
    const confirmButton = $('#confirmButton');
    const emailInput = $('#emailInput');
    const nameInput = $('#nameInput');
    const passwordInput = $('#passwordInput');

    confirmButton.on('click', () => {
        $.ajax({
            type: 'POST',
            url: '/registrationConfirm',
            data: {
                email: emailInput.val(),
                name: nameInput.val(),
                password: passwordInput.val(),
            }
        }).done((response) => {
            window.location.replace(response.redirectPage);
        }).fail((response) => {
            alert(response.responseText);
        });
    });
});