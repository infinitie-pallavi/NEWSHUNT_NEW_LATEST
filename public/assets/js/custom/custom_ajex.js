var current_locale = $('#current_locale').val();
var englishLanguage = {
    "processing": "Processing...",
    "search": "Search:",
    "lengthMenu": "Show _MENU_ entries",
    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
    "infoEmpty": "No entries to show",
    "infoFiltered": "(filtered from _MAX_ total entries)",
    "loadingRecords": "Loading...",
    "zeroRecords": "No matching records found",
    "emptyTable": "No data available in table",
    "paginate": {
        "first": "First",
        "last": "Last",
        "next": "Next",
        "previous": "Previous"
    }
};

var hindiLanguage = {
    "processing": "प्रोसेसिंग...",
    "search": "खोजें:",
    "lengthMenu": "दिखाएँ _MENU_ प्रविष्टियाँ",
    "info": "_TOTAL_ प्रविष्टियों में से _START_ से _END_ दिखा रहे हैं",
    "infoEmpty": "दिखाने के लिए कोई प्रविष्टि नहीं",
    "infoFiltered": "(कुल _MAX_ प्रविष्टियों से छान लिया गया)",
    "loadingRecords": "लोड हो रहा है...",
    "zeroRecords": "कोई मिलान रिकॉर्ड नहीं मिला",
    "emptyTable": "तालिका में कोई डेटा उपलब्ध नहीं है",
    "paginate": {
        "first": "पहला",
        "last": "अंतिम",
        "next": "अगला",
        "previous": "पिछला"
    }
};
// Image Preview Setup
(function() {
    function setupImagePreview(inputSelector, previewSelector) {
        $(inputSelector).on('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => $(previewSelector).attr('src', e.target.result);
                reader.readAsDataURL(file);
            }
        });
    }

    setupImagePreview('#change-profile', '#change-profile-privew');
    setupImagePreview('#add-user-profile-img', '#add-user-profile-privew');
    setupImagePreview('#user-profile-img', '#user-profile-privew');
    setupImagePreview('#channel-logo-input', '#channel-logo-privew');
    setupImagePreview('#edit-channel-logo', '#edit-channel-privew');
    setupImagePreview('#Notification_img', '#Notification_preview');
    setupImagePreview('#theme-logo-input', '#theme-logo-preview');
    setupImagePreview('#edit-theme-logo-input', '#edit-theme-logo-preview');
    setupImagePreview('#post-image-input', '#post-image-privew');
    setupImagePreview('#edit-post-image-input', '#edit-post-image-privew');
    setupImagePreview('#topic-logo-input', '#topic-logo-privew');
    setupImagePreview('#edit-topic-logo-input', '#edit-topic-logo-privew');
})();

// Channel Management
$(document).ready(function() {
    const channelTable = $('#Channel_list').DataTable({
        processing: true,
        serverSide: true,
        order: [[0, 'desc']],
        ajax: {
            url: $('#Channel_list').data('url'),
            data: function(d) {
                d.channel_status = $('#channel_status').val();
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            {
                data: 'poster_image',
                render: data => data ? `<img src='${data}' class='img-channels'/>` : ''
            },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'description', name: 'description', className: 'description-column',
                render: function(data) {
                    if (data.length === 0) 
                    {
                        return 'Description not available';
                    }
                    return data;
            },
            },
            {
                data: 'status',
                name: 'status',
                render: (data, type, row) => `
                    <div class="form-check form-switch">
                        <input class="form-check-input switch-input channel-switch-input" type="checkbox" data-id="${row.id}" ${data === 'active' ? 'checked' : ''}>
                    </div>`
            },
            { data: 'follow_count', name: 'follow_count' },
            { data: 'action', name: 'action' }
        ],
        language: current_locale === 'en' ? englishLanguage : hindiLanguage
    });
    
    $('#Channel_list').on('click', '.edit_btn', function() {
        const row = channelTable.row($(this).closest('tr')).data();
        if (row) {
            $('#channel-id').val(row.id);
            $('#edit-channel-name').val(row.name);
            $('#edit-channel-description').val(row.description);
            $('#edit-channel-status').val(row.status);
            $('#edit-channel-privew').attr('src', row.poster_image || asset('assets/images/no_image_available.png'));
            $('#editChannelForm').attr('action', route('channels.update', '') + '/' + row.id);
            $('#editChannelModal').modal('show');
        }
    });

    $('#channel_status').on('change', () => channelTable.ajax.reload());

    $(document).on('change', '.channel-switch-input', function() {
        const id = $(this).data('id');
        const status = $(this).prop('checked') ? 'active' : 'inactive';
        const url = $('#channel_status_url').val();
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                id: id,
                status: status,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: response => showSuccessToast(response.message),
            error: xhr => console.error('Error:', xhr.responseText)
        });
    });
});

// Contact us Management
$(document).ready(function() {
    const contactTable = $('#contact_us_table').DataTable({
        processing: true,
        serverSide: true,
        order: [[0, 'desc']],
        ajax: {
            url: $('#contact_us_table').data('url'),
            data: function(d) {
                d.status = $('#topics_status').val();
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'phone', name: 'phone' },
            { data: 'email', name: 'email' },
            { data: 'message', name: 'message' },
            { data: 'action', orderable: false, searchable: false }
        ],
        language: current_locale === 'en' ? englishLanguage : hindiLanguage
    });

    $('#contact_us_table').on('click', '.edit_btn', function() {
        const row = contactTable.row($(this).closest('tr')).data();
        if (row) {
            $('#contact-name').text(row.name);
            $('#contact-email').text(row.email);
            $('#contact-mobile').text(row.phone);
            $('#contact-message').text(row.message);
            $('#contact-us-modal').modal('show');
        }
    });
});

// Comments Management
$(document).ready(function() {
    const dataUrl = $('#posts-container').data('url');
    const commentsTable = $('#user_comments_table').DataTable({
        processing: true,
        serverSide: true,
        order: [[0, 'desc']],
        ajax: {
            url:dataUrl,
            dataSrc: function(json) {
                return json.data;
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'comment', name: 'comment' },
            { data: 'title', name: 'title' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: current_locale === 'en' ? englishLanguage : hindiLanguage
    });

    $('#user_comments_table').on('click', '.edit_btn', function() {
        const row = contactTable.row($(this).closest('tr')).data();
        if (row) {
            $('#post_title').text(row.title);
            $('#Comments_model').modal('show');
        }
    });
});

// Reported Comments Management
$(document).ready(function() {
    const reportedComments = $('#report_comments_table').DataTable({
        processing: true,
        serverSide: true,
        order: [[0, 'desc']],
        ajax: {
            url: $('#report_comments_table').data('url'),
            dataSrc: function(json) {
                return json.data;
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'report', name: 'report' },
            { data: 'comment', name: 'comment' },
            { data: 'created_at', name: 'created_at', render: function(data, type, row) {
                    // Format date using Intl.DateTimeFormat
                    let date = new Date(data);
                    let formattedDate = new Intl.DateTimeFormat('en-IN', {
                        year: 'numeric',
                        month: 'short',
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: false
                    }).format(date);
                    return formattedDate;
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: current_locale === 'en' ? englishLanguage : hindiLanguage
    });

    /* Delete Reported Comment */
    $(document).on('click', '#delete_report_comment', function(e) {
        e.preventDefault();
        var commentId = $(this).data('comment-id');
        
        if (confirm('Are you sure you want to delete this comment?')) {
            deleteComment(commentId)
        }
        function deleteComment(commentId) {
            $.ajax({
                url: 'report-comments/' + commentId,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    if (response.error == false) {
                        reportedComments.ajax.reload(null, false);
                        showSuccessToast(response.message);
                    } else {
                        showErrorToast(response.message);
                    }
                },
                error: function(xhr) {
                    alert('An error occurred while deleting the comment. Please try again.');
                    console.log(xhr.responseText);
                }
            });
        }
    });
});

// Show subscribers
$(document).ready(function() {
    const subscriberTable = $('#subscribers-table').DataTable({
        processing: true,
        serverSide: true,
        order: [[0, 'desc']],
        ajax: {
            url: $('#subscribers-table').data('url'),
            data: function(d) {
                d.status = $('#topics_status').val();
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'email', name: 'email' }
        ],
        language: current_locale === 'en' ? englishLanguage : hindiLanguage
    });
});


    // Web Theme Management
$(document).ready(function() {
    const themeTable = $('#theme_table').DataTable({
        processing: true,
        serverSide: true,
        order: [[0, 'desc']],
        ajax: {
            url: $('#theme_table').data('url'),
            data: function(d) { }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'image', render: data => data ? `<img src='${data}' class='img-channels' alt='Channel Image' />` : '' },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            
            { 
                data: 'is_default', 
                name: 'is_default', 
                render: (data, type, row) => `
                    <div class="form-check form-switch">
                        <input class="form-check-input theme-switch-input" type="checkbox" data-id="${row.id}" ${data === 1 ? 'checked' : ''} role="switch" aria-checked="${data === 1}" aria-label="Status switch for ${row.name}">
                    </div>` 
            },
            { data: 'action', orderable: false, searchable: false }
        ],
        language: current_locale === 'en' ? englishLanguage : hindiLanguage
    });
    $('#theme_table').on('click', '.edit_btn', function() {
        const row = themeTable.row($(this).closest('tr')).data();
        if (row) {
            $('#theme-id').val(row.id);
            $('#edit-theme-name').val(row.name);
            $('#edit-theme-status').val(row.status);
            $('#edit-theme-logo-preview').attr('src', row.image || asset('assets/images/no_image_available.png'));
    
            // Use the data attribute to get the update URL
            const updateUrl = $('#editWebThemeForm').data('update-url');
            $('#editWebThemeForm').attr('action', updateUrl + '/' + row.id);
            
            $('#editWebTheme').modal('show');
        }
    });
    

    $(document).on('change', '.theme-switch-input', function() {
        const id = $(this).data('id');
        const status = $(this).prop('checked') ? '1' : '0';
        const url = $('#theme_status_url').val();

        $.ajax({
            type: 'POST',
            url: url,
            order: [[0, 'desc']],
            data: {
                id: id,
                status: status,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: response => {
                showSuccessToast(response.message);
                themeTable.ajax.reload(null, false);
            }
        });
    });

});

$(document).ready(function () {
    // Function to initialize DataTable with common settings
    function initializeDataTable(selector, ajaxUrl, columns, additionalSettings = {}) {
        return $(selector).DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: ajaxUrl,
            columns: columns,
            language: current_locale === 'en' ? englishLanguage : hindiLanguage,
            ...additionalSettings
        });
    }

    // Initialize Permission DataTable
    var permissionTable = initializeDataTable(
        '#permissionAjex',
        $('#permissionAjex').data('url'),
        [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'guard_name', name: 'guard_name' },
            { data: 'action', orderable: false, searchable: false }
        ]
    );

    // Edit Button Event for Permission DataTable
    $('#permissionAjex').on('click', '.edit_btn', function () {
        var row = permissionTable.row($(this).closest('tr')).data();
        if (row) {
            $('#permission_id').val(row.id);
            $('#edit-permission-name').val(row.name);
            $('#edit-permission-guard-name').val(row.guard_name);
            $('#edit-Permission-Form').attr('action', route('permission.update', '') + '/' + row.id);
            $('#editPermissionModal').modal('show');
        }
    });

    // Initialize Roles DataTable
    initializeDataTable(
        '#roal-list',
        $('#roal-list').data('url'),
        [
            { data: 'id' },
            { data: 'no' },
            { data: 'name' },
            { data: 'action', orderable: false, searchable: false }
        ]
    );

    /* Initialize Rss Feeds DataTable */
    var rssFeedTable = initializeDataTable(
        '#rss-feed-list',
        $('#rss-feed-list').data('url'),
        [
            { data: 'id', name: 'id' },
            { data: 'channel_name', name: 'channel_name' },
            { data: 'topic_name', name: 'topic_name' },
            { data: 'feed_url', name: 'feed_url',
                render: function (data) {
                    if (!data) return '';
                    let url = encodeURI(data);
                    return `<a href="${url}" target="_blank" rel="noopener noreferrer">${data}</a>`;
                }
            },
            { data: 'data_format', name: 'data_format' },
            { data: 'sync_interval', name: 'sync_interval' },
            {
                data: 'status', name: 'status',
                render: function (data, type, row) {
                    return `<div class="form-check form-switch">
                                <input class="form-check-input switch-input rssfeed-switch-input" type="checkbox" data-id="${row.id}" ${data === 'active' ? 'checked' : ''}>
                            </div>`;
                }
            },{
                data: 'sync', name: 'sync', orderable: false, searchable: false,
                render: function (data, type, row) {
                    return `<button class="btn btn-link text-decoration-none sync-single-feed-btn" data-id="${row.id}" data-status="normal">
                    <i class="fa fa-sync" id="sync_icon_${row.id}"></i>
                 </button>`;
 
                }
            },            
            { data: 'action', orderable: false, searchable: false }
        ]
    );
    

    // Edit Button Event for Rss Feeds DataTable
    $('#rss-feed-list').on('click', '.edit_btn', function () {
        var row = rssFeedTable.row($(this).closest('tr')).data();
        if (row) {
            $('#rss-feed-id').val(row.id);
            $('#edit_feed_url').val(row.feed_url);
            $('#edit_channel_name').val(row.channel_id);
            $('#edit_channel_description').val(row.description);
            $('#edit_topic_name').val(row.topic_id);
            $('#edit_sync_interval').val(row.sync_interval);
            $('#edit_data_formate').val(row.data_format);
            $('#edit_status').val(row.status);
            $('#editRssFeedForm').attr('action', route('rss-feeds.update', '') + '/' + row.id);
            $('#editTopicModal').modal('show');
        }
    });

    // Handle feed status change
    $('#feed_status').on('change', function () {
        rssFeedTable.ajax.reload();
    });

    // Handle RSS feed switch change
    $(document).on('change', '.rssfeed-switch-input', function () {
        var id = $(this).data('id');
        var status = $(this).prop('checked') ? 'active' : 'inactive';
        var url = $('#channel_status_url').val();
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                id: id,
                status: status,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                showSuccessToast(response.message);
            },
            error: function (xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    });

        /* Fetch single feed */
        $(document).on('click', '.sync-single-feed-btn', function () {
            const button = $(this);
            const id = button.data('id');
            const url = $('#rssfeedFetchSingle').val();
            const icon = $('#sync_icon_' + id);
            const processText = trans('Processing');
        
            button.prop('disabled', true);
            icon.removeClass('fa-sync');
            icon.text(processText);
        
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    id: id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
        
                    showSuccessToast(response.message);
                    button.prop('disabled', false);
                    icon.text('');
                    icon.addClass('fa-sync');
                },
                error: function (xhr) {
                    console.error('Error:', xhr.responseText);
                    button.prop('disabled', false);
                    icon .text('');
                    icon.addClass('fa-sync');
                }
            });
        });


    // Initialize Language List DataTable
    var languageListTable = initializeDataTable(
        '#language_list',
        $('#language_list').data('url'),
        [
            { data: 'id' },
            { data: 'name' },
            { data: 'name_in_english' },
            { data: 'code' },
            { data: 'rtl', render: data => data == '1' ? 'Yes' : 'No' },
            { data: 'image', render: data => data ? `<img src='${data}' class='img-channels'/>` : '' },
            { data: 'action' }
        ]
    );

    // Edit Button Event for Language List DataTable
    $('#language_list').on('click', '.edit_btn', function () {
        var row = languageListTable.row($(this).closest('tr')).data();
        if (row) {
            $('.filepond').filepond('removeFile');
            $("#edit_name").val(row.name);
            $("#edit_name_in_english").val(row.name_in_english);
            $("#edit_code").val(row.code);
            $("#edit_rtl_switch").prop('checked', row.rtl === 'Yes');
            $("#edit_rtl").val(row.rtl === 'Yes' ? 1 : 0);
            $('#editModal').modal('show');
        }
    });

    // Reload page on button click
    $('#edit_page_reload').on('click', function () {
        setTimeout(function () {
            location.reload();
        }, 1000);
    });

    // Initialize Admin Users DataTable
    initializeDataTable(
        '#admin_user_list',
        $('#admin_user_list').data('url'),
        [
            { data: 'id' },
            { data: 'name' },
            { data: 'email' },
            { data: 'status' },
            { data: 'action' }
        ]
    );

    initializeDataTable(
        '#Counitry-list',
        $('#Counitry-list').data('url'),
        [
            { data: 'id' },
            { data: 'name' },
            { data: 'emoji' },
            { data: 'action', orderable: false, searchable: false }
        ]
    );
});

$(document).ready(function () {
    // Dashboard Chart Initialization and Update
    const chartElement = document.getElementById('combinedChart');
    if (chartElement) {
        const ctx = chartElement.getContext('2d');
        const combinedChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    { label: 'Users', data: [], borderColor: 'rgba(54, 162, 235, 1)', backgroundColor: 'rgba(54, 162, 235, 0.2)', fill: true, tension: 0.4 },
                    { label: 'Channels', data: [], borderColor: 'rgba(255, 99, 132, 1)', backgroundColor: 'rgba(255, 99, 132, 0.2)', fill: true, tension: 0.4 },
                    { label: 'Posts', data: [], borderColor: 'rgba(255, 206, 86, 1)', backgroundColor: 'rgba(255, 206, 86, 0.2)', fill: true, tension: 0.4 },
                    { label: 'Likes', data: [], borderColor: 'rgba(75, 192, 192, 1)', backgroundColor: 'rgba(75, 192, 192, 0.2)', fill: true, tension: 0.4 }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    x: { display: true, title: { display: true, text: 'Data' } },
                    y: { display: true, title: { display: true, text: 'Count' }, suggestedMin: 0 }
                }
            }
        });

        function updateChart(month, year) {
            fetch(`/admin/chart/data/${year}/${month}`)
                .then(response => response.json())
                .then(data => {
                    combinedChart.data.labels = data.labels || [];
                    combinedChart.data.datasets[0].data = data.users || [];
                    combinedChart.data.datasets[1].data = data.Channels || [];
                    combinedChart.data.datasets[2].data = data.comments || [];
                    combinedChart.data.datasets[3].data = data.UserVideoLike || [];
                    combinedChart.update();
                })
                .catch(error => console.error('Error fetching chart data:', error));
        }

        $('#monthSelector').on('change', () => updateChart($('#monthSelector').val(), $('#yearSelector').val()));
        $('#yearSelector').on('change', () => updateChart($('#monthSelector').val(), $('#yearSelector').val()));

        // Initial chart update
        updateChart($('#monthSelector').val(), $('#yearSelector').val());

        // System success function
        window.SystemSuccessFunction = () => window.location.reload();
    }

    // Posts Ajax
    let postsData = [];
    function fetchPosts(page = 1) {
        const $postsContainer = $('#posts-container');
        const $paginationContainer = $('#pagination-container');
        const $totalPosts = $('#total-posts');

        const searchInput = $('#search-input').val();
        const filter = $('#select-filter').val();
        const topic = $('#select-topic').val();
        const channel = $('#select-channel').val();
        const dataUrl = $postsContainer.data('url');


        $.ajax({
            url: dataUrl,
            type: 'GET',
            data: { page, filter, topic, channel, search: searchInput },
            success: function (response) {
                const { data = [], total, last_page, current_page } = response;
                postsData = data;

                // Generate post elements
                const postElements = data.map(post => `
                    <div class="col-sm-4 col-lg-3" data-id="${post.id}">
                        <div class="card card-sm pull-effect">
                            <div class="image-container" style="height: 230px;">
                            ${post.type == 'video' ? `<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-play-circle text-white card-play-button" viewBox="0 0 16 16">
                              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                              <path d="M6.271 5.055a.5.5 0 0 1 .52.038l3.5 2.5a.5.5 0 0 1 0 .814l-3.5 2.5A.5.5 0 0 1 6 10.5v-5a.5.5 0 0 1 .271-.445"/>
                            </svg>` : ""}
                                <img src="${post.type == 'post' ? post.image : post.video_thumb}" class="card-img-top-custom card-img-top h-100" alt="Post Image" onerror="this.onerror=null; this.src='/assets/images/no_image_available.png';">
                                ${post.type == 'video' ? '<div class="play-button"></div>' : ''}
                            </div>
                            <div class="card-body">
                                <h5 class="card-title custom-title">${post.title}</h5>
                                <div class="d-flex align-items-center mt-2">
                                    <img src="/storage/images/${post.channel_logo}" class="channel-post-icone" alt="Channel Logo">
                                    <div>
                                        <div>${post.channel_name}</div>
                                        <div class="text-secondary">${post.publish_date}</div>
                                    </div>
                                    <div class="ms-auto">
                                        <b class="text-secondary">
                                            <i class="fa fa-eye" aria-hidden="true"></i> ${post.view_count}
                                        </b>
                                        <b class="ms-3 text-secondary">
                                            <i class="fa fa-heart" aria-hidden="true"></i> ${post.favorite}
                                        </b>
                                        <b id="reaction-count" class="ms-3 text-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-thumb-up">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M13 3a3 3 0 0 1 2.995 2.824l.005 .176v4h2a3 3 0 0 1 2.98 2.65l.015 .174l.005 .176l-.02 .196l-1.006 5.032c-.381 1.626 -1.502 2.796 -2.81 2.78l-.164 -.008h-8a1 1 0 0 1 -.993 -.883l-.007 -.117l.001 -9.536a1 1 0 0 1 .5 -.865a2.998 2.998 0 0 0 1.492 -2.397l.007 -.202v-1a3 3 0 0 1 3 -3z" />
                                                <path d="M5 10a1 1 0 0 1 .993 .883l.007 .117v9a1 1 0 0 1 -.883 .993l-.117 .007h-1a2 2 0 0 1 -1.995 -1.85l-.005 -.15v-7a2 2 0 0 1 1.85 -1.995l.15 -.005h1z" />
                                            </svg> ${post.reactions_count ?? 0}
                                        </b>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `).join('');
                $postsContainer.html(postElements);

                // Generate pagination
                function createPageItem(page, label = page, active = false, disabled = false) {
                    return `
                        <li class="page-item ${active ? 'active' : ''} ${disabled ? 'disabled' : ''}">
                            <a class="page-link" href="javascript:void(0)" data-page="${page}">${label}</a>
                        </li>
                    `;
                }

                let paginationHtml = createPageItem(current_page - 1, trans('PREVIOUS'), false, current_page === 1);

                if (last_page <= 5) {
                    paginationHtml += Array.from({ length: last_page }, (_, i) => createPageItem(i + 1, i + 1, current_page === i + 1)).join('');
                } else {
                    paginationHtml += (current_page <= 3 ?
                        Array.from({ length: 3 }, (_, i) => createPageItem(i + 1, i + 1, current_page === i + 1)).join('') +
                        '<li class="page-item disabled"><span class="page-link">...</span></li>' +
                        createPageItem(last_page) :
                        current_page >= last_page - 2 ?
                            createPageItem(1) +
                            '<li class="page-item disabled"><span class="page-link">...</span></li>' +
                            Array.from({ length: 3 }, (_, i) => createPageItem(last_page - 2 + i, last_page - 2 + i, current_page === last_page - 2 + i)).join('') :
                            createPageItem(1) +
                            '<li class="page-item disabled"><span class="page-link">...</span></li>' +
                            Array.from({ length: 3 }, (_, i) => createPageItem(current_page - 1 + i, current_page - 1 + i, current_page === current_page - 1 + i)).join('') +
                            '<li class="page-item disabled"><span class="page-link">...</span></li>' +
                            createPageItem(last_page)
                    );
                }

                paginationHtml += createPageItem(current_page + 1, trans('NEXT'), false, current_page === last_page);
                $paginationContainer.html(paginationHtml);
                $totalPosts.html(`1-${data.length} ${trans('OF')} ${total} ${trans('POSTS')}`);
            },
            error: function (error) {
                console.error('Error fetching posts:', error);
            }
        });
    }

    function removeHtmlTags(description) {
        return description
            .replace(/<\/?[^>]+(>|$)/g, "")
            .replace(/&nbsp;/g, " ")
            .replace(/&#39;/g, "'")
            .replace(/&quot;/g, '"');
    }

    function showPostModal(post,delete_url) {

        if (post.type === 'post') {
            $('#video-preview').addClass('d-none');
            $('#post-image').removeClass('d-none').attr('src', post.image).on('error', function() {
                $(this).off('error').attr('src', '/assets/images/no_image_available.png');
            });
        } else {
            $('#post-image').addClass('d-none');
            $('#video-preview').removeClass('d-none').attr('src', post.video).on('error', function() {
                $(this).off('error').attr('src', '/assets/images/no_image_available.png');
            });
        }
        $('#post-title').text(removeHtmlTags(post.title));
        $('#channel-logo').attr('src', `/storage/images/${post.channel_logo}`).on('error', function() {
            $(this).off('error').attr('src', '/assets/images/no_image_available.png');
        });
        $('#channel-name').text(post.channel_name);
        $('#post-date').text(post.pubdate);
        $('#view-count').html(`<i class="bi bi-eye-fill"></i> ${post.view_count}`);
        $('#view-comments').html(`<i class="bi bi-chat-left-text-fill"></i> ${post.comment}`);
        $('#comments_url').attr('href', `/admin/comments?post=${post.slug}`);
        $('#favorite-count').html(`<i class="bi bi-heart-fill"></i> ${post.favorite}`);
        $('#source_url').attr('href', post.resource);
        $('#post-description-text').text(removeHtmlTags(post.description));
        $('#edit-post-btn').attr('href', `/admin/posts/${post.id}/edit`);
        $('#post_delete_url').attr('href', delete_url);
        $('#post-description').modal('show');
        $('#reaction-count').html(`
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-thumb-up">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M13 3a3 3 0 0 1 2.995 2.824l.005 .176v4h2a3 3 0 0 1 2.98 2.65l.015 .174l.005 .176l-.02 .196l-1.006 5.032c-.381 1.626 -1.502 2.796 -2.81 2.78l-.164 -.008h-8a1 1 0 0 1 -.993 -.883l-.007 -.117l.001 -9.536a1 1 0 0 1 .5 -.865a2.998 2.998 0 0 0 1.492 -2.397l.007 -.202v-1a3 3 0 0 1 3 -3z" />
                <path d="M5 10a1 1 0 0 1 .993 .883l.007 .117v9a1 1 0 0 1 -.883 .993l-.117 .007h-1a2 2 0 0 1 -1.995 -1.85l-.005 -.15v-7a2 2 0 0 1 1.85 -1.995l.15 -.005h1z" />
            </svg> ${response.reactions_count ?? 0}
        `);
        
    }

    // Event Delegation
    $('#posts-container').on('click', '.col-sm-4', function () {
        const post = postsData.find(p => p.id === $(this).data('id'));
        const currentURL = $(location).attr('href'); 
        const delete_url = currentURL+'/'+post.id;

        if (post) showPostModal(post,delete_url);

    });

    $(document).on('click', '.page-link', function () {
        const page = $(this).data('page');
        if (page) fetchPosts(page);
    });
    
    function onFilterChange() {
        fetchPosts();
    }

    $('#select-filter, #select-topic, #select-channel, #search-input').on('change keyup', onFilterChange);

    // Initial fetch
    fetchPosts();
});

$(document).ready(function () {
    // Initialize DataTables for error logs
    $('#table-log').DataTable({
        "order": [$('#table-log').data('orderingIndex'), 'desc'],
        "stateSave": true,
        "stateSaveCallback": function (settings, data) {
            window.localStorage.setItem("datatable", JSON.stringify(data));
        },
        "stateLoadCallback": function (settings) {
            var data = JSON.parse(window.localStorage.getItem("datatable"));
            if (data) data.start = 0;
            return data;
        }
    });

    // Bind click events for log actions
    $('#delete-log, #clean-log, #delete-all-log').click(function () {
        return confirm('Are you sure?');
    });

    // Initialize theme switcher for dark mode
    const darkSwitch = $('#darkSwitch');
    if (darkSwitch.length) {
        initTheme();
        darkSwitch.on('change', resetTheme);
    }

    // Search functionality for country list
    $('#countrySearch').on('input', function () {
        const searchTerm = $(this).val().toLowerCase();
        $('#countryList .country-item').each(function () {
            const countryName = $(this).data('name').toLowerCase();
            $(this).toggle(countryName.includes(searchTerm));
        });
    });

    // Initialize DataTables for user list
    initializeDataTable('#user_list_data', [
        {
            data: null,
            render: function (data, type, row) {
                return `<input type="checkbox" class="select-checkbox" value="${row.id}">`;
            },
            orderable: false,
            searchable: false
        },
        { data: 'id' },
        { data: 'name' },
        { data: 'mobile' }
    ], '#select_all');

    // Initialize DataTables for notification table
    initializeDataTable('#notificationTable', [
      /*   { data: null, orderable: false, searchable: false,
            render: function (data, type, row) {
                return `<input type="checkbox" class="row-select" value="${row.ID}">`;
            }}, */
        { data: 'id' },
        { data: 'title' },
        { data: 'slug' },
        { data: 'send_to' },
        { data: 'action', orderable: false, searchable: false }
    ], '#select_all_notification', '#delete_multiple');
});
 // Handle select all checkboxes logic
 $('#select_all_notification').on('click', function () {
    let table = $('#notificationTable').DataTable();
    let isChecked = $(this).prop('checked');
    table.rows().every(function () {
        $(this.node()).find('input[type="checkbox"]').prop('checked', isChecked);
    });
});

function initializeDataTable(selector, columns, selectAllSelector, deleteMultipleSelector) {
    var table = $(selector).DataTable({
        processing: true,
        serverSide: true,
        order: [[0, 'desc']],
        ajax: {
            url: $(selector).data('url'),
        },
        columns: columns,
        language: current_locale === 'en' ? englishLanguage : hindiLanguage,
    });

    if (selectAllSelector) {
        $(selectAllSelector).on('click', function () {
            var checked = $(this).prop('checked');
            $(`${selector} .select-checkbox, ${selector} .row-select`).prop('checked', checked);
        });
    }

    if (deleteMultipleSelector) {
        $(deleteMultipleSelector).on('click', function (e) {
            e.preventDefault();
            var selected = $(`${selector} .row-select:checked`).map(function () {
                return $(this).val();
            }).get();

            if (selected.length === 0) {
                showErrorToast('Please select notifications first.');
                return;
            }

            $.ajax({
                url: $(this).attr('href'),
                type: 'POST',
                data: { id: selected.join(',') },
                success: function (response) {
                    $(selector).DataTable().ajax.reload();
                    showSuccessToast(response.message);
                },
                error: function () {
                    showErrorToast('An error occurred while deleting notifications.');
                }
            });
        });
    }
}

document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            let storyId = this.getAttribute('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: trans("You wont be able to revert this"),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Delete',
                customClass: {
                    popup: 'dark:bg-black dark:text-white'
                  }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + storyId).submit();
                }
            });
        });
    });
});
