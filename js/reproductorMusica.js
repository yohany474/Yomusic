// Obtener elementos del DOM
const reproductorPrincipal = document.getElementById('reproductorPrincipal');
const nombreCancion = document.getElementById('nombreCancion');
const rutaCancionElement = document.getElementById('rutaCancion');
const pausarCancionBtn = document.getElementById('pausarCancion');
const siguienteCancionBtn = document.getElementById('siguienteCancion');
const cancionAnterior = document.getElementById('cancionAnterior');
const listaCanciones = document.querySelectorAll('.playCancion');



// Configuración inicial
var controlTiempo = document.querySelector('#controlTiempo');
let cancionActual = 0;

// Event listener para el control de tiempo
controlTiempo.addEventListener('change', () => {
    rutaCancionElement.currentTime = controlTiempo.value;
})




// Función para reproducir una canción
function reproducirCancion(ruta) {

    pausarCancionBtn.disabled = false;
    if (rutaCancionElement.src !== ruta) {
        rutaCancionElement.src = ruta;
    }
    rutaCancionElement.play();
    pausarCancionBtn.innerHTML = '<i class="fa-solid fa-pause"></i>';
    avanzarControlTiempo();

}



// Función para reproducir la siguiente canción automáticamente
function reproducirSiguienteCancionAutomaticamente() {
    cancionActual = (cancionActual + 1) % listaCanciones.length;
    const rutaSiguienteCancion = listaCanciones[cancionActual].getAttribute('data-ruta');
    const rutaSiguienterNombre = listaCanciones[cancionActual].getAttribute('data-nombre');
    nombreCancion.textContent = ` ${rutaSiguienterNombre}`;
    reproducirCancion(rutaSiguienteCancion);
    avanzarControlTiempo();
}

// Event listener para el evento 'ended'
rutaCancionElement.addEventListener('ended', () => {
    reproducirSiguienteCancionAutomaticamente();
});


// Función para pausar una canción
function pausarCancion() {
    rutaCancionElement.pause();
    pausarCancionBtn.innerHTML = '<i class="fa-solid fa-play"></i>';
    iconoCancion.innerHTML = '<i class="fa-solid fa-pause"></i>';

}

// Función para reproducir la siguiente canción
function reproducirSiguienteCancion() {
    cancionActual = (cancionActual + 1) % listaCanciones.length;
    const rutaSiguienteCancion = listaCanciones[cancionActual].getAttribute('data-ruta');
    const rutaSiguienterNombre = listaCanciones[cancionActual].getAttribute('data-nombre');
    nombreCancion.textContent = ` ${rutaSiguienterNombre}`;
    reproducirCancion(rutaSiguienteCancion);
    avanzarControlTiempo();
}

// Event listener para el botón de siguiente canción
siguienteCancionBtn.addEventListener('click', () => {
    reproducirSiguienteCancion();
});


// Función para reproducir la canción anterior
function reproducirCancionAnterior() {
    // Calcular la posición de la canción anterior en la lista circular
    cancionActual = (cancionActual - 1 + listaCanciones.length) % listaCanciones.length;
    const rutaAnteriorCancion = listaCanciones[cancionActual].getAttribute('data-ruta');
    const rutaAnteriorNombre = listaCanciones[cancionActual].getAttribute('data-nombre');
    nombreCancion.textContent = `${rutaAnteriorNombre}`;
    reproducirCancion(rutaAnteriorCancion);
    avanzarControlTiempo(); // Avanzar el control de tiempo automáticamente
}

// Event listener para el botón de canción anterior
cancionAnterior.addEventListener('click', () => {
    reproducirCancionAnterior();
});

pausarCancionBtn.disabled = true;

// Event listener para el botón de pausar/reproducir canción
pausarCancionBtn.addEventListener('click', () => {
  
  
    if (rutaCancionElement.paused) {
        reproducirCancion(rutaCancionElement.src);
    }
    else {
        pausarCancion();
    }
});

// Event listener para cada canción en la lista
listaCanciones.forEach((cancion, index) => {
    var iconoCancion = cancion.querySelector('i'); // Selecciona el icono dentro del elemento de la canción

    cancion.addEventListener('click', () => {
        cancionActual = index;
        const rutaCancion = cancion.getAttribute('data-ruta');
        const nombreCancionItem = cancion.getAttribute('data-nombre');
        nombreCancion.textContent = ` ${nombreCancionItem}`;

        if (cancionActual.src === rutaCancion) {
            if (rutaCancionElement.paused) {
                reproducirCancion(rutaCancion);
          
            }
        } else {
            reproducirCancion(rutaCancion);
            
        }
    });
});




// Función para formatear el tiempo en minutos y segundos
function formatearTiempo(segundos) {
    const minutos = Math.floor(segundos / 60);
    const segundosRestantes = Math.floor(segundos % 60);
    return `${minutos}:${segundosRestantes < 10 ? '0' : ''}${segundosRestantes}`;
}

// Función para avanzar el control de tiempo y mostrar la duración transcurrida
function avanzarControlTiempo() {
    const duracionTotal = rutaCancion.duration;
    const valorActual = rutaCancion.currentTime;

    controlTiempo.max = duracionTotal;
    controlTiempo.value = valorActual;

    const tiempoTranscurrido = formatearTiempo(valorActual);
    const tiempoTotal = formatearTiempo(duracionTotal);

    document.getElementById('tiempoTranscurrido').innerText = tiempoTranscurrido;
    document.getElementById('tiempoTotal').innerText = tiempoTotal;

    if (!rutaCancion.paused && !rutaCancion.ended) {
        requestAnimationFrame(avanzarControlTiempo);
    }
}

// Función para cambiar el icono de volumen/mute
function cambiarIconoMuteVolumen() {
    const iconoMute = document.querySelector('#mute i');
    iconoMute.classList.toggle('fa-volume-mute');
    iconoMute.classList.toggle('fa-volume-up');
}

// Obtención del botón de mute
const botonMute = document.getElementById('mute');

// Evento de clic en el botón de mute
botonMute.addEventListener('click', () => {
    rutaCancion.muted = !rutaCancion.muted;
    cambiarIconoMuteVolumen();
});





