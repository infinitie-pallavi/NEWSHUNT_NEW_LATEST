<footer id="uc-footer" class="uc-footer panel uc-dark">
    <div class="footer-outer py-4 lg:py-6 bg-white dark:bg-gray-900 text-gray-900 dark:text-white text-opacity-50">
        <div class="container max-w-xl">
            <div class="footer-inner vstack gap-6 xl:gap-8">
                <div class="uc-footer-bottom panel vstack gap-4 justify-center lg:fs-5">
                    <div class="footer-social hstack justify-center gap-2 lg:gap-3">
                        <ul class="nav-x gap-2">
                            <li>
                                <a class="hover:text-gray-900 dark:hover:text-white duration-150" href="{{$socialMedia[28]['value'] ?? ''}}">
                                    <i class="icon icon-2 unicon-logo-linkedin"></i>
                                </a>
                            </li>
                            <li>
                                <a class="hover:text-gray-900 dark:hover:text-white duration-150" href="{{$socialMedia[27]['value'] ?? ''}}">
                                    <i class="icon icon-2 unicon-logo-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a class="hover:text-gray-900 dark:hover:text-white duration-150" href="{{$socialMedia[26]['value'] ?? ''}}">
                                    <i class="icon icon-2 unicon-logo-x-filled"></i>
                                </a>
                            </li>
                            <li>
                                <a class="hover:text-gray-900 dark:hover:text-white duration-150" href="{{$socialMedia[25]['value'] ?? ''}}">
                                    <i class="icon icon-2 unicon-logo-instagram"></i>
                                </a>
                            </li>
                            <li>
                                <a class="hover:text-gray-900 dark:hover:text-white duration-150" href="{{$socialMedia[29]['value'] ?? ''}}">
                                    <i class="icon icon-2 unicon-logo-youtube"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex justify-end gap-2 d-none">
                     <img src="{{asset('front_end/classic/images/common/playstore-large.svg')}}" class="h-100 w-96px" alt="Download on Android">
                     <img src="{{asset('front_end/classic/images/common/appstore-large.svg')}}" class="h-100 w-96px" alt="Download on apple">
                    </div>
                    <div class="footer-copyright vstack sm:hstack justify-center items-center gap-1 lg:gap-2">
                        <p>Infiniti Technologies ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                            , All rights reserved.</p>
                        <ul class="nav-x gap-2 fw-medium">
                            <li><a class="uc-link text-underline hover:text-gray-900 dark:hover:text-white duration-150" href="{{url('/privacy-policies')}}">Privacy Policies</a></li>
                            <li><a class="uc-link text-underline hover:text-gray-900 dark:hover:text-white duration-150" href="{{url('/terms-and-condition')}}">Terms and condition</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(isset($footer_script))
        {!! $footer_script->value !!}
    @endif
</footer>
