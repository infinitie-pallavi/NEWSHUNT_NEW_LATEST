
/********* Store the contact us detail *********/
document.addEventListener('DOMContentLoaded', function() {
    var input = document.querySelector("#phone");
    var iti = window.intlTelInput(input, {
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        initialCountry: 'auto',
        geoIpLookup: function(success, failure) {
            success('us');
        },
        preferredCountries: ['us', 'gb', 'in'],
        separateDialCode: true,
    });

    document.querySelector("#contact-form").addEventListener('submit', function(e) {
        e.preventDefault();
        clearErrors();

        var isValid = true;
        
        var fullPhoneNumber = iti.getNumber();
        input.value = fullPhoneNumber;

        if (!iti.isValidNumber()) {
            displayError('phone', 'Invalid phone number');
            isValid = false;
        }

        var firstName = document.querySelector("#first_name").value.trim();
        var lastName = document.querySelector("#last_name").value.trim();
        var email = document.querySelector("#email").value.trim();
        var message = document.querySelector("#message").value.trim();

        if (firstName === '') {
            displayError('first_name', 'First name is required');
            isValid = false;
        }
        if (lastName === '') {
            displayError('last_name', 'Last name is required');
            isValid = false;
        }
        if (!validateEmail(email)) {
            displayError('email', 'Invalid email address');
            isValid = false;
        }
        if (message === '') {
            displayError('message', 'Message is required');
            isValid = false;
        }

        if (!isValid) {
            return;
        }

        // Prepare form data
        var formData = new FormData(this);

        // Submit the form using fetch (AJAX)
        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            // Handle non-200 status codes properly
            if (!response.ok) {
                return response.json().then(data => { throw data });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Show SweetAlert success modal
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message,
                    customClass: {
                        popup: 'dark:bg-black dark:text-white'
                      }
                });

                // Reset the form and intl-tel-input field
                document.querySelector("#contact-form").reset();
                iti.setNumber('');
            }
        })
        .catch(errors => {
            // Handle server-side validation errors
            displayServerErrors(errors.errors);
        });

    });

    // Utility to display error messages
    function displayError(field, message) {
        var errorContainer = document.querySelector(`#${field}`).closest('.mb-2').querySelector('.help-block');
        if (errorContainer) {
            errorContainer.innerHTML = `<strong>${message}</strong>`;
            errorContainer.style.display = 'block';
        }
    }

    // Utility to clear all error messages
    function clearErrors() {
        var errorElements = document.querySelectorAll('.help-block');
        errorElements.forEach(el => {
            el.innerHTML = '';
            el.style.display = 'none';
        });
    }

    // Utility to validate email format
    function validateEmail(email) {
        var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    // Utility to display server-side validation errors
    function displayServerErrors(errors) {
        Object.keys(errors).forEach(field => {
            displayError(field, errors[field][0]);
        });
    }
});
