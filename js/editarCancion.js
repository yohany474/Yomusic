function editCancion(id, contenedor, ) {

    const contenedorElement = document.querySelector("." + contenedor);
    const formAutomatico = `
        <form method="post" action="controllers/saveChanges.php">
            <input type="text" name="newCambio" placeholder="Nuevo titulo" class="newName"  required >
            <input type="hidden" name="id" value="${id}">
            <input type="submit" value="Guardar cambios" class="save">
        </form>`;
    contenedorElement.insertAdjacentHTML('beforeend', formAutomatico);
}


