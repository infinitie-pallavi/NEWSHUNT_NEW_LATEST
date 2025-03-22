<div class="modal modal-blur fade" id="contact-us-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('CONTACT_US_DETAILS')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- First Name -->
                <div class="mb-3 d-flex">
                    <label for="" class="form-label">{{__('NAME')}} : &nbsp;&nbsp;</label>
                    <label for="" class="form-label ml-1" id="contact-name">Not found</label>
                   
                </div>

                <!-- Email -->
                <div class="mb-3 d-flex">
                    <label for="" class="form-label">{{__('EMAIL')}} : &nbsp;&nbsp;</label>
                    <label for="" class="form-label ml-1" id="contact-email">not found</label>
                   
                </div>
               
                <!-- Mobile -->
                <div class="mb-3 d-flex">
                    <label for="" class="form-label">{{__('MOBILE')}} : &nbsp;&nbsp;</label>
                    <label for="" class="form-label ml-1" id="contact-mobile">not found</label>
                </div>
                <!-- Message -->
                <div class="mb-3 d-flex">
                    <label for="" class="form-label">{{__('MESSAGE')}} : &nbsp;&nbsp;</label>
                    <label for="" class="form-label ml-1" id="contact-message">not found</label>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary btn-sm" data-bs-dismiss="modal">{{__('CLOSE')}}</a>
            </div>
        </div>
    </div>
</div>
