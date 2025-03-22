/* Change Profile */
$(document).ready(function () {
  $("#changeProfileForm").on("submit", function (event) {
    event.preventDefault();

    var form = $(this);
    var formData = new FormData(form[0]);
    $.ajax({
      url: form.attr("action"),
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },

      success: function (response) {
        showSuccessToast(response.message);
        setInterval(function () {
          window.location.href = "/admin/dashboard";
        }, 500);
      },  
      error: function (xhr, status, error) {},
    });
  });
});


/* Change Password */
$(document).ready(function () {
  $("#changePasswordForm").on("submit", function (event) {
    event.preventDefault();

    var form = $(this);
    var formData = new FormData(form[0]);

    $.ajax({
      url: form.attr("action"),
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      success: function (response) {
        $("#changePassword").modal("hide");
        showSuccessToast(response.message);
      },
      error: function (xhr, status, error) {
        if (xhr.responseJSON && xhr.responseJSON.errors) {
          var errors = xhr.responseJSON.errors;
          var errorMessages = Object.values(errors).flat().join("<br>");
          $("#validationErrors").html(errorMessages).removeClass("d-none");
        } else {
          $("#validationErrors")
            .html("An error occurred. Please try again.")
            .removeClass("d-none");
        }
      },
    });
  });
});
function showSuccessToast(message) {
  Toastify({
    text: message,
    duration: 6000,
    close: true,
    style: {
      background: "#28a745", // Green color
    },
  }).showToast();
}

/* Add Channel */
$(document).ready(function () {
  $("#addChannelForm").on("submit", function (e) {
    e.preventDefault();
    $("#name-error-message").text("");
    $("#status-error-message").text("");
    $("#logo-error-message").text("");

    var formData = new FormData(this);

    $.ajax({
      url: $(this).attr("action"),
      method: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        $("#addChannelModal").modal("hide");
        $("#addChannelForm")[0].reset();
        showSuccessToast(response.success);

        setInterval(function () {
          location.reload();
        }, 2000);
      },
      error: function (xhr) {
        if (xhr.status === 422) {
          var errors = xhr.responseJSON.errors;
          if (errors.name) {
            $("#name-error-message").text("Please enter channel name.");
          }
          if (errors.status) {
            $("#status-error-message").text("Please select a status.");
          }
          if (errors.logo) {
            $("#logo-error-message").text("Please upload a valid logo image.");
          }
        }
      },
    });
  });
});

/* Function for image cropper */
function postInitializeImageCropper(inputSelector, previewSelector, cropperContainerSelector, cropperImageSelector, hiddenInputName) {
  $(inputSelector).on('change', function (e) {
      let file = e.target.files[0];

      if (file) {
          let reader = new FileReader();
          reader.onload = function (event) {
              $(cropperImageSelector).attr('src', event.target.result);
              $(cropperContainerSelector).removeClass('d-none');
              $(previewSelector).hide();

              if (cropper) {
                  cropper.destroy();
              }

              cropper = new Cropper(document.getElementById(cropperImageSelector.slice(1)), {
                  aspectRatio: 1.7,
                  viewMode: 1,
                  autoCropArea: 0.8,
                  responsive: true,
              });
          };
          reader.readAsDataURL(file);
      }
  });

  $(cropperContainerSelector).on('click', '#crop-image', function () {
      const canvas = cropper.getCroppedCanvas();
      const croppedImageData = canvas.toDataURL('image/png');
      $(previewSelector).attr('src', croppedImageData);
      $(inputSelector).val('');
      $(cropperContainerSelector).hide();
      
      $('<input>').attr({
          type: 'hidden',
          name: hiddenInputName,
          value: croppedImageData
      }).appendTo($(inputSelector).closest('form'));
  });
}


$(document).ready(function () {
  $("#addRssFeedForm").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      url: $("#rssfeedstore").val(),
      method: $(this).attr("method"),
      data: new FormData(this),
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        if (response.success) {
          $("#addRssFeedModal").modal("hide");
          $("#addRssFeedForm")[0].reset();
        }
        showSuccessToast(response.message);

        setInterval(function () {
          location.reload();
        }, 2000);
      },
      error: function (xhr) {
        if (xhr.status === 422) {
          let errors = xhr.responseJSON.errors;
          $.each(errors, function (key, value) {
            let element = $("[name=" + key + "]");
            element.closest(".form-group").find(".parsley-required").remove();
            element.after(
              '<span class="parsley-required">' + value[0] + "</span>"
            );
          });
        }
      },
    });
  });
});


function clearErrorMessages() {
  $(".text-danger strong").text("");
}
function addDisplayErrors(errors) {
  clearErrorMessages();

  const errorMap = {
    title: "#title-error-message",
    description: "#description-error-message",
    channel_id: "#channel-error-message",
    topic_id: "#topic-error-message",
    status: "#status-error-message",
    image: "#image-error-message",
  };

  Object.keys(errors).forEach((field) => {
    const errorElementId = errorMap[field];
    if (errorElementId) {
      $(errorElementId).text(errors[field][0]);

      $(`[name="${field}"]`).addClass("is-invalid");
    }
  });
}

function editDisplayErrors(errors) {
  clearErrorMessages();

  const errorMap = {
    title: "#edit-title-error-message",
    description: "#edit-description-error-message",
    channel_id: "#edit-channel-error-message",
    topic_id: "#edit-topic-error-message",
    status: "#edit-status-error-message",
    image: "#edit-image-error-message",
  };

  Object.keys(errors).forEach((field) => {
    const errorElementId = errorMap[field];
    if (errorElementId) {
      $(errorElementId).text(errors[field][0]);

      $(`[name="${field}"]`).addClass("is-invalid");
    }
  });
}

/* Add Post ajex */
$(document).ready(function() {

  /* Initialize cropper */
  postInitializeImageCropper('#post-image-input', '#post-image-preview', '#cropper-container', '#cropper-image', 'cropped_logo');
  postInitializeImageCropper('#video-thumb-input', '#video-thumb-preview', '#thumb-cropper-container', '#video-thumb-cropped', 'cropped_thumb');

  // Handle form submission
  $("#addPostForm").on("submit", function (event) {
      event.preventDefault();
      clearErrorMessages();
      var formData = new FormData(this);

      if (cropper) {
          const canvas = cropper.getCroppedCanvas();
          canvas.toBlob(function (blob) {
            const postType = $("#select_type_posts").val();
            if(postType == "video"){
                const file = new File([blob], "cropped-image.png", {
                    type: "image/png",
                });
                formData.set("thumb_image", file);
              }else{
                const file = new File([blob], "cropped-thumb.png", {
                    type: "image/png",
                });
                formData.set("image", file);
              }
              submitForm(formData);
          });
      } else {
          submitForm(formData);
      }
  });

  // Function to handle form submission via AJAX
  function submitForm(formData) {
      const url = $('#addPostForm').attr("action");
      const method = $('#addPostForm').attr("method");
      $('#submite_button').attr("disabled", true);
      $('#back_button').attr("disabled", true);

      $.ajax({
          url: url,
          method: method,
          data: formData,
          processData: false,
          contentType: false,
          headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          },
          dataType: "json",
          success: function (response) {
              if (response.success) {
                $('#submite_button').attr("disabled", false);
                $('#back_button').attr("disabled", false);
                  clearErrorMessages();
                  $("#create-post").modal("hide");
                  $("#addPostForm")[0].reset();
                  showSuccessToast(response.message);
                  setTimeout(function () {
                    const baseUrl = window.location.origin;
                    const redirectUrl = baseUrl + "/admin/posts/"
                    window.location.href = redirectUrl;
                  }, 2000);
              }
          },
          error: function (xhr) {
              if (xhr.status === 422) {
                  addDisplayErrors(xhr.responseJSON.errors);
                  $('#submite_button').attr("disabled", false);
                  $('#back_button').attr("disabled", false);
              } else {
                  showErrorToast("An error occurred while processing your request.");
              }
          },
      });
  }
});

/* Edit Post ajex */
$(document).ready(function() {

  /* Initialize cropper */
  postInitializeImageCropper('#post-image-input','#post-image-preview','#cropper-container','#cropper-image','cropped_logo');
  postInitializeImageCropper('#video-thumb-input', '#video-thumb-preview', '#thumb-cropper-container', '#video-thumb-cropped', 'cropped_thumb');

  $("#editPostForm").on("submit", function (event) {
    event.preventDefault();
    clearErrorMessages();

    $('#submite_button').attr("disabled", true);
    $('#back_button').attr("disabled", true);
    
    var imageUrl = $('#cropper-image').attr('src');
    var imageThumbUrl = $('#video-thumb-cropped').attr('src');

    var formData = new FormData(this);
    formData.append("_method", "PUT");
    if(imageUrl != ""){
      const canvas = cropper.getCroppedCanvas();
      canvas.toBlob(function (blob) {
        const file = new File([blob], "cropped-image.png", { type: "image/png" });
        formData.set("image", file);
        updatePosts(formData)
      });
    }else if(imageThumbUrl != ""){
      const canvas = cropper.getCroppedCanvas();
      canvas.toBlob(function (blob) {
        const file = new File([blob], "cropped-image.png", { type: "image/png" });
      formData.set("thumb_image", file);
        updatePosts(formData)
      });
    }else{
      formData.set("image", "");
      updatePosts(formData)
    }
  });

  function updatePosts(formData){
    const url = $('#editPostForm').attr("action");


    $.ajax({
      url: url,
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      dataType: "json",
      success: function (response) {
        if (response.success) {
          $('#submite_button').attr("disabled", false);
          $('#back_button').attr("disabled", false);

          clearErrorMessages();
          /* redirect back */
          showSuccessToast(response.message);
          setTimeout(function () {
            const baseUrl = window.location.origin;
            const redirectUrl = baseUrl + "/admin/posts/"
            window.location.href = redirectUrl;
          }, 2000);
        }
      },
      error: function (xhr) {
        if (xhr.status === 422) {
          $('#submite_button').attr("disabled", false);
          $('#back_button').attr("disabled", false);
          addDisplayErrors(xhr.responseJSON.errors);
        } else {
          showErrorToast("An error occurred while processing your request.");
        }
      },
    });
  }
});

$(document).ready(function() {
  $('#fetch_rssfeed').on('click', function(e) {
      e.preventDefault();
      var url = window.location.origin + '/admin/run-queue'
      var $btn = $(this);
      $btn.attr('disabled', true).text('Syncing...');

      $.ajax({
          url: url,
          type: 'GET',
          success: function(response) {
              $btn.attr('disabled', false).text('Sync Feeds');
              showSuccessToast(response.message);
          },
          error: function(xhr, status, error) {
              $btn.attr('disabled', false).text('Sync Feeds');
              showErrorToast('An error occurred. Please try again.');
          }
      });
  });
});


  const postType = $("#select_type_posts").val();
  if(postType == "video"){
    $('#posts_image_upload').addClass('d-none');
    $('#video_file').removeClass('d-none');
    $('#video_thumbnail').removeClass('d-none');
  }else{
    $('#posts_image_upload').removeClass('d-none');
    $('#video_file').addClass('d-none');
    $('#video_thumbnail').addClass('d-none');
  }
  $("#select_type_posts").on("input change", function () {
    
  const postType = $("#select_type_posts").val();
    if(postType == "video"){
      $('#posts_image_upload').addClass('d-none');
      $('#video_file').removeClass('d-none');
      $('#video_thumbnail').removeClass('d-none');
    }else{
      $('#posts_image_upload').removeClass('d-none');
      $('#video_file').addClass('d-none');
      $('#video_thumbnail').addClass('d-none');
    }
  });

  function readChapterVideo(input) {
    $('.video-thumb').show();
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.video-thumb').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
  }
