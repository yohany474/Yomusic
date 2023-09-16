const form = document.getElementById("validarRegistro");
const enviarButton = document.getElementById("enviarRegistro");
const ventanaTerminos = document.getElementById("ventanaTerminos");
const aceptarCheckbox = document.getElementById("aceptar");
const confirmarButton = document.getElementById("confirmar");

form.addEventListener('submit', async (event) => {
    event.preventDefault();

    if (!aceptarCheckbox.checked) {
        ventanaTerminos.style.display = "grid"; // Mostrar la ventana emergente si los términos no están aceptados
        return; // Detener el envío del formulario
    }

    // Mostrar icono de carga y deshabilitar botón
    enviarButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registrando...';
    enviarButton.disabled = true;

    const formData = new FormData(form);

    try {
        const response = await fetch('../controllers/procesarUsuario.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.state === true) {
            form.reset();
            alert("Te has registrado correctamente");
            window.location.href = "login.html";
        } else if (data) {
            alert(data);
        }
    } catch (error) {
        alert(error);
    } finally {
        // Volver a mostrar texto original del botón y habilitar botón
        enviarButton.innerHTML = 'Registrarse';
        enviarButton.disabled = false;
    }
});

confirmarButton.addEventListener('click', () => {
    if (aceptarCheckbox.checked) {
        ventanaTerminos.style.display = "none"; // Ocultar la ventana emergente si se aceptan los términos
    }
});


const verButton = document.querySelector('.ver');
const contraseñaInput = document.querySelector('#password');

verButton.addEventListener('click', () => {
    if (contraseñaInput.type === 'password') {
        contraseñaInput.type = 'text';
        verButton.innerHTML = '<i class="fas fa-eye-slash"></i> Ocultar';
    } else {
        contraseñaInput.type = 'password';
        verButton.innerHTML = '<i class="fas fa-eye"></i> Ver';
    }
});