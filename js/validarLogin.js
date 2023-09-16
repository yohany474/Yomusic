form = document.querySelector("#validar");
const enviarButton = document.querySelector("#enviar"); // Agrega un identificador al botón

form.addEventListener('submit', (event) => {
    event.preventDefault();

    const formData = new FormData(form);

    // Mostrar icono de carga y deshabilitar botón
    enviarButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Validando...';
    enviarButton.disabled = true;

    fetch('../controllers/validarUsuario.php', {
        method: 'POST',
        body: formData
    })
        .then((response) => response.json())
        .then(data => {
            if (data == 'success') {
                form.reset();
                window.location.href = "../index.php";
            } else {
                alert((data));
            }
        })
        .catch(error => {
            alert(error);
        })
        .finally(() => {
            // Volver a mostrar texto original del botón y habilitar botón
            enviarButton.innerHTML = 'Enviar';
            enviarButton.disabled = false;
        });
});


const verButton = document.querySelector('.ver');
const contraseñaInput = document.querySelector('#Contraseña');

verButton.addEventListener('click', () => {
    if (contraseñaInput.type === 'password') {
        contraseñaInput.type = 'text';
        verButton.innerHTML = '<i class="fas fa-eye-slash"></i> Ocultar';
    } else {
        contraseñaInput.type = 'password';
        verButton.innerHTML = '<i class="fas fa-eye"></i> Ver';
    }
});