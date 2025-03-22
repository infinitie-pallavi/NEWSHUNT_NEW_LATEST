/* Copy url */
document.addEventListener('DOMContentLoaded', function () {
    // Select both buttons by their IDs
    var buttons = [document.getElementById('copyButton'), document.getElementById('copyButton_1')];

    buttons.forEach(function(button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            var currentUrl = window.location.href;

            var textarea = document.createElement('textarea');
            textarea.value = currentUrl;
            document.body.appendChild(textarea);

            textarea.select();
            document.execCommand('copy');

            document.body.removeChild(textarea);
            iziToast.success({
                title: 'Copied Successfully',
                position: 'topCenter',
            });
        });
    });
});
/* Bookmark Post */
$(document).ready(function(){
    let id = $('#post_id').val();
    let bookmark_button = $('#bookmark-post');

    bookmark_button.click(function(event) {
        event.preventDefault();

        $.ajax({
            url: '/posts/favorite',
            method: 'POST',
            data: {
                id: id,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                const favorit_count = $('#favorite_counts')
                if(response.status == 1) {
                    iziToast.success({
                        title: response.message,
                        position: 'topCenter',
                    });
                    favorit_count.text(response.count);
                    $('#bookmark-post i').removeClass('bi-bookmarks').addClass('bi-bookmarks-fill');
                } else {
                    iziToast.success({
                        title: response.message,
                        position: 'topCenter',
                    });
                        favorit_count.text(response.count);
                    $('#bookmark-post i').removeClass('bi-bookmarks-fill').addClass('bi-bookmarks');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error occurred: ' + error);
            }
        });
    });
});



document.addEventListener("DOMContentLoaded", function() {
    const postId = document.getElementById('post_id').value;

    // Fetch comments
    function fetchComments() {
        fetch(`/posts/${postId}/comments`)
            .then(response => response.json())
            .then(data => {
                renderComments(data.comments);
                updateCommentCount(data.count);
            })
            .catch(error => console.error('Error fetching comments:', error));
    }
    
    // Render comments
    function renderComments(comments) {
        const commentsList = document.getElementById('comments-list');
        commentsList.innerHTML = '';
        comments.forEach(comment => {
            commentsList.appendChild(createCommentElement(comment));
        });
    }
    
    // Update the comment count in the HTML
    function updateCommentCount(count) {
        const commentCountElement = document.querySelector('#blog-comment h4');
        commentCountElement.innerText = `Comments (${count})`;
    }
    

    // Create a comment element
    function createCommentElement(comment) {
        const li = document.createElement('li');
        var button = document.getElementById("user_id").value;
        $(li).addClass('m-lg-1 comment-item py-0 px-0 border hover:border-primary dark:bg-black custom-margin-0');
        const userName = comment.user ? comment.user.name : 'Anonymous';
        const userId =  comment.user_id ?? '0';
        const commentId =  comment.id ?? '0';
        const defaultProfileUrl = `${window.location.origin}/public/front_end/classic/images/default/profile-avatar.jpg`;
        const userProfile = comment.user && comment.user.profile ? comment.user.profile : defaultProfileUrl;
        li.innerHTML = `
                        <div class="comment-container dark:bg-black">
                            <div class="h-48px w-48px mt-1 m-r-1 custim-left-margin-10">
                                <img src="${userProfile}" alt="User Avatar" class="w-32px h-32px rounded-circle object-fit-cover pointer-cursor">
                            </div>
                            <div class="comment-content w-100">
                                <div class="custim-left-margin-10">
                                    <p class="opacity-50">${userName}
                                        <a onclick="setReportId(${commentId})" id='report_user_comment' data-bs-toggle='tooltip' data-comment-id='${commentId}' title='Delete'>
                                            <i class="bi bi-flag-fill"></i>
                                        </a> 
                                        ${userId == button ? 
                                            `<a class="custim-left-margin-10" onclick="setEditId(${commentId})"><i class='bi bi-pencil-fill'></i></a>
                                             <a href='javascript:void(0);' class='btn btn-sm text-danger' id='delete_user_comment' data-bs-toggle='tooltip' data-comment-id='${commentId}' title='Delete'><i class="bi bi-trash3-fill text-primary"></i></a>`
                                            : ""
                                        }
                                    </p>
                                    <span class="c_date">${comment.created_at}</span>
                                </div>
                                <div class="fw-medium custim-left-margin-10">${comment.comment} <br>${comment.parent_id ? '' :`<span class="c_reply fs-7"><a onclick="setParentId(${commentId})">Reply</a></span> `}
                                    <div class="card d-none col-11 dark:bg-black" id="comment_report_box_${commentId}">
                                        <div class="card-header d-flex justify-between">
                                            <span>Report Comment</span>
                                            <a class="text-none" onclick="closeModelReport(${commentId})" id="close_report_${commentId}">
                                                <i class="unicon-close"></i>
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <form id="report-form" class="mb-0" onsubmit="submitCommentReport(event,${commentId})">
                                                <input type="hidden" name="comment_id" id="comment_id_${commentId}" value="${commentId}">
                                                <textarea class="form-control col-12 mr-1" name="comment" id="comment_report_${commentId}" rows="3" required></textarea>
                                                ${button !== "0" ?
                                                    `<button class="btn btn-primary btn-xs mt-2 mb-0" type="submit">Send</button>` : 
                                                    `<a class="btn btn-primary btn-xs mt-1" href="#uc-account-modal" data-uc-toggle>Send</a>`
                                                }
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card d-none col-11 dark:bg-black" id="comment_repay_box_${commentId}">
                                    <div class="card-header d-flex justify-between">
                                        <span>Leave Comment</span>
                                        <a class="text-none" onclick="closeModel(${commentId})" id="close_replay_${commentId}"><i class="unicon-close"></i></a>
                                    </div>
                                    <div class="card-body">
                                        <form id="replay-form" class="mb-0" onsubmit="submitCommentReplay(event,${commentId})">
                                            <input type="hidden" name="parent_id" id="parent-id_${commentId}" value="${commentId}">
                                            <textarea class="form-control col-12 mr-1" name="comment" id="comment_replay_${commentId}" rows="3" required></textarea>
                                            ${button !== "0" ?  `<button class="btn btn-primary btn-xs mt-2 mb-0" type="submit">Send</button>` : 
                                            `<a class="btn btn-primary btn-xs mt-1" href="#uc-account-modal" data-uc-toggle>Send</a>`}
                                        </form>
                                    </div>
                                </div>
                                <div class="card d-none col-11 dark:bg-black" id="comment_edit_box_${commentId}">
                                    <div class="card-header d-flex justify-between">
                                        <span>Edit Comment</span>
                                        <a class="text-none" onclick="closeModelEdit(${commentId})" id="close_edit_${commentId}"><i class="unicon-close"></i></a>
                                    </div>
                                    <div class="card-body">
                                        <form id="edit-comment-form" class="mb-0" onsubmit="submitCommentEdit(event, ${commentId} )">
                                            <input type="hidden" name="comment_id" id="comment_id" value="${commentId}">
                                            <textarea class="form-control col-12 mr-1" name="comment" id="comment_update_${commentId}" rows="3" required>${comment.comment}</textarea>

                                            ${button !== "0" ?  `<button class="btn btn-primary btn-xs mt-2 mb-0" type="submit">Send</button>` : 
                                            
                                            `<a class="btn btn-primary btn-xs mt-1" href="#uc-account-modal" data-uc-toggle>Send</a>`}
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>`;

        if (comment.replies && comment.replies.length) {
            const repliesList = document.createElement('ol');
            $(repliesList).addClass('replies-list dark:bg-black');
            comment.replies.forEach(reply => {
                repliesList.appendChild(createCommentElement(reply));
            });
            li.appendChild(repliesList);
        }

        return li;
    }

    window.setParentId = function(parentId) {
        document.getElementById('comment_repay_box_'+parentId).classList.remove('d-none');
    };

    window.setEditId = function(parentId) {
        document.getElementById('comment_edit_box_'+parentId).classList.remove('d-none');
    };

    window.setReportId = function(parentId) {
        document.getElementById('comment_report_box_'+parentId).classList.remove('d-none');
    };

    window.closeModel = function(commentId) {
        const replyBox = document.getElementById(`comment_repay_box_${commentId}`);
        if (replyBox) {
            replyBox.classList.add('d-none');
        }
    }

    window.closeModelEdit = function(commentId) {
        const replyBox = document.getElementById(`comment_edit_box_${commentId}`);
        if (replyBox) {
            replyBox.classList.add('d-none');
        }
    }

    window.closeModelReport = function(commentId) {
        const replyBox = document.getElementById(`comment_report_box_${commentId}`);
        if (replyBox) {
            replyBox.classList.add('d-none');
        }
    }

    // Submit a comment
    window.submitComment = function(event) {
        event.preventDefault();

        const commentText = document.getElementById('comment').value;
        const parentId = "";
        const sendDataUrl = document.getElementById('sendDataUrl').value;

        const data = {
            comment: commentText,
            parent_id: parentId ? parentId : null,
            post_id: postId
        };

        fetch(sendDataUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchComments(); // Render the new comment
                document.getElementById('comment').value = '';
            }
        })
        .catch(error => {
            
        });
    };

    // Submit a comment replay
    window.submitCommentReplay = function(event, replay_id) {
        event.preventDefault();
        var parentId = document.getElementById('parent-id_'+replay_id).value;
        const commentText = document.getElementById('comment_replay_'+replay_id).value;
        const sendDataUrl = document.getElementById('sendDataUrl').value;
        const data = {
            comment: commentText,
            parent_id: parentId ? parentId : null,
            post_id: postId
        };
        fetch(sendDataUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const replyBox = document.getElementById(`comment_repay_box_${parentId}`);
                    replyBox.classList.add('d-none');
                fetchComments();
            } else {
                console.error(data.errors || data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    };

    // Submit a comment edit
    window.submitCommentEdit = function(event, comment_edit_id) {
        event.preventDefault();

        const commentText = document.getElementById('comment_update_'+comment_edit_id).value;
        const sendDataUrl = document.getElementById('updateDataUrl').value;

        const data = {
            comment: commentText,
            id: comment_edit_id
        };

        fetch(sendDataUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success == true) {
                const replyBox = document.getElementById(`comment_edit_box_${comment_edit_id}`);
                    replyBox.classList.add('d-none');
                fetchComments();
            }
        })
        .catch(error => {
        });
    };


    /* Report Comment */
    window.submitCommentReport = function(event, comment_edit_id) {
        event.preventDefault();
        const reportText = document.getElementById('comment_report_'+comment_edit_id).value;
        const userId = document.getElementById('user_id').value;
        const sendDataUrl = document.getElementById('reportDataUrl').value;
        const data = {
            id: userId,
            report: reportText,
            reportCommentId: comment_edit_id
        };
        
        fetch(sendDataUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.error == false) {
                const replyBox = document.getElementById(`close_report_${comment_edit_id}`);
                    replyBox.classList.add('d-none');

                    fetchComments();
                    iziToast.success({
                        title: data.message,
                        position: 'topCenter',
                    });
            }else{
                iziToast.error({
                    title: data.message,
                    position: 'topCenter',
                });
            }
        })
        .catch(error => {
            console.log(error);
        });
    };
    
    fetchComments();

    

    function deleteComment(commentId){
        $.ajax({
            url: '/admin/user-comments/' + commentId,
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                if (response.message) {
                   iziToast.success({
                    title: response.message,
                    position: 'topCenter',
                });
                fetchComments();
            } else {
                    iziToast.success({
                    title:"Fail to Delete",
                    position: 'topCenter',
                    });
                }
            },
            error: function() {
                iziToast.success({
                    title:"An error occurred while deleting",
                    position: 'topCenter',
                });
            }
        });
    }
    
    $(document).on('click', '#delete_user_comment', function(e) {
        e.preventDefault();
        const commentId = $(this).data('comment-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this comment..!",
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
                deleteComment(commentId)
                }
            });
    });



});