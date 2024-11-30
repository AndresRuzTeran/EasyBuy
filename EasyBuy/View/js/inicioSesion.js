<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    var modalExitoso = bootstrap.Modal.getOrCreateInstance('#modalSuccess');
    var modalError = bootstrap.Modal.getOrCreateInstance('#modalError');

    window.addEventListener('load', ()=>{
        document.getElementById('espaciado-footer').hidden = true;
        document.getElementById('pqr-footer').hidden = true;
    });

    function logIn(){

        let form = document.getElementById('formLogin'); //Form del login
        form.classList.add('was-validated');

        //Se validan los campos
        if (form.checkValidity()){
            //Se captan los datos
            var data = [];
            form.querySelectorAll("input").forEach(function(input){
                data.push(input.value);
            });
            //La contraseña no debe estar vacia
            if(data[1] == ""){
                document.getElementById("mensajeError").innerHTML = "Ingrese una contraseña válida";
                modalError.show();
                return false;
            }

            //Se envian los datos
            fetch("Controller/Usuario/logIn.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(res => {
                if(res.resultado){
                    agregarSession(res.id, res.tipo);
                    var link = document.createElement('a');
                    if(res.tipo == 1){
                        link.href = 'home';
                    }else{
                        link.href = 'home-store';
                    }
                    link.id = 'linkURL';
                    document.body.appendChild(link);
                    document.getElementById("linkURL").click();
                }else{
                    document.getElementById("mensajeError").innerHTML = res.mensaje;
                    modalError.show();
                }
            })
            .catch(error => console.error(error));
        }
    }

    function agregarSession(id, tipo){
        var data = [id,tipo]
        fetch('Controller/session/start.php', {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
        .catch(error => console.error('Error al actualizar la sesión:', error));
    }
</script>