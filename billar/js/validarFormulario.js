function validateInput(input) {
    var feedbackElement = input.parentNode.querySelector(".invalid-feedback");
    if (input.checkValidity() === false) {
      input.classList.add("is-invalid");
      input.classList.remove("is-valid");
      feedbackElement.classList.add("d-block");
      feedbackElement.classList.remove("d-none");
    } else {
      input.classList.remove("is-invalid");
      input.classList.add("is-valid");
      feedbackElement.classList.remove("d-block");
      feedbackElement.classList.add("d-none");
    }
  }
  
  var forms = document.querySelectorAll(".needs-validation");
  
  forms.forEach(function(form) {
    var inputs = form.querySelectorAll(".form-control");
  
    inputs.forEach(function(input) {
      input.addEventListener("input", function() {
        validateInput(this);
      });
    });
  
    form.addEventListener("submit", function(event) {
      event.preventDefault();
      event.stopPropagation();
  
      inputs.forEach(function(input) {
        validateInput(input);
      });
  
    });
  });

  
  