// Obtener el formulario y los campos
const formulario = document.getElementById("formularioUsuario");
const campos = document.getElementsByClassName("inputUser");
const passwordInput = document.getElementById("inputPassword4");
const tipoEmpleadoInput = document.getElementById("inputTipo");

// Agregar el evento submit al formulario
formulario.addEventListener("submit", function (event) {
    // Validar los campos del formulario
    if (!formulario.checkValidity() || !validarSelect()) {
        event.preventDefault();
        event.stopPropagation();
    }

    formulario.classList.add("was-validated");
});

// Agregar el evento blur a los campos para validarlos al perder el foco
Array.from(campos).forEach(function (campo) {
    campo.addEventListener("blur", function () {
        if (campo.value === "") {
            campo.classList.add("is-invalid");
            campo.classList.remove("is-valid");
        } else {
            campo.classList.remove("is-invalid");
            campo.classList.add("is-valid");
        }
    });
});

// Validar la contraseña al perder el foco
passwordInput.addEventListener("blur", function () {
    const passwordValue = passwordInput.value;
    const hasNumber = /\d/.test(passwordValue);

    if (passwordValue.length < 5 || !hasNumber) {
        passwordInput.classList.add("is-invalid");
        passwordInput.classList.remove("is-valid");
    } else {
        passwordInput.classList.remove("is-invalid");
        passwordInput.classList.add("is-valid");
    }
});

// Función para validar el select
function validarSelect() {
    if (tipoEmpleadoInput.value === "") {
        tipoEmpleadoInput.classList.add("is-invalid");
        tipoEmpleadoInput.classList.remove("is-valid");
        return false;
    } else {
        tipoEmpleadoInput.classList.remove("is-invalid");
        tipoEmpleadoInput.classList.add("is-valid");
        return true;
    }
}
