// Wait for the DOM to be ready
$(function() {
    // Use the validate method with on the registration form
    $(".registerForm").validate({
    rules: {
        user: "required",
        pass: {
            required: true,
            minlength: 8
        },
        passConfirm: {
            required: true,
            minlength: 8,
            equalTo: 'input[name="pass"]'
        }
    },
    // Error messages
    messages: {
      user: "Please enter a username",
      pass: {
        required: "Please enter a password",
        minlength: "Your password must be 8 or more characters"
      },
      passConfirm: {
        required: "Please re-enter a password",
        minlength: "Your password must be 8 or more characters",
        equalTo: "Passwords do not match"
      },
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      form.submit();
    }
    });
    });
