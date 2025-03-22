let slideCount = document.querySelectorAll(".accordion-item").length;
let currentStep = 1;
const totalSteps = 5;
const form = document.getElementById("storyForm");
const nextBtn = document.getElementById("nextStep");
const prevBtn = document.getElementById("prevStep");
const submitBtn = document.getElementById("submitForm");

// Animation settings
let currentAnimations = {
  title: { type: "fade-in", delay: 0, duration: 1 },
  description: { type: "fade-in", delay: 0.2, duration: 1 },
  image: { type: "fade-in", delay: 0.4, duration: 1 },
};
// Initialize event listeners when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
  // Add delete handlers to existing slides
  document.querySelectorAll(".delete-slide").forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();
      const slideIndex = this.getAttribute("data-slide-index");
      deleteSlide(slideIndex);
    });
  });

  // Initialize slide title updates for existing slides
  document
    .querySelectorAll('input[name^="slides"][name$="[title]"]')
    .forEach((input) => {
      input.addEventListener("input", function () {
        const slideIndex = this.name.match(/\[(\d+)\]/)[1];
        updateSlideTitle(slideIndex, this.value);
      });
    });
});

// Add new slide functionality
document.getElementById("addMoreSlides").addEventListener("click", function () {
  const accordionItem = document.createElement("div");
  accordionItem.classList.add("accordion-item");

  const accordionId = `collapseSlide${slideCount}`;
  const base_url = window.location.origin;

  const defaultImage = base_url+'/assets/images/no_image_available.png';
  accordionItem.innerHTML = `
    <h2 class="accordion-header d-flex align-items-center justify-content-between">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                data-bs-target="#${accordionId}" aria-expanded="false">
            ${__("New Slide ")} 
        </button>
        <button type="button" class="btn btn-link text-danger delete-slide me-2" 
                data-slide-index="${slideCount}" style="padding: 0; background: none; border: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                 fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-trash">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16z" />
                <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" />
            </svg>
        </button>
    </h2>

    <div id="${accordionId}" class="accordion-collapse collapse show" data-bs-parent="#accordionSlides">
        <div class="accordion-body">
            <div class="slide-entry mb-4 border p-3 rounded" data-slide-index="${slideCount}">
                <div class="mb-3">
                    <label class="form-label required">${__(
                      "Slide Title"
                    )}</label>
                    <input type="text" name="slides[${slideCount}][title]" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">${__("Slide Description")}</label>
                    <textarea name="slides[${slideCount}][description]" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label required">${__(
                      "Slide Image"
                    )}</label>
                    <input type="file" name="slides[${slideCount}][image]" class="form-control" required 
                           accept="image/*" onchange="editPreviewImage(event, ${slideCount})">
                    
                    <div class="mt-3">
                        <img id="imagePreview${slideCount}" 
                             src="${defaultImage}" 
                             alt="Preview" class="img-slide rounded">
                    </div>
                </div>
            </div>
        </div>
    </div>
`;

  document.getElementById("accordionSlides").appendChild(accordionItem);

  // Add to order list
  const slidePreview = document.createElement("div");
  slidePreview.classList.add("slide-preview");
  slidePreview.setAttribute("draggable", "true");
  slidePreview.setAttribute("data-index", slideCount);
  slidePreview.innerHTML = `
    <img src="${assetUrl("assets/images/no_image_available.png")}" 
         alt="Preview" id="imagePreviewThumbnail${slideCount}" 
         style="width: 100px; height: 60px; object-fit: cover;">
    <span id="slideTitle${slideCount}">${__("New Slide")}</span>
`;
  document.getElementById("slides-order").appendChild(slidePreview);

  // Add event listeners for new slide
  const deleteButton = accordionItem.querySelector(".delete-slide");
  deleteButton.addEventListener("click", function (e) {
    e.preventDefault();
    e.stopPropagation();
    const slideIndex = this.getAttribute("data-slide-index");
    deleteSlide(slideIndex);
  });

  // Add title update listener
  const titleInput = accordionItem.querySelector(
    'input[name^="slides"][name$="[title]"]'
  );
  titleInput.addEventListener("input", function () {
    updateSlideTitle(slideCount, this.value);
  });

  slideCount++;
});

// Delete slide function
function deleteSlide(slideIndex) {
  if (confirm(__("Are you sure you want to delete this slide?"))) {
    // Find the slide elements
    const accordionItem = document.querySelector(
      `.accordion-item:has([data-slide-index="${slideIndex}"])`
    );
    const slidePreview = document.querySelector(
      `.slide-preview[data-index="${slideIndex}"]`
    );
    const slideEntry = document.querySelector(
      `.slide-entry[data-slide-index="${slideIndex}"]`
    );

    // Check if this is an existing slide (has an ID)
    const slideIdInput = slideEntry?.querySelector(
      'input[name^="slides"][name$="[id]"]'
    );
    if (slideIdInput) {
      // Create a hidden input to mark this slide for deletion
      const deleteInput = document.createElement("input");
      deleteInput.type = "hidden";
      deleteInput.name = `delete_slides[]`;
      deleteInput.value = slideIdInput.value;
      document.getElementById("storyForm").appendChild(deleteInput);
    }

    // Remove elements from DOM
    if (accordionItem) accordionItem.remove();
    if (slidePreview) slidePreview.remove();

    validateCurrentStep(); // Revalidate after deletion

    // Show permission notification
    const notification = document.createElement("div");

    // Insert notification at the top of the form
    const form = document.getElementById("storyForm");
    form.insertBefore(notification, form.firstChild);

    // Auto-remove notification after 3 seconds
    setTimeout(() => {
      notification.remove();
    }, 3000);
  }
}

// Update slide title function
function updateSlideTitle(slideIndex, newTitle) {
  const slidePreviewTitle = document.getElementById(`slideTitle${slideIndex}`);
  if (slidePreviewTitle) {
    slidePreviewTitle.textContent =
      newTitle || `${__("Slide")} ${parseInt(slideIndex) + 1}`;
  }
}

// Image preview function
function editPreviewImage(event, slideIndex) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById(`imagePreview${slideIndex}`).src =
        e.target.result;
      document.getElementById(`imagePreviewThumbnail${slideIndex}`).src =
        e.target.result;
    };
    reader.readAsDataURL(file);
  }
}

// Step navigation functions
function updateNavButtons() {
  prevBtn.style.display = currentStep > 1 ? "block" : "none";
  nextBtn.style.display = currentStep < totalSteps ? "block" : "none";
  submitBtn.style.display = currentStep === totalSteps ? "block" : "none";
}

function showStep(step) {
  document.querySelectorAll('.step-content').forEach(el => el.classList.add('d-none'));
  document.getElementById(`step${step}`).classList.remove('d-none');
  currentStep = step;

  // Update progress bar
  document.querySelectorAll('.progressbar li').forEach((li, index) => {
      if (index + 1 <= step) {
          li.classList.add('active');
      } else {
          li.classList.remove('active');
      }
  });

  updateNavButtons();
}

// Validation function
function validateCurrentStep() {
  const currentStepEl = document.getElementById(`step${currentStep}`);
  const requiredFields = currentStepEl.querySelectorAll("[required]");
  let valid = true;

  requiredFields.forEach((field) => {
    if (!field.value) {
      valid = false;
      field.classList.add("is-invalid");
    } else {
      field.classList.remove("is-invalid");
    }
  });

  // Additional validation for minimum slides in step 2
  if (currentStep === 2) {
    const slideCount = document.querySelectorAll(".slide-entry").length;
    if (slideCount === 0) {
      valid = false;
      const errorDiv = document.createElement("div");
      errorDiv.className = "alert alert-danger mt-3 text-center";
      errorDiv.textContent = __("At least one slide is required");
      const existingError = document.querySelector(".alert-danger");
      if (!existingError) {
        document.getElementById("step2").prepend(errorDiv);
      }
    } else {
      const existingError = document.querySelector(".alert-danger");
      if (existingError) existingError.remove();
    }
  }

  return valid;
}

// Navigation event listeners

nextBtn.addEventListener('click', () => {
  if (validateCurrentStep()) {
      showStep(currentStep + 1);
  }
});

prevBtn.addEventListener('click', () => {
  showStep(currentStep - 1);
});

// Form submission
form.addEventListener("submit", function (e) {
  e.preventDefault();
  if (validateCurrentStep()) {
    // Capture current slide order
    const slideOrder = Array.from(
      document.querySelectorAll(".slide-preview")
    ).map((slide) => parseInt(slide.getAttribute("data-index")));

    // Create hidden input for slide order
    const orderInput = document.createElement("input");
    orderInput.type = "hidden";
    orderInput.name = "slide_order";
    orderInput.value = JSON.stringify(slideOrder);
    this.appendChild(orderInput);

    // Capture animation settings (if applicable)
    const animationSettings = document.createElement("input");
    animationSettings.type = "hidden";
    animationSettings.name = "animation_settings";

    const animationData = {
      title: {
        type: document.querySelector('[name="title_animation"]').value,
        delay: document.querySelector('[name="title_delay"]').value,
        duration: document.querySelector('[name="title_duration"]').value,
      },
      description: {
        type: document.querySelector('[name="description_animation"]').value,
        delay: document.querySelector('[name="description_delay"]').value,
        duration: document.querySelector('[name="description_duration"]').value,
      },
      image: {
        type: document.querySelector('[name="image_animation"]').value,
        delay: document.querySelector('[name="image_delay"]').value,
        duration: document.querySelector('[name="image_duration"]').value,
      },
    };

    animationSettings.value = JSON.stringify(animationData);
    this.appendChild(animationSettings);

    this.submit();
  }
});

// Drag and drop functionality
const slidesOrder = document.getElementById("slides-order");

slidesOrder.addEventListener("dragstart", function (e) {
  if (e.target.classList.contains("slide-preview")) {
    e.target.classList.add("dragging");
  }
});

slidesOrder.addEventListener("dragend", function (e) {
  if (e.target.classList.contains("slide-preview")) {
    e.target.classList.remove("dragging");
  }
});

slidesOrder.addEventListener("dragover", function (e) {
  e.preventDefault();
  const draggingSlide = document.querySelector(".dragging");
  if (draggingSlide) {
    const afterElement = getDragAfterElement(this, e.clientY);
    if (afterElement == null) {
      this.appendChild(draggingSlide);
    } else {
      this.insertBefore(draggingSlide, afterElement);
    }
  }
});

function getDragAfterElement(container, y) {
  const draggableElements = [
    ...container.querySelectorAll(".slide-preview:not(.dragging)"),
  ];

  return draggableElements.reduce(
    (closest, child) => {
      const box = child.getBoundingClientRect();
      const offset = y - box.top - box.height / 2;

      if (offset < 0 && offset > closest.offset) {
        return {
          offset: offset,
          element: child,
        };
      } else {
        return closest;
      }
    },
    {
      offset: Number.NEGATIVE_INFINITY,
    }
  ).element;
}

// Helper function to handle asset URLs
function assetUrl(path) {
  return path; // Replace with your actual asset URL handling logic
}

// Helper function for translations
function __(string) {
  return string; // Replace with your actual translation logic
}

// Initialize the first step
showStep(1);

// Initialize slide title updates
document
  .querySelectorAll('input[name^="slides"][name$="[title]"]')
  .forEach((input) => {
    input.addEventListener("input", function () {
      const slideIndex = this.name.match(/\[(\d+)\]/)[1];
      const slidePreviewTitle = document.getElementById(
        `slideTitle${slideIndex}`
      );
      if (slidePreviewTitle) {
        slidePreviewTitle.textContent =
          this.value || `Slide ${parseInt(slideIndex) + 1}`;
      }
    });
  });
// Initialize animation controls and preview
document.addEventListener("DOMContentLoaded", function () {
  const previewTitle = document.getElementById("previewTitle");
  const previewDescription = document.getElementById("previewDescription");
  const previewImage = document.getElementById("previewImage");
  const previewContent = document.getElementById("previewContent");
  const previewPlaceholder = document.querySelector(".preview-placeholder");

  // Animation configuration objects
  const animationTypes = {
    "fade-in": {
      initial: { opacity: 0 },
      animate: { opacity: 1 },
    },
    "slide-up": {
      initial: { opacity: 0, transform: "translateY(20px)" },
      animate: { opacity: 1, transform: "translateY(0)" },
    },
    "slide-down": {
      initial: { opacity: 0, transform: "translateY(-20px)" },
      animate: { opacity: 1, transform: "translateY(0)" },
    },
    "zoom-in": {
      initial: { opacity: 0, transform: "scale(0.95)" },
      animate: { opacity: 1, transform: "scale(1)" },
    },
    "slide-in": {
      initial: { opacity: 0, transform: "translateX(-20px)" },
      animate: { opacity: 1, transform: "translateX(0)" },
    },
  };

  // Initialize preview content
  function initializePreview() {
    const firstSlide = document.querySelector(".slide-entry");
    if (firstSlide) {
      const title = firstSlide.querySelector('input[name$="[title]"]').value;
      const description = firstSlide.querySelector(
        'textarea[name$="[description]"]'
      ).value;
      const imagePreview = firstSlide.querySelector(".img-preview").src;

      previewTitle.textContent = title;
      previewDescription.textContent = description;
      previewImage.src = imagePreview;

      previewPlaceholder.classList.add("d-none");
      previewContent.classList.remove("d-none");
    }
  }

  // Apply animation to element
  function applyAnimation(element, type, delay, duration) {
    if (!element || !animationTypes[type]) return;

    // Reset element styles
    element.style.transition = "";
    Object.assign(element.style, animationTypes[type].initial);

    // Force reflow
    element.offsetHeight;

    // Apply animation
    element.style.transition = `all ${duration}s ease-out`;
    element.style.transitionDelay = `${delay}s`;

    requestAnimationFrame(() => {
      Object.assign(element.style, animationTypes[type].animate);
    });
  }

  // Preview animation handler
  function previewAnimation() {
    previewContent.classList.remove("d-none");
    previewPlaceholder.classList.add("d-none");

    // Reset all elements
    [previewTitle, previewDescription, previewImage].forEach((element) => {
      element.style.opacity = "0";
      element.style.transform = "none";
    });

    // Get animation settings
    const titleAnimation = document.querySelector(
      '[name="title_animation"]'
    ).value;
    const titleDelay = parseFloat(
      document.querySelector('[name="title_delay"]').value
    );
    const titleDuration = parseFloat(
      document.querySelector('[name="title_duration"]').value
    );

    const descAnimation = document.querySelector(
      '[name="description_animation"]'
    ).value;
    const descDelay = parseFloat(
      document.querySelector('[name="description_delay"]').value
    );
    const descDuration = parseFloat(
      document.querySelector('[name="description_duration"]').value
    );

    const imageAnimation = document.querySelector(
      '[name="image_animation"]'
    ).value;
    const imageDelay = parseFloat(
      document.querySelector('[name="image_delay"]').value
    );
    const imageDuration = parseFloat(
      document.querySelector('[name="image_duration"]').value
    );

    // Apply animations
    applyAnimation(previewTitle, titleAnimation, titleDelay, titleDuration);
    applyAnimation(previewDescription, descAnimation, descDelay, descDuration);
    applyAnimation(previewImage, imageAnimation, imageDelay, imageDuration);
  }

  // Add event listeners to animation controls
  const animationControls = document.querySelectorAll(
    [
      '[name="title_animation"]',
      '[name="title_delay"]',
      '[name="title_duration"]',
      '[name="description_animation"]',
      '[name="description_delay"]',
      '[name="description_duration"]',
      '[name="image_animation"]',
      '[name="image_delay"]',

      '[name="image_duration"]',
    ].join(",")
  );

  animationControls.forEach((control) => {
    control.addEventListener("change", previewAnimation);
  });

  // Initialize animation preview when entering Step 4
  document.getElementById("nextStep").addEventListener("click", function () {
    if (currentStep === 3) {
      // About to enter Step 4
      initializePreview();
      previewAnimation();
    }
  });

  // Reset preview when leaving Step 4
  document.getElementById("prevStep").addEventListener("click", function () {
    if (currentStep === 5) {
      // Leaving Step 4
      previewPlaceholder.classList.remove("d-none");
      previewContent.classList.add("d-none");
    }
  });
});