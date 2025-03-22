/* Users Card rendering  */
$(document).ready(function () {
    let currentPage = 1;
    const usersPerPage = 8;
    let searchQuery = '';

    function loadUsers(page = 1, query = '') {
        const baseUrl = $('#userCards').data('url');
        if (!baseUrl) {
            return; 
        }
        const userDataUrl = `${baseUrl}/${page}`;
        $.ajax({
            url: userDataUrl,
            method: 'GET',
            dataType: 'json',
            data: { search: query, status: $('#user_status').val() },
            success: function (data) {
                const users = Array.isArray(data.data) ? data.data : [];
                const totalUsers = data.total || 0;
                const $container = $('#userCards');
                const $userCount = $('#userCount');
                const isDemos = $('#isDemoModel').val();
                const $pagination = $('#pagination');
                const emptyimg = window.location.origin+'/assets/images/faces/2.jpg';
                $container.empty();
                if (users.length === 0 && page === 1) {
                    $userCount.text('No users found');
                } else {
                    $userCount.text(
                        `${(page - 1) * usersPerPage + 1}-${Math.min(page * usersPerPage, totalUsers)} ${trans('OF')} ${totalUsers} ${trans('PEOPLE')}`
                    );

                    users.forEach(user => {
                    
                        let buttonsHtml;
                        let emailData;
                        let mobileData;
                    if(user.deleted_at == null){
                        switch(user.status) {
                            case 'all_users':
                                buttonsHtml = `
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="#" class="btn btn-outline-secondary d-flex align-items-center" 
                                       data-bs-target='#userEditModal' data-bs-toggle='modal' 
                                       data-id="${user.id || ''}" data-name="${user.name || ''}" data-email="${user.email || ''}"
                                       data-phone="${user.mobile || ''}" data-status="${user.status || ''}" data-country-code="${user.country_code || ''}" 
                                       data-profile="${user.profile || emptyimg}" title='Edit'>
                                        <i class='fa fa-pen'></i> &nbsp; ${trans('EDIT')}
                                    </a>
                                    <a href="users/${user.id || '#'}" class="btn btn-outline-danger d-flex align-items-center delete-form user-delete-form-reload">
                                        <i class='fa fa-trash'></i> &nbsp; ${trans('DELETE')}
                                    </a>
                                </div>`;
                                break;
                            case 'active':
                                buttonsHtml = `
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="#" class="btn btn-outline-secondary d-flex align-items-center" 
                                       data-bs-target='#userEditModal' data-bs-toggle='modal' 
                                       data-id="${user.id || ''}" data-name="${user.name || ''}" data-email="${user.email || ''}"
                                       data-phone="${user.mobile || ''}" data-status="${user.status || ''}" data-country-code="${user.country_code || ''}" 
                                       data-profile="${user.profile || emptyimg}" title='Edit'>
                                        <i class='fa fa-pen'></i> &nbsp; ${trans('EDIT')}
                                    </a>
                                    <a href="users/${user.id || '#'}" class="btn btn-outline-danger d-flex align-items-center delete-form user-delete-form-reload">
                                        <i class='fa fa-trash'></i> &nbsp; ${trans('DELETE')}
                                    </a>
                                </div>`;
                                break;
                            case 'inactive':
                                buttonsHtml = `
                                    <a href="#" class="btn btn-outline-secondary d-flex align-items-center" 
                                       data-bs-target='#userEditModal' data-bs-toggle='modal' 
                                       data-id="${user.id || ''}" data-name="${user.name || ''}" data-email="${user.email || ''}"
                                       data-phone="${user.mobile || ''}"  data-status="${user.status || ''}" data-country-code="${user.country_code || ''}" 
                                       data-profile="${user.profile || emptyimg}" title='Edit'>
                                        <i class='fa fa-pen'></i> &nbsp; ${trans('Make it Active')}
                                    </a>`;
                                break;
                            default:
                                buttonsHtml = `
                            <a href="admin/users/${user.id || '#'}" class="btn btn-outline-warning d-flex align-items-center retrive-delete delete-form-reload">
                                <i class='fa fa-undo'></i> &nbsp; ${trans('RECOVER')}
                            </a>`;
                        }
                    }else{
                            buttonsHtml = `
                            <a href="admin/users/${user.id || '#'}" class="btn btn-outline-warning d-flex align-items-center retrive-delete delete-form-reload">
                                <i class='fa fa-undo'></i> &nbsp; ${trans('RECOVER')}
                            </a>`;
                    }

                    if(user.email){
                        if(isDemos == 'demo_off'){
                            emailData = `<div class="text-muted mb-1">${trans('EMAIL')}: ${user.email}</div>`
                        }else{
                            emailData = `<div class="text-muted mb-1">${trans('EMAIL')}: adxxxxx@gmail.com</div>`
                        }
                    }else{
                        emailData = `<div class="text-muted mb-1">${trans('EMAIL')}: Not Provided</div>`
                    }

                    if(user.mobile){
                        if(isDemos == 'demo_off'){
                            mobileData = `<div class="text-muted">${trans('PHONE')}: ${user.country_code || ''} ${user.mobile}</div>`
                        }else{
                            mobileData = `<div class="text-muted">${trans('PHONE')}: ${user.country_code || ''}XXXXXXXXXX</div>`
                        }
                    }else{
                        mobileData = `<div class="text-muted">${trans('PHONE')}: Not Provided</div>`
                    }
                        const cardHtml = `
                            <div class="col-md-6 col-lg-3 mb-4">
                                <div class="card pull-effect">
                                    <div class="card-body p-4 text-center">
                                        <div class="avatar avatar-xl mb-3 mx-auto d-flex justify-content-center align-items-center">
                                            <img src="${user.profile ?? 'https://news-app.keshwaniexim.com/assets/images/faces/2.jpg'}" class="img-fluid-avtar">
                                        </div>
                                        <h3 class="m-0 mb-2">
                                            <a href="#" class="text-decoration-none">${user.name || 'No Name'}</a>
                                        </h3>
                                        <div class="mb-3">
                                            ${emailData}
                                            ${mobileData}
                                            <div class="text-muted" data-status="${user.status}">${trans('STATUS')}:${user.deleted_at == null ? user.status == 'active' ? `<span class="text-success">Active</span>`:`<span class="text-muted">Inctive</span>` : `<span class="text-danger">Deleted</span>`}</div>
                                        </div>
                                        <div class="mb-3">
                                            ${user.channel_count ? `<div class="text-muted">Channels Followed: <span id="follow-count">${user.channel_count}</span></div>` : ''}
                                        </div>
                                         ${buttonsHtml}
                                    </div>
                                </div>
                            </div>`;
                    
                        $container.append(cardHtml);
                    });   
                }

                $pagination.empty();
                const totalPages = Math.ceil(totalUsers / usersPerPage);
                const createPageItem = (page, label = page, active = false, disabled = false) => `
                    <li class="page-item ${active ? 'active' : ''} ${disabled ? 'disabled' : ''}">
                        <a class="page-link" href="javascript:void(0)" data-page="${page}">${label}</a>
                    </li>
                `;

                let paginationHtml = '';
                paginationHtml += createPageItem(currentPage - 1, trans('PREVIOUS'), false, currentPage === 1);

                if (totalPages <= 5) {
                    for (let i = 1; i <= totalPages; i++) {
                        paginationHtml += createPageItem(i, i, currentPage === i);
                    }
                } else {
                    if (currentPage <= 3) {
                        for (let i = 1; i <= 3; i++) {
                            paginationHtml += createPageItem(i, i, currentPage === i);
                        }
                        paginationHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        paginationHtml += createPageItem(totalPages);
                    } else if (currentPage >= totalPages - 2) {
                        paginationHtml += createPageItem(1);
                        paginationHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        for (let i = totalPages - 2; i <= totalPages; i++) {
                            paginationHtml += createPageItem(i, i, currentPage === i);
                        }
                    } else {
                        paginationHtml += createPageItem(1);
                        paginationHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        for (let i = currentPage - 1; i <= currentPage + 1; i++) {
                            paginationHtml += createPageItem(i, i, currentPage === i);
                        }
                        paginationHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        paginationHtml += createPageItem(totalPages);
                    }
                }
                paginationHtml += createPageItem(currentPage + 1, trans('NEXT'), false, currentPage === totalPages || users.length === 0);

                $pagination.html(paginationHtml);
            },
            error: function (error) {
            }
        });
    }

    loadUsers();

    $('#searchUser').on('input', function () {
        searchQuery = $(this).val().toLowerCase();
        currentPage = 1;
        loadUsers(currentPage, searchQuery);
    });

    $('#pagination').on('click', '.page-link', function (e) {
        e.preventDefault();
        const page = parseInt($(this).data('page'));
        if (!isNaN(page) && page > 0) {
            currentPage = page;
            loadUsers(currentPage, searchQuery);
        }
    });

    $('#user_status').on('change', function () {
        currentPage = 1;
        loadUsers(currentPage, searchQuery);
    });

/********* User Data ***********/
    /* Store User */
    function initializeIntlTelInput() {
        var input = document.querySelector("#phone");
        window.iti = window.intlTelInput(input, {
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            initialCountry: 'auto',
            geoIpLookup: function(success, failure) {
                success('in');
            },
            separateDialCode: true,
        });
    }
    initializeIntlTelInput();

    document.addEventListener('themeChanged', function() {
        initializeIntlTelInput();
    });
    
    document.addEventListener('themeChanged', function() {
        initializeIntlTelInput();
    });

    $('#phone').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        displayError('phone', 'Accept only number value');
    });
  

    $('#user-add-form').on('submit', function(e) {
        e.preventDefault();
        clearErrors();
        var isValid = true;
        var fullPhoneNumber = iti.getNumber();

        var password = $('#password').val();
        var password_confirm = $('#password-confirm').val();
        if(password !== password_confirm){
            $('#password').addClass('is-invalid').removeClass('is-valid');
            $('#password-confirm').addClass('is-invalid').removeClass('is-valid');
            $('#password-confirm-error-message').removeClass('d-none');
            $('#password-error-message').removeClass('d-none');
            $('#password-confirm-error-message').text('Confirm password does not match with password');
            $('#password-error-message').text('Password does not match with confirm password');
            isValid = false;
        }

        var status = $('#add-user-status').val();
        if(image == ""){
            $('#status-error-message').text('Profile is required');
            return false;
        }

        var image = $('#add-user-profile-img').val();
        if(image == ""){
            $('#password-error-message').removeClass('d-none');
            $('#profile-error-message').text('Profile is required');
            return false;
        }
        
        if (!iti.isValidNumber()) {
            $('#phone').removeClass('is-valid').addClass('is-invalid');
            displayError('phone', 'Invalid phone number');
            isValid = false;
        }
        
        var name = $('input[name="name"]').val().trim();
        if (name === '') {
            $('#user-name').removeClass('is-valid').addClass('is-invalid');
            displayError('name', 'Name is required');
            isValid = false;
        }
        
        var fileInput = $('#add-user-profile-img')[0];
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const validTypes = ['image/jpeg', 'image/png', 'image/svg+xml'];
    
            if (!validTypes.includes(file.type)) {
                displayError('user-profile', 'Please select a valid image file (JPG, PNG, SVG).');
                $('#add-user-profile-img').removeClass('is-valid').addClass('is-invalid');
                isValid = false;
            }
        }
    
        if (!isValid) {
            return;
        }
    
        let formElement = $(this);
        let formData = new FormData(this);
        formData.set('phone', fullPhoneNumber);
    
        $.ajax({
            url: formElement.attr('action'),
            type: formElement.attr('method'),
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#userCreateModal').modal('hide');
                showSuccessToast(response.message);
                $('#user-add-form')[0].reset();
                $('#user-add-form').find('.form-control').removeClass('is-invalid is-valid');
                $('.text-danger').hide();
            
                loadUsers();
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(key, messages) {
                        console.log(key);
                        console.log(messages);
                        let errorMessage = messages[0];
                        $(`#${key}-error-message`).text(errorMessage).show();
                    });
                } else {
                    console.log(errors);
                }
            }
        });
    });


    /* Update the user */
    function initializeIntlTelInputEdit() {
        var input = document.querySelector("#edit-phone");
        window.iti = window.intlTelInput(input, {
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            initialCountry: 'auto',
            geoIpLookup: function(success, failure) {
                success('in');
            },
            separateDialCode: true,
        });
    }
    initializeIntlTelInputEdit();

    document.addEventListener('themeChanged', function() {
        initializeIntlTelInputEdit();
    });
    
    document.addEventListener('themeChanged', function() {
        initializeIntlTelInputEdit();
    });
    $('#user-edit-form').on('submit', function(e) {
        e.preventDefault();
        clearErrors();
    
        var isValid = true;
        var fullPhoneNumber = iti.getNumber();
        
        if (!iti.isValidNumber()) {
            $('#phone').removeClass('is-valid').addClass('is-invalid');
            displayError('phone', 'Invalid phone number');
            isValid = false;
        }
        
        var name = $('#edit-user-name').val().trim();
        if (name === '') {
            $('#edit-user-name').removeClass('is-valid').addClass('is-invalid');
            displayError('name', 'Name is required');
            isValid = false;
        }
        
        var fileInput = $('#user-profile-img')[0];
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const validTypes = ['image/jpeg', 'image/png', 'image/svg+xml'];
    
            if (!validTypes.includes(file.type)) {
                displayError('user-profile', 'Please select a valid image file (JPG, PNG, SVG).');
                $('#user-profile-img').removeClass('is-valid').addClass('is-invalid');
                isValid = false;
            }
        }
    
        if (!isValid) {
            return;
        }
    
        let formElement = $(this);
        let formData = new FormData(this);
        formData.set('phone', fullPhoneNumber);
    
        $.ajax({
            url: formElement.attr('action'),
            type: formElement.attr('method'),
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#userEditModal').modal('hide');
                showSuccessToast(response.message);
                $('#user-edit-form')[0].reset();
                $('#user-edit-form').find('.form-control').removeClass('is-invalid is-valid');
                $('.text-danger').hide();
            
                loadUsers();
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(key, messages) {
                        let errorMessage = messages[0];
                        $(`#${key}-error-message`).text(errorMessage).show();
                    });
                } else {
                    alert('An error occurred. Please try again.');
                }
            }
        });
    });

    function displayError(field, message) {
        var errorContainer = $(`#${field}-error-message`);
        if (errorContainer.length) {
            errorContainer.text(message).show();
        }
    }
    
    function clearErrors() {
        $('.error-message').hide();
    }

    /* Retrieve the deleted User */
    function showSweetAlertConfirmRecover(url, method, opt, options = {}) {
        Swal.fire({
            title: opt.title,
            text: opt.text,
            icon: opt.icon,
            showCancelButton: opt.showCancelButton,
            confirmButtonColor: opt.confirmButtonColor,
            cancelButtonColor: opt.cancelButtonColor,
            confirmButtonText: opt.confirmButtonText,
            cancelButtonText: opt.cancelButtonText,
            customClass: {
                popup: 'dark:bg-black dark:text-white'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                retriveAjaxRequest(method, url, options.data || null, null,
                    function successCallback(response) {
                        showSuccessToast(response.message);
                        opt.successCallBack(response);
                        loadUsers();
                    },
                    function errorCallback(response) {
                        showErrorToast(response.message);
                        opt.errorCallBack(response);
                    }
                );
            }
        });
    }

    function showRetrivePopupModal(url, options = {}) {
        let opt = {
            title: trans("Are you sure?"),
            text: trans("You won't get this user back."),
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: trans("Yes, Recover!"),
            cancelButtonText: trans("Cancel"),
            successCallBack: function () {},
            errorCallBack: function (response) {},
            ...options,
        };
        showSweetAlertConfirmRecover(url, "POST", opt);
    }

    $(document).on("click", ".retrive-delete", function (e) {
        e.preventDefault();
        let userId = $(this).attr("href").split("/").pop();
        showRetrivePopupModal("/admin/users/" + userId + "/recover", {
            successCallBack: function () {
                $("#table_list").bootstrapTable("refresh");
            },
            errorCallBack: function (response) {
                showErrorToast(response.message);
            },
        });
    });

    function retriveAjaxRequest(type, url, data, beforeSendCallback = null, successCallback = null, errorCallback = null, finalCallback = null, processData = false) {
        if (!["post"].includes(type.toLowerCase())) {
            type = "POST";
        }

        $.ajax({
            type: type,
            url: url,
            data: data,
            cache: false,
            processData: processData,
            contentType: data instanceof FormData ? false : "application/json",
            dataType: 'json',
            beforeSend: function () {
                if (beforeSendCallback) {
                    beforeSendCallback();
                }
            },
            success: function (data) {
                if (!data.error) {
                    if (successCallback) {
                        successCallback(data);
                    }
                } else {
                    if (errorCallback) {
                        errorCallback(data);
                    }
                }
                if (finalCallback) {
                    finalCallback(data);
                }
            },
            error: function (jqXHR) {
                if (jqXHR.responseJSON) {
                    showErrorToast(jqXHR.responseJSON.message);
                }
                if (finalCallback) {
                    finalCallback();
                }
            }
        });
    }
    
    $(document).on('click', '.user-delete-form-reload', function (e) {
        e.preventDefault();
        showDeletePopupModal($(this).attr('href'), {
            successCallBack: function () {
                setTimeout(() => {
                    loadUsers();
                }, 1000);
            }
        })
    })
});
  