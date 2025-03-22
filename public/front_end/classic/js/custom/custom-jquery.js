
$(document).ready(function() {
    function submitLoginForm(emailError) {
        $.ajax({
            url: $('#login-modle-form').attr('action'),
            type: 'POST',
            data: $('#login-modle-form').serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.error==false){
                     $('#uc-account-modal .uc-modal-close-default').trigger('click');
                    location.reload();
                }else if(response.data=='email'){
                    emailError.text("Please Enter valid Email");
                    emailError.removeClass("d-none");
                    $('#password-login-error').addClass("d-none");

                }else{
                    $('#password-login-error').text("Please Enter valid Password");
                    emailError.add("d-none");
                    $('#password-login-error').removeClass("d-none");
                }             
            },
            error: function(xhr, status, error) {
                console.error('Login failed:', error);
            }
        });
    }

    $('#login-form').on('click', function(e) {
        e.preventDefault();
        const email = $('#login-email').val();   
        const emailError = $('#email-login-error');
        emailError.text('');
        
        if (email === "") {
            emailError.text("Please enter Email");
            emailError.removeClass("d-none");
            return false;
        }
        
        const password = $('#login-password').val();
        if (password === "") {
            $('#password-login-error').text("Please enter Password");
            $('#password-login-error').removeClass("d-none");
            return false;
        }
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            emailError.text("Please enter a valid Email");
            return false;
        }
        submitLoginForm(emailError);
    });

    /* User register */
    $('#register-form').on('click', function(e) {
        e.preventDefault();
        const email = $('#login-email').val();   
        const emailError = $('#email-login-error');
        emailError.text('');
        
        if (email === "") {
            emailError.text("Please enter Email");
            return false;
        }

        const password = $('#login-password').val();
        if (password === "") {
            $('#password-login-error').text("Please enter Password");
            return false;
        }
         const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            emailError.text("Please enter a valid Email");
            return false;
        }
    });
});


$(document).ready(function() {
    $('#register-user-form').on('submit', function(e) {
        e.preventDefault();
        $('.text-danger').text('');
        
        debugger;
        const name = $('#name-register').val().trim();
        const email = $('#email-register').val().trim();
        const password = $('#password-register').val();
        const confirmPassword = $('#confirm-password-register').val();
        const acceptTerms = $('#input_checkbox_accept_terms').is(':checked');

        if (name === '') {
            $('#name-register-error').removeClass('d-none');
            $('#name-register-error').text('Full name is required.');
            return false;
        }
        if (email === '') {
            $('#email-register-error').removeClass('d-none');
            $('#email-register-error').text('Email is required.');
            return false;
        }
        if (password === '') {
            $('#password-register-error').removeClass('d-none');
            $('#password-register-error').text('Password is required.');
            return false;
        }
        if (confirmPassword === '') {
            $('#confirm-password-register-error').removeClass('d-none');
            return false;
        } else if (password !== confirmPassword) {
            $('#confirm-password-register-error').text('Passwords do not match.');
            return false;
        }
        if (!acceptTerms) {            
            $('#check_terms').removeClass('d-none');
            return false;
        }
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serialize(),
              dataType: "json",
            success: function(response) {

                location.reload();
                $('#uc-account-modal .uc-modal-close-default').trigger('click');

            },
            error: function(xhr) {
                console.log(xhr.responseJSON.errors);

                if (errors) {
                    if (errors.name) {
                        $('#name-register-error').text(errors.name[0]);
                    }
                    if (errors.email) {
                        $('#email-register-error').text(errors.email[0]);
                    }
                    if (errors.password) {
                        $('#password-register-error').text(errors.password[0]);
                    }
                    if (errors.confirm_password) {
                        $('#confirm-password-register-error').text(errors.confirm_password[0]);
                    }
                }
            }
        });
    });
});