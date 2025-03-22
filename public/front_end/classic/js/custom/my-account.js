

/* Unlike Post */
$(document).ready(function() {

    function unLikePost(postId,button){
        $.ajax({
            url: '/posts/favorite',
            method: 'POST',
            contentType: 'application/json',
            headers: {
               'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            data: JSON.stringify({ id: postId }),
            success: function(response) {
                if (response.status === '0') {
                    iziToast.success({
                        title: response.message,
                        position: 'topCenter',
                    });
                    button.closest('#postRender').remove();
                    const element = $(html).find('#postRender').length
                    
                    if(element == 0){
                        $('.nav-pagination').remove();
                        $('.hide-div').remove();
                        $('#empty-state').removeClass('d-none');
                    }
                } else {
                    iziToast.success({
                        title: response.message,
                        position: 'topCenter',
                    });
                }
            },
            error: function(xhr) {
                console.log(xhr.error);
            }
        });
    }

    $(document).on('click', '.unlike-post-btn', function(event) {
        event.preventDefault();
        const postId = $(this).data('post-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Remove',
            customClass: {
                popup: 'dark:bg-black dark:text-white'
              }
        }).then((result) => {
            if (result.isConfirmed) {
                unLikePost(postId,$(this));
            }
        });
    });
});

/* Channel Unsubscribe */
$(document).ready(function() {
    function followChannel(channelId, button) {
        $.ajax({
            url: '/follow/' + channelId,
            method: 'GET',
            success: function(response) {
                if (!response.error) {
                    iziToast.success({
                        title: response.message,
                        position: 'topCenter',
                    });
                    button.closest('#postRender').remove();
                    const element = $(html).find('#postRender').length

                    if(element == 0){
                        $('.nav-pagination').remove();
                        $('.hide-div').remove();
                        $('#empty-state').removeClass('d-none');
                    }
                }
            },
            error: function(xhr) {
            }
        });
    }
    $('.channel-unfollow').on('click', function(event) {
        event.preventDefault();
        const channelId = $(this).data('channel-id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Unfollow',
            customClass: {
                popup: 'dark:bg-black dark:text-white'
              }
        }).then((result) => {
            if (result.isConfirmed) {
                followChannel(channelId, $(this));
            }
        });
    });

    $('#user-account-form').on('submit', function(e) {
        e.preventDefault();
        
        const user_name = $('#user_name').val().trim() || "";
        const password = $('#account_password').val().trim() || "";
        const url = $(this).attr('action');
        const method = $(this).attr('method');
            
        $('#user_name_error').addClass("d-none");
        $('#account_password_error').addClass("d-none");

        let isValid = true;
        if (user_name === "") {
            $('#user_name_error').text("Name is required.").removeClass("d-none");
            isValid = false;
        }
        
        if (!isValid) {
            return false;
        }
  
            
        const formData = new FormData(this);
        formData.append('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
    
        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                iziToast.success({
                    title: response.message,
                    position: 'topCenter',
                });
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    if (xhr.responseJSON.errors.user_name) {
                        $('#user_name_error').text(xhr.responseJSON.errors.user_name[0]).removeClass("d-none");
                    }
                    if (xhr.responseJSON.errors.password) {
                        $('#account_password_error').text(xhr.responseJSON.errors.password[0]).removeClass("d-none");
                    }
                } else {
                    iziToast.error({
                        title: 'Login failed',
                        message: 'An unexpected error occurred. Please try again.',
                        position: 'topCenter',
                    });
                }
            }
        });
       
    });

    $(document).ready(function() {
        $('#togglePassword').on('click', function() {
            const passwordInput = $('#account_password');
            const eyeIcon = $('#eyeIcon');
    
            if (passwordInput.attr('type') === "password") {
                passwordInput.attr('type', 'text');
                eyeIcon.removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
                passwordInput.attr('type', 'password');
                eyeIcon.removeClass('bi-eye-slash').addClass('bi-eye');
            }
        });
    });
});


/* User confirm delete */
$('#user-delete-account').on('click', function(event) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete Account',
        customClass: {
            popup: 'dark:bg-black dark:text-white'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            deleteUser (event);
        }
    });
});

function deleteUser (event) {
    event.preventDefault();

    $.ajax({
        url: '/delete-account',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.error === false) {    
                window.location.href = window.location.origin;
            } else {
                alert(response.message || "An error occurred while deleting the account.");
            }
        },
        error: function(xhr) {
        }
    });
}


