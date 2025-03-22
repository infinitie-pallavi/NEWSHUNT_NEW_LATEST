@extends('front_end.'.$theme.'.layout.main')

@section('body')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<!-- Wrapper start -->
    <div id="wrapper" class="wrap overflow-hidden-x">
        <div class="breadcrumbs panel z-1 py-2 bg-gray-25 dark:bg-gray-100 dark:bg-opacity-5 dark:text-white">
            <div class="container max-w-xl">
                <ul class="breadcrumb nav-x justify-center gap-1 fs-7 sm:fs-6 m-0">
                    <li><a href="{{url('home')}}">Home</a></li>
                    <li><i class="unicon-chevron-right opacity-50"></i></li>
                    <li><span class="opacity-70">Contact Us</span></li>
                </ul>
            </div>
        </div>
        <div class="section py-3 sm:py-6 lg:py-9">
            <div class="container max-w-xl">
                <div class="panel vstack gap-1 sm:gap-6 lg:gap-9">
                    <header class="page-header panel vstack text-center">
                        <h1 class="h3 lg:h1">Contact us</h1>
                    </header>
                    <div id="contact-form-wrapper" class="panel pt-2">
                        <h4 class="h5 xl:h4 mb-3 xl:mb-3">Leave a Message</h4>
                        <div class="comment_form_holder">
                            <form action="{{ route('contact_us.store') }}" method="POST" class="vstack gap-1" id="contact-form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <input class="form-control form-control-sm" type="text" id="first_name" name="first_name" placeholder="First name" required>
                                        <span class="help-block text-danger"></span> <!-- Error message container -->
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input class="form-control form-control-sm" type="text" id="last_name" name="last_name" placeholder="Last name" required>
                                        <span class="help-block text-danger"></span> <!-- Error message container -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <input class="form-control form-control-sm" type="email" id="email" name="email" placeholder="Your email" required>
                                        <span class="help-block text-danger"></span> <!-- Error message container -->
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="iti-container">
                                            <input class="form-control form-control-sm phone-input" type="tel" id="phone" name="phone" placeholder="Enter mobile number" required>
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <textarea class="form-control h-250px w-full fs-6" id="message" name="message" placeholder="Describe your issue...!" required></textarea>
                                    <span class="help-block text-danger"></span> <!-- Error message container -->
                                </div>
                                <button class="btn btn-primary btn-sm" type="submit">Send</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script defer src="{{asset('front_end/'.$theme.'/js/custom/contact-us.js')}}"></script>
@endsection
