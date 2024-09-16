document.getElementById('logoutLink').addEventListener('click', function (event) {
    event.preventDefault(); // Prevent the default anchor tag behavior

    document.getElementById('logoutForm').submit(); // Submit the form
});