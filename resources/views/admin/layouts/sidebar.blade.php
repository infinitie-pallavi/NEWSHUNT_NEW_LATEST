<aside class="navbar navbar-vertical navbar-expand-lg sidebar-overflow" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <span class="navbar-brand navbar-brand-autodark">
            <a href="{{ url('/admin/dashboard') }}">
               <img src="{{ !empty($company_logo) ? $company_logo : url('assets/images/logo/sidebarlogo.png') }}" alt="{{ config('app.name') }}" class="navbar-brand-image">
            </a>
        </span>
        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                @foreach (config('adminNav') as $value)
                    @if (!isset($value['children']) || count($value['children']) == 0)
                        <li class="nav-item {{ url()->current() == route($value['route']) ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route($value['route']) }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    {!! $value['svg'] !!}
                                </span>
                                <span class="nav-link-title">
                                    {{ __($value['name']) }}
                                </span>
                            </a>
                        </li>
                    @else
                        @php
                            $isActive = false;
                            foreach ($value['children'] as $child) {
                                if (url()->current() == route($child['route'])) {
                                    $isActive = true;
                                    break;
                                }
                            }
                        @endphp
                        <li class="nav-item dropdown {{ $isActive ? 'active' : '' }}">
                            <a href="#navbar-layout" class="nav-link dropdown-toggle"  data-bs-toggle="dropdown" data-bs-auto-close="false" aria-expanded="true">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    {!! $value['svg'] !!}
                                </span>
                                <span class="nav-link-title">
                                    {{__($value['name']) }}
                                </span>
                            </a>
                            <div class="dropdown-menu {{ $isActive ? 'show' : '' }}">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        @foreach ($value['children'] as $child)
                                            <a class="dropdown-item {{ url()->current() == route($child['route']) ? 'active' : '' }}"
                                                href="{{ route($child['route']) }}">
                                                {{__($child['name']) }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</aside>
