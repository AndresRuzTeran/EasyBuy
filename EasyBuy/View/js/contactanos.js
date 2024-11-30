<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    var modalExitoso = bootstrap.Modal.getOrCreateInstance('#modalSuccess');
    var modalError = bootstrap.Modal.getOrCreateInstance('#modalError');

    window.addEventListener('load', ()=>{
        document.getElementById('registro-vend-footer').hidden = true;
        document.getElementById('pqr-footer').hidden = true;
    });

    function enviar(){
        event.preventDefault();
        let form = document.getElementById('pqrsForm');
        form.classList.add('was-validated');

        if (form.checkValidity()) {
            var data = [];
            form.querySelectorAll("input, select, textarea").forEach(function(element) {
                data.push(element.value);
            });
            fetch("Controller/pqrs/nuevoPqrs.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(res => {
                if(res.resultado){
                    document.getElementById("mensajeSuccess").innerHTML = res.mensaje;
                    modalExitoso.show();
                    form.reset();
                    form.classList.remove('was-validated');
                }else{
                    document.getElementById("mensajeError").innerHTML = res.mensaje;
                    modalError.show();
                }
            })
            .catch(error => console.error(error));
        }
    }

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