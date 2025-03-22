document.addEventListener('DOMContentLoaded', function() {
    const profileImagePreview = document.getElementById('profile-image-preview');
    const profileImageInput = document.getElementById('change-profile');
  if(profileImageInput){
    
    profileImageInput.addEventListener('change', function(event) {
    const file = event.target.files[0]; 
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profileImagePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    }
  });

 document.getElementById('profileImage').addEventListener('click', function() {
    document.getElementById('dropdownMenu').classList.toggle('show');
});

document.getElementById('logout-link').addEventListener('click', function(event) {
  event.preventDefault(); // Prevent the default anchor click behavior
  document.getElementById('logout-form').submit(); // Submit the logout form
});

window.onclick = function(event) {
    if (!event.target.matches('#profileImage')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

/* Open Register model */
document.addEventListener('DOMContentLoaded', () => {
    const openSignupModalMobile = document.querySelector('.open-signup-modal-mobile');
    const openSignupModal = document.querySelector('.open-signup-modal');
    const ucAccountModal = document.getElementById('uc-account-modal');
  
    // Check if the elements exist before adding event listeners
    if (openSignupModalMobile && ucAccountModal) {
      openSignupModalMobile.addEventListener('click', () => {
        ucAccountModal.querySelector('li:nth-child(2) a').click();
      });
    }
  
    if (openSignupModal && ucAccountModal) {
      openSignupModal.addEventListener('click', () => {
        ucAccountModal.querySelector('li:nth-child(2) a').click();
      });
    }
  });