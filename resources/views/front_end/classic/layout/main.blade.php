<!DOCTYPE html>
<html lang="zxx" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? '' }} | {{$webTitle->value ?? ''}}</title>
    <link rel="icon" href="{{ $favicon ?? asset('assets/images/logo/favicon.png') }}" type="image/x-icon" />
    <meta name="description" content="A clean, modern News providing website.">
    <meta name="keywords" content="news, website design, digital product, marketing, agency">
    <link rel="canonical" href="https://news-app.keshwaniexim.com">
    <meta name="theme-color" content="#2757fd">

    <!-- Open Graph Tags -->
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $post_title ?? 'Stay Informed: Your Daily Source for Breaking News and In-Depth Analysis' }}">
    <meta property="og:description" content="{{$description ?? 'Explore the latest news and insights from around the world. Our dedicated team provides timely updates, investigative journalism, and diverse perspectives to keep you informed and engaged every day.'}}">
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="og:site_name" content="{{$webTitle->value ?? ''}}">
    <meta property="og:image" content="{{$image ?? ''}}">
    <meta property="og:image:width" content="1180">
    <meta property="og:image:height" content="600">
    <meta property="og:image:type" content="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{url('')}}">
    <meta name="twitter:title" content="{{$post_title ?? 'Stay Informed: Your Daily Source for Breaking News and In-Depth Analysis'}}">
    <meta name="twitter:description" content="{{$description ?? 'Explore the latest news and insights from around the world. Our dedicated team provides timely updates, investigative journalism, and diverse perspectives to keep you informed and engaged every day.'}}">
    <meta name="twitter:image" content="{{isset($dark_logo) ? url('storage/'.$dark_logo->value) : ""}}">
    
    <link rel="canonical" href="https://news-app.keshwaniexim.com">

    @include('front_end.'.$theme.'.layout.style')
    @yield('style')
</head>

<body class="uni-body panel bg-white text-gray-900 dark:bg-black dark:text-white text-opacity-50 overflow-x-hidden">
    @include('front_end.'.$theme.'.layout.header')
    
    <div id="android-scheme" class="d-none">
      {{$app_scheme->value ?? ''}}
    </div>
    <div id="ios-scheme" class="d-none">
      {{$ios_shceme->value ?? ''}}
    </div>
    <div id="android-link" class="d-none">
      {{$app_store_link->value ?? ''}}
    </div>
    <div id="ios-link" class="d-none">
      {{$play_store_link->value ?? ''}}
    </div>

    @yield('body')

    @include('front_end.'.$theme.'.layout.footer')

    @include('front_end.'.$theme.'.layout.script')

    @yield('script')
    
</body>
