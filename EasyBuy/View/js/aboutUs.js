<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

    window.addEventListener('load', ()=>{
        document.getElementById('registro-vend-footer').hidden = true;
        document.getElementById('pqr-footer').hidden = true;
    });

    function logOut(){
        fetch('Controller/session/close.php')
        .then(response => response.json())
        .then(data => {
            var link = document.createElement('a');
            link.href = 'inicio';
            link.id = 'linkURL';
            document.body.appendChild(link);
            document.getElementById("linkURL").click();
        })
        .catch(error => console.error('Error al actualizar la sesión:', error));
    }
</script>