const $d = document,
      $form = $d.querySelector('form'),
      $inputs = [$nombre,$aps,$email,$pass,$pass2] = $d.querySelectorAll('input'),
      $btn = $d.querySelector(".registrar__btn")

regExEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/

function validarFormulario() {
    let toret = true;

    $inputs.forEach(input => {
        input.style.border = "1px solid black";
    })

    if ($nombre.value.trim() == "") {
        $nombre.style.border = "2px solid red";
        Swal.fire({
            title: "ERROR",
            text: "El nombre es obligatorio.",
            icon: "error"
        });
        toret = false;
    } else if ($aps.value.trim() == "") {
        $aps.style.border = "2px solid red";
        Swal.fire({
            title: "ERROR",
            text: "Los apellidos son obligatorios.",
            icon: "error"
        });
        toret = false;
    } else if (!regExEmail.test($email.value.trim())) {
        $email.style.border = "2px solid red";
        Swal.fire({
            title: "ERROR",
            text: "El email no es válido.",
            icon: "error"
        });
        toret = false;
    } else if ($pass.value.trim() == "") {
        $pass.style.border = "2px solid red";
        Swal.fire({
            title: "ERROR",
            text: "La contraseña es obligatoria.",
            icon: "error"
        });
        toret = false;
    } else if ($pass.value !== $pass2.value) {
        $pass.style.border = "2px solid red";
        $pass2.style.border = "2px solid red";
        Swal.fire({
            title: "ERROR",
            text: "Las contraseñas no coinciden.",
            icon: "error"
        });
        toret = false;
    }

    return toret;
}

$d.addEventListener("DOMContentLoaded", () => {
    $btn.addEventListener("click", (e) => {
        e.preventDefault();
        if (validarFormulario()) {
            $form.submit();
        }
    });
})