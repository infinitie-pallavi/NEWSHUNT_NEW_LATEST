<!DOCTYPE html>
<html>
    <title>{{ $story->title . ' | News Hunt' }}</title>

<head>
    <meta charset="utf-8">
    <link rel="icon" href="{{ $favicon ?? asset('assets/images/logo/favicon.png') }}" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <link rel="canonical" href="{{ url()->current() }}">
    <script async custom-element="amp-story" src="https://cdn.ampproject.org/v0/amp-story-1.0.js"></script>
    <script async custom-element="amp-story-auto-analytics" src="https://cdn.ampproject.org/v0/amp-story-auto-analytics-0.1.js"></script>
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style>
    <noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
</head>

<body class="amp_story" >
    @if ($story && $story->story_slides->isNotEmpty())
    <amp-story standalone title="{{ $story->title }}" publisher-logo-src="{{ asset('assets/images/logo/LightLogo.png') }}" 
        poster-portrait-src="{{ optional($story->story_slides->first())->image ? asset('storage/' . $story->story_slides->first()->image) : asset('assets/images/no_image_available.png') }}">
            @foreach ($story->story_slides as $index => $slide)
                @php
                    $animationDetails = $animations[$slide->id] ?? [];
                @endphp
                <amp-story-page id="slide-{{ $index }}" auto-advance-after="5s">
                    <amp-story-grid-layer template="fill">
                        <div class="image-container" >
                            <amp-img 
                                src="{{ asset('storage/' . $slide->image) }}"
                                width="720"
                                height="1280"
                                layout="responsive"
                                alt="{{ $story->title }} - Slide {{ $index + 1 }}"
                                animate-in="{{ $animationDetails['image']['type'] == 'slide-in' ? 'fly-in-left' : ($animationDetails['image']['type'] ?? 'fade-in') }}"
                                animate-in-delay="{{ $animationDetails['image']['delay'] ?? '0' }}s"
                                animate-in-duration="{{ $animationDetails['image']['duration'] ?? '1' }}s"
                                data-amp-story-animation="fade-in">
                            </amp-img>
                            
                            <div class="overlay" 
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0)); color: white; display: flex; justify-content: center; align-items: center;">
                            </div>
                        </div>
                    </amp-story-grid-layer>

                    <amp-story-grid-layer template="thirds">
                        @if ($index === 0)
                            <div class="amp-story-logo" style="opacity: 1">
                                <amp-img 
                                    src="{{ asset('assets/images/logo/LightLogo.png') }}"
                                    width="100"
                                    height="20"
                                    layout="intrinsic"
                                    alt="Logo"
                                    animate-in="fade-in"
                                    animate-in-delay="0.3s">
                                </amp-img>
                            </div>
                            <div grid-area="lower-third">
                                <p class="title-text"  style="font-size:30px;background:none;color:white;text-shadow: 4px 4px 12px rgb(0, 0, 0), 0 0 25px rgba(0, 0, 0, 0.6);font-weight: bold;font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;text-align: center;"
                                   animate-in="fly-in-bottom"
                                   animate-in-delay="0.5s"
                                   animate-in-duration="0.8s">
                                    {{ $story->title }}
                                </p>
                            </div>
                        @else
                        <div grid-area="middle-third" class="content" style=" position:relative; top: 60%;font-weight: bold;font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;color: rgb(255, 255, 255);text-shadow: 4px 4px 12px rgb(0, 0, 0), 0 0 25px rgba(0, 0, 0, 0.6);">
                            <p class="title-text" style="font-size:24px; text-align: center;"
                           animate-in="{{ $animationDetails['title']['type'] == 'slide-down' ? 'fly-in-top' : 'fly-in-bottom' }}"
                            animate-in-delay="{{ $animationDetails['title']['delay'] ?? '1.3' }}s"
                            animate-in-duration="{{ $animationDetails['title']['duration'] ?? '1' }}s"
                            data-amp-story-animation="true">
                             {{ $slide->title }}
                         </p>
                            
                        </div>
                            <div grid-area="middle-third" class="content" style="font-size:18px;position: relative; top: 100%;  font-weight: bold;font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;color: white;text-shadow: 4px 4px 12px rgb(0, 0, 0), 0 0 25px rgba(0, 0, 0, 0.6);">
                          
                                <p class="description-text" style="text-align: center;"
                                animate-in="{{ $animationDetails['description']['type'] == 'slide-down' ? 'fly-in-top' : 'fly-in-bottom' }}"
                                   animate-in-delay="{{ $animationDetails['description']['delay'] ?? '1.3' }}s"
                                   animate-in-duration="{{ $animationDetails['description']['duration'] ?? '1' }}s"
                                   data-amp-story-animation="true">
                                    {{ $slide->description }}
                                </p>
                            </div>
                        @endif
                    </amp-story-grid-layer>
                </amp-story-page>
            @endforeach

            @if ($nextStory && optional($nextStory->story_slides->first())->image)
                <amp-story-page id="next-story-preview">
                    <amp-story-grid-layer template="fill">
                        <amp-img 
                            src="{{ asset('storage/' . $nextStory->story_slides->first()->image) }}"
                            width="720"
                            height="1280"
                            layout="responsive"
                            alt="{{ $nextStory->title }}">
                        </amp-img>
                    </amp-story-grid-layer>
                    <amp-story-grid-layer template="thirds">
                        <div grid-area="lower-third">
                            <p class="next-story-title" 
                               animate-in="fade-in" 
                               animate-in-delay="0.5s" 
                               style="top:100%; font-size:30px;background:none;color:white;text-shadow: 4px 4px 12px rgb(0, 0, 0), 0 0 25px rgba(0, 0, 0, 0.6);font-weight: bold;font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;text-align: center;">
                                {{ $nextStory->title }}
                            </p>
                        </div>
                    </amp-story-grid-layer>
                    <amp-story-cta-layer>
                        <a href="{{ route('webstories.show', ['topic' => $nextStory->topic->slug, 'story' => $nextStory->slug]) }}"
                           class="button-link bg-red">
                            Read Now
                        </a>
                    </amp-story-cta-layer>
                </amp-story-page>
            @endif
        </amp-story>
    @else
        <div class="error-message">
            <h1>Story Not Found</h1>
            <p>Sorry, the story you are looking for does not exist or has been removed.</p>
        </div>
    @endif
</body>
</html>