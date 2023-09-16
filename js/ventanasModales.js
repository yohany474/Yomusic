function abrirModal(ventana, botonCerrar) {
    const ventanaModal = document.getElementById(ventana);
    const cerrarBoton = document.getElementById(botonCerrar);

        ventanaModal.classList.add('modalActive');
    
    cerrarBoton.addEventListener('click', () => {
        ventanaModal.classList.remove('modalActive');
    });
}


//viewProfile
document.getElementById('viewProfile').addEventListener('click', ()=>{
    document.getElementById('profile').classList.add('perfilActive');
})

document.getElementById('closeProfile').addEventListener('click', ()=>{
    document.getElementById('profile').classList.remove('perfilActive');
})



//Editar perfil cerrar

function cerrarVentanaEditar(){
    document.getElementById("ventanaEdit").classList.remove("modalActive");
}
    


// Información de una playlist publica privada
var selecttipo = document.getElementById('publica_privada');
var informacionTipo = document.getElementById('informaciontipo');

selecttipo.addEventListener('change', () => {
    if (selecttipo.value === 'Publica') {
        informacionTipo.innerText = 'Una playlist pública es accesible para todos los usuarios. Cualquier persona puede ver y acceder a la playlist, así como sus contenidos y detalles.';
    } else if (selecttipo.value === 'Privada') {
        informacionTipo.innerText = 'Una playlist privada solo es accesible por ti, el propietario. Nadie más puede ver ni acceder a la playlist ni a sus contenidos.';
    } else {
        informacionTipo.innerText = 'Selecciona si la playlist será pública o privada para obtener información sobre sus permisos.';
    }
});

//MODO OSCURO CLARO//

// const changeThem = document.getElementById('changeThem');
// const root = document.documentElement;
// cont = 1;
// changeThem.addEventListener('click', () => {
//     if(cont ===1){
//         root.style.setProperty('--color-principal', '#FFFFFF');
//         root.style.setProperty('--color-titulo', '#ffda6b');
//         root.style.setProperty('--color-contenido', '#fff5f5');
//         root.style.setProperty('--color-claro', '#b7b7b7');
//         root.style.setProperty('--color-borde', '#757575');
//         root.style.setProperty('--color-contenedor', '#F0F0F0');
//         root.style.setProperty('--color-fondo-cuerpo', '#F5F5F5');


//         document.getElementById('icono').classList.remove('fa-lightbulb');
//         document.getElementById('icono').classList.add('fa-adjust');

//         document.querySelector('.menu').style.shadow ='box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;';


//         cont  =0;
//     }else if(cont === 0){
//         root.style.setProperty('--color-principal', '#ffbf00');
//         root.style.setProperty('--color-titulo', '#eff3f5');
//         root.style.setProperty('--color-contenido', '#c8cdd0');
//         root.style.setProperty('--color-claro', '#a0a7ac');
//         root.style.setProperty('--color-borde', '#2a3b47');
//         root.style.setProperty('--color-contenedor', '#212e36');
//         root.style.setProperty('--color-fondo-cuerpo', '#192229');
//         document.getElementById('icono').classList.remove('fa-adjust');
//         document.getElementById('icono').classList.add('fa-lightbulb');
       
//         cont  =1;
//     }

// });

