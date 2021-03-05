// Wait for the DOM to be ready
$(function() {
    console.log("validation running");
    // Create a validation instance with the login form
    $(".loginForm").validate({
    rules: {
        user: "required",
        pass: {
            required: true,
            minlength: 8
        }
    },
    // Error messages
    messages: {
      user: "Please enter a username",
      pass: {
        required: "Please enter a password",
        minlength: "Your password must be 8 or more characters"
      },
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      form.submit();
    }
    });
    });
