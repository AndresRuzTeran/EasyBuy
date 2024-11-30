<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    var modalExitoso = bootstrap.Modal.getOrCreateInstance('#modalSuccess');
    var modalError = bootstrap.Modal.getOrCreateInstance('#modalError');

    window.addEventListener('load', ()=>{
        document.getElementById('espaciado-footer').hidden = true;
        document.getElementById('pqr-footer').hidden = true;
    });

    function registrarse() {
        let form = document.getElementById('formReg');
        form.classList.add('was-validated');

        if (form.checkValidity()) {
            var data = [];
            form.querySelectorAll("input, select").forEach(function(element) {
                data.push(element.value);
            });
            if(data[1] == ""){
                document.getElementById("mensajeError").innerHTML = "Las contraseñas no deben estar vacías";
                modalError.show();
                document.getElementById("pass1").value = "";
                document.getElementById("pass2").value = "";
                return false;
            }
            if(data[4]==data[5]){
                fetch("Controller/Usuario/insertar.php", {
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
            }else{
                document.getElementById("mensajeError").innerHTML = "Las contraseñas no coinciden";
                modalError.show();
                document.getElementById("pass1").value = "";
                document.getElementById("pass2").value = "";
            }
        }
    }

</script>

