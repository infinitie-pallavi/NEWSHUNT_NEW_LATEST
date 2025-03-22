@extends('front_end.'.$theme.'.layout.main')

@section('body')
<div class="share-div"></div>
<!-- Wrapper start -->
    <div id="wrapper" class="wrap overflow-hidden-x">
        <div class="breadcrumbs panel z-1 py-2 bg-gray-25 dark:bg-gray-100 dark:bg-opacity-5 dark:text-white">
            <div class="container max-w-xl">
                <ul class="breadcrumb nav-x justify-center gap-1 fs-7 sm:fs-6 m-0">
                    <li><a href="{{url('home')}}" title="Home">Home</a></li>
                    <li><i class="unicon-chevron-right opacity-50"></i></li>
                    <li><a href="{{url('topics/'.$post->topic_slug)}}" title="{{$post->topic_name ?? ''}}">{{$post->topic_name ?? ''}}</a></li>
                    <li><i class="unicon-chevron-right opacity-50"></i></li>
                    <li><span class="opacity-50" title="{{ $post_label->value ?? ''}}">{{ $post_label->value ?? ''}}</span></li>
                </ul>
            </div>
        </div>

        <article class="post type-post single-post py-4 lg:py-6 xl:py-9">
            <div class="container max-w-xl">
                <div class="post-header">
                    <div class="panel vstack gap-4 md:gap-6 xl:gap-5 text-center">
                        <div class="panel vstack items-center mx-auto gap-2 md:gap-3">
                            <h1 class="h4 sm:h2 lg:h1 xl:display-6">{{$post->title ?? ''}}</h1>
                            <h4 class="row gap-1">
                                <div>
                                    <a href="{{url('channels/'.$post->channel_slug)}}" style="text-decoration: none;">
                                        <img src="{{ $post->channel_logo }}" alt="{{url('channels/'.$post->channel_slug)}}" class="h-20px">
                                    </a>
                                    <a href="{{url('channels/'.$post->channel_slug)}}" class="text-none"> {{ $post->channel_name ?? ''}}</a>
                                </div>
                                <div>{{$post->publish_date}}</div>
                            </h4>

                            <ul class="post-share-icons nav-x gap-1 dark:text-white">
                                <li>
                                    <a class="btn btn-md p-0 border-gray-900 border-opacity-15 w-32px lg:w-48px h-32px lg:h-48px text-dark dark:text-white dark:border-white hover:bg-primary hover:border-primary hover:text-white rounded-circle" href="{{'https://www.facebook.com/sharer/sharer.php?u=' . url()->current()}}"><i class="unicon-logo-facebook icon-1"></i></a>
                                </li>
                                <li>
                                    <a class="btn btn-md p-0 border-gray-900 border-opacity-15 w-32px lg:w-48px h-32px lg:h-48px text-dark dark:text-white dark:border-white hover:bg-primary hover:border-primary hover:text-white rounded-circle" href="{{'https://twitter.com/intent/tweet?url=' . url()->current()}}"><i class="unicon-logo-x-filled icon-1"></i></a>
                                </li>
                                <li>
                                    <a class="btn btn-md p-0 border-gray-900 border-opacity-15 w-32px lg:w-48px h-32px lg:h-48px text-dark dark:text-white dark:border-white hover:bg-primary hover:border-primary hover:text-white rounded-circle" href="{{'https://www.linkedin.com/shareArticle?mini=true&url=' . url()->current()}}"><i class="unicon-logo-linkedin icon-1"></i></a>
                                </li>
                                <li>
                                    <a id="copyButton" class="btn btn-md p-0 border-gray-900 border-opacity-15 w-32px lg:w-48px h-32px lg:h-48px text-dark dark:text-white dark:border-white hover:bg-primary hover:border-primary hover:text-white rounded-circle" href="#">
                                        <i class="unicon-link icon-1"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        @if($post->type != 'video')
                            <figure class="featured-image m-0">
                                <figure class="featured-image m-0 ratio ratio-2x1 rounded uc-transition-toggle overflow-hidden bg-gray-25 dark:bg-gray-800">
                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{$post->image ?? ''}}" data-src="{{$post->image ?? ''}}" alt="Not Found" data-uc-img="loading: lazy">
                                </figure>
                            </figure>
                        @else
                        <div class="featured-image m-0">
                            <div class="featured-image m-0 ratio ratio-2x1 rounded uc-transition-toggle overflow-hidden dark:bg-black light:bg-white">
                                <div class="featured-video bg-gray-700">
                                    <!-- Video Element -->
                                    <video id="video-preview" class="media-cover video" controls preload="metadata" loop playsinline webkit-playsinline muted poster="{{$post->video_thumb}}">
                                        <source src="{{$post->video}}" type="video/mp4">
                                        
                                        <source src="{{$post->video}}" type="video/webm">
                                        <track src="descriptions_en.vtt" kind="descriptions" srclang="en" label="English Descriptions">
                                    </video>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div>
                        </div>
                        <div class="row">
                            <div class="d-flex justify-start gap-1">
                                <div>
                                        <a id="open_reactores" class="text-none">
                                            @foreach($getTopReactions as $getTopReaction)
                                                <b class="position-relative text-primary" id="emoji_loop_{{$getTopReaction->count}}" style="margin-left: -12px;">
                                                    <span class="fs-3 text-primary">{{$getTopReaction->uuid}}</span>
                                                </b>
                                            @endforeach
                                            @if($emoji && !$getTopReactions->contains('uuid', $emoji))
                                            <b class="position-relative text-primary" id="match_reaction_icons" style="margin-left: -12px;">
                                                <span class="fs-3 text-primary">{{$emoji}}</span>
                                            </b>
                                            @else
                                            <b class="position-relative text-primary d-none" id="match_reaction_icons" style="margin-left: -12px;">
                                                <span class="fs-3 text-primary"></span>
                                            </b>
                                            @endif
                                        </a>
                                    </div>
                                    <div>
                                    @if($emoji !== "")
                                    @if($post->reaction == 1)
                                        <b id="emoji_count">You</b>
                                    @else
                                        <b id="emoji_count">You + {{$post->reaction -1}}</b>
                                    @endif
                                    @else
                                        <b id="emoji_count"> {{$post->reaction == 0 ? "" : $post->reaction}}</b>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex justify-between gap-1">
                                <div class="d-flex gap-1">
                                    <h4><i class="bi bi-eye-fill"></i> {{ $post->view_count ?? ''}}
                                    </h4>
                                    <h4><i class="bi bi-bookmarks-fill"></i><span id="favorite_counts">{{ $post->favorite ?? ''}}</span>
                                    </h4>
                                
{{-- This part is for reactions --}}
                                    <h4 style="cursor: pointer;">

                                        @if($emoji)
                                        <a id="reaction_open" class="text-none">
                                            <b class="fs-2 position-relative text-primary" id="reaction_icons"><span class="reaction-uuid">{{$emoji}}</span></b>
                                        </a>
                                        @else
                                        <a id="reaction_open" class="text-none">
                                            <b class="bi bi-hand-thumbs-up-fill fs-2 position-relative" id="reaction_icons"></b>
                                        </a>
                                        @endif

                                         <div id="emoji-box" class="emoji-box mt-1 dark:bg-gray-100 dark:bg-opacity-5 text-primary gap-1 d-none">
                                            @if(auth()->check())
                                            @foreach($reactions as $reaction)
                                                <span onclick="reactToPost({{$post->id}},'{{$reaction->name}}','{{$reaction->uuid}}','{{$getTopReactions}}')" class="emoji">{{$reaction->uuid}}</span>
                                            @endforeach
                                            @else
                                            @foreach($reactions as $reaction)
                                                <a href="#uc-account-modal"  data-uc-toggle class="text-none">
                                                    <span>{{$reaction->uuid}}</span>
                                                </a>
                                            @endforeach
                                            @endif
                                        </div>
                                        <div id="emoji_collaction" class="emoji-box col-auto mt-1 p-0 d-none">
                                            <div class="card">
                                                <div class="card-header dark:bg-black">
                                                    <ul id="emojiTabs" class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
                                                        <!-- Tabs will be rendered here dynamically -->
                                                    </ul>
                                                </div>
                                                <div class="card-body dark:bg-black">
                                                    <div id="emojiContent" class="tab-content">
                                                        <!-- Content will be rendered here dynamically -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </h4>
{{-- End of reactions --}}
                                </div>
                                <div class="gap-1">
                                    @if(auth()->check())
                                        @if($post->is_bookmark == 1)
                                            <a href="" id="bookmark-post" class="hover:text-primary">
                                                <i class="bi bi-bookmarks-fill fs-2"></i>
                                            </a>
                                        @else
                                            <a href="" id="bookmark-post" class="hover:text-primary">
                                               <i class="bi bi-bookmarks fs-2"></i>
                                            </a>
                                        @endif
                                    @else
                                    <a href="#uc-account-modal"  data-uc-toggle class="hover:text-primary">
                                        <i class="bi bi-bookmarks fs-2"></i>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="panel text-black dark:text-white mt-4 lg:mt-6 xl:mt-9">
                <div class="container max-w-lg">
                    <div class="post-content panel fs-6 md:fs-5" data-uc-lightbox="animation: scale">
                        {!! $post->description ?? 'No Description Avaliable.'!!}
                    </div>
                    <div class="mt-5">
                        <span>Click here to <a href="{{ $post->resource ?? ''}}" class="text-none hover:text-primary" target="_blank">Read more <i class="bi bi-box-arrow-up-right"></i></a></span>
                    </div>
                    <div class="post-footer panel vstack sm:hstack gap-3 justify-between justifybetween border-top py-4 mt-4 xl:py-9 xl:mt-0">
                        <ul class="nav-x gap-narrow">
                            <li><span class="text-black dark:text-white me-narrow">Releted topics:</span></li>
                            @if(!empty($topics))
                                @foreach ($topics as $index => $topic)
                                    <li>
                                        <a href="{{url('topics/'.$topic->slug)}}" class="uc-link gap-0 dark:text-white hover:text-primary">
                                            {{$topic->name}}
                                            @if($index < count($topics) - 1)
                                                <span class="text-black dark:text-white">,</span>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    
                        <ul class="post-share-icons nav-x gap-narrow mr-auto">
                            <li class="me-1"><span class="text-black dark:text-white">Share:</span></li>
                            <li>
                                <a class="btn btn-md btn-outline-gray-100 p-0 w-32px lg:w-40px h-32px lg:h-40px text-dark dark:text-white dark:border-gray-600 hover:bg-primary hover:border-primary hover:text-white rounded-circle"
                                    href="{{'https://www.facebook.com/sharer/sharer.php?u=' . url()->current()}}"><i class="unicon-logo-facebook icon-1"></i></a>
                            </li>
                            <li>
                                <a class="btn btn-md btn-outline-gray-100 p-0 w-32px lg:w-40px h-32px lg:h-40px text-dark dark:text-white dark:border-gray-600 hover:bg-primary hover:border-primary hover:text-white rounded-circle"
                                    href="{{'https://twitter.com/intent/tweet?url=' . url()->current()}}"><i class="unicon-logo-x-filled icon-1"></i></a>
                            </li>
                            <li>
                                <a id="copyButton_1" class="btn btn-md btn-outline-gray-100 p-0 w-32px lg:w-40px h-32px lg:h-40px text-dark dark:text-white dark:border-gray-600 hover:bg-primary hover:border-primary hover:text-white rounded-circle"
                                href="#"><i class="unicon-link icon-1"></i></a>
                            </li>
                        </ul>
                    </div>

                    <div class="post-navigation panel vstack sm:hstack justify-between gap-2 mt-8 xl:mt-9">
                        <div class="new-post panel hstack w-100 sm:w-1/2">
                            @if(!empty($previousPost))
                                <div class="panel hstack justify-center w-100px h-100px">
                                    <figure class="featured-image m-0 ratio ratio-1x1 rounded uc-transition-toggle overflow-hidden bg-gray-25 dark:bg-gray-800">
                                        
                                        @if($previousPost->type !="video")
                                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{$previousPost->image}}" data-src="{{$previousPost->image}}" alt="{{$previousPost->title}}" data-uc-img="loading: lazy">
                                            @else
                                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="front_end/classic/images/common/img-fallback.png" data-src="{{ $previousPost->video_thumb }}" alt="{{ $previousPost->title }}" data-uc-img="loading: lazy">
                                                <div class="post-category hstack gap-narrow justify-center align-items-center text-white">
                                                    <a class="text-none" href="{{url('posts/'.$previousPost->slug)}}" title="{{ $previousPost->title }}"><i class="bi bi-play-circle font-size-45"></i></a>
                                                </div>
                                            @endif
                                        <a href="{{url('posts/'.$previousPost->slug)}}" class="position-cover" data-caption="{{$previousPost->title}}"></a>
                                    </figure>
                                </div>
                                <div class="panel vstack justify-center px-2 gap-1 w-1/3">
                                    <span class="fs-7 opacity-900">Prev Article</span>
                                    <h6 class="h6 lg:h5 m-0">{{$previousPost->title}}</h6>
                                </div>
                                <a href="{{url('posts/'.$previousPost->slug)}}" class="position-cover"></a>
                            @endif
                        </div>
                        <div class="new-post panel hstack w-100 sm:w-1/2">
                            @if($nextPost)
                                <div class="panel vstack justify-center px-2 gap-1 w-1/3 text-end">
                                    <span class="fs-7 opacity-900">Next Article</span>
                                    <h6 class="h6 lg:h5 m-0">{{$nextPost->title}}</h6>
                                </div>
                                <div class="panel hstack justify-center w-100px h-100px">
                                    <figure class="featured-image m-0 ratio ratio-1x1 rounded uc-transition-toggle overflow-hidden bg-gray-25 dark:bg-gray-800">
                                        <a href="{{url('posts/'.$nextPost->slug)}}" class="position-cover" data-caption="{{$nextPost->title}}">
                                            @if($nextPost->type !="video")
                                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{$nextPost->image}}" data-src="{{$nextPost->image}}" alt="{{$nextPost->title}}" data-uc-img="loading: lazy">
                                            @else
                                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="front_end/classic/images/common/img-fallback.png" data-src="{{ $nextPost->video_thumb }}" alt="{{ $nextPost->title }}" data-uc-img="loading: lazy">
                                                <div class="post-category hstack gap-narrow justify-center align-items-center text-white">
                                                    <a class="text-none" href="{{url('posts/'.$nextPost->slug)}}" title="{{ $nextPost->title }}"><i class="bi bi-play-circle font-size-45"></i></a>
                                                </div>
                                            @endif
                                        </a>
                                    </figure>
                                </div>
                                <a href="{{url('posts/'.$nextPost->slug)}}" class="position-cover"></a>
                            @endif
                        </div>
                    </div>
                    
                    <div class="post-related panel border-top pt-2 mt-8 xl:mt-9">
                        <h4 class="h5 xl:h4 mb-5 xl:mb-6">Related {{$post->topic_name}} Updates:</h4>
                        <div class="row child-cols-6 md:child-cols-3 gx-2 gy-4 sm:gx-3 sm:gy-6">
                            @foreach ($relatedPosts as $reletedPost)
                            <div>
                                <article class="post type-post panel vstack gap-2">
                                    <figure class="featured-image m-0 ratio ratio-4x3 rounded uc-transition-toggle overflow-hidden bg-gray-25 dark:bg-gray-800">
                                        <a href="{{url('posts/'.$reletedPost->slug)}}" class="position-cover" data-caption="The Art of Baking: From Classic Bread to Artisan Pastries">
                                        @if($reletedPost->type != "video")
                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{$reletedPost->image}}" data-src="{{$reletedPost->image}}" alt="The Art of Baking: From Classic Bread to Artisan Pastries" data-uc-img="loading: lazy">
                                        @else
                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{$reletedPost->video_thumb}}" data-src="{{$reletedPost->video_thumb}}" alt="The Art of Baking: From Classic Bread to Artisan Pastries" data-uc-img="loading: lazy">
                                                <div class="post-category hstack gap-narrow justify-center align-items-center text-white">
                                                    <a class="text-none" href="{{url('posts/'.$reletedPost->slug)}}" title="{{ $reletedPost->title }}"><i class="bi bi-play-circle font-size-45"></i></a>
                                                </div>
                                            @endif
                                        </a>
                                    </figure>
                                    <div class="post-header panel vstack gap-1">
                                        <h5 class="h6 md:h5 text-truncate-2 m-0 hover:text-primary">
                                            <a class="text-none" href="{{url('posts/'.$reletedPost->slug)}}">{{$reletedPost->title}}</a>
                                        </h5>
                                    </div>
                                    <div>
                                        <div class="post-meta panel fs-7 fw-medium text-gray-900 dark:text-white text-opacity-60">
                                            <div class="meta">
                                                <div class="d-flex justify-between gap-2">
                                                    <div>
                                                        <div class="d-flex gap-1">
                                                            <a href="{{ url('channels/' . $reletedPost->channel_slug) }}" title="{{ $reletedPost->channel_name }}"><img src="{{ url('storage/images/' . $reletedPost->channel_logo) }}" alt="Channel Logo" class="h-20px"></a>
                                                            <a href="{{ url('channels/' . $reletedPost->channel_slug) }}" class="text-black dark:text-white text-none fw-bold" title="{{ $reletedPost->channel_name }}">{{ $reletedPost->channel_name }}</a>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <div class="post-comments text-none hstack gap-narrow gap-1">
                                                     <a href="{{ url('posts/' . $reletedPost->slug) }}#comment-form"
                                                            class="post-comments text-none hstack gap-narrow" title="Comments">
                                                            <i class="icon-narrow unicon-chat"></i>
                                                            <span>{{ $reletedPost->comment }}</span>
                                                        </a>
                                                            <i class="bi bi-eye fs-5" title="Views"></i>
                                                            <span title="Views">{{ $reletedPost->view_count }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="post-date hstack gap-narrow mt-1">
                                                        <span title="{{$reletedPost->publish_date}}">{{ $reletedPost->publish_date ?? '' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="actions">
                                                <div class="hstack gap-1"></div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <input type="hidden" id="post_id" value="{{$post->id}}">
                    <input type="hidden" id="user_id" value="{{auth()->user()->id ?? '0'}}">
                    <input type="hidden" id="sendDataUrl" value="{{route('comments.store')}}">
                    <input type="hidden" id="updateDataUrl" value="{{route('comments.update')}}">
                    <input type="hidden" id="reportDataUrl" value="{{url('api/v1/commets/report')}}">
                    
                    <div id="blog-comment" class="panel border-top pt-2 mt-8 xl:mt-9">
                        <h4 class="h5 xl:h4 mb-5 xl:mb-6" >Comments (0)</h4>
                       <div class="card border-0">
                            <div class="card-body p-0 dark:bg-black">
                                <div class="scrollabl max-height-500">
                                    <ol id="comments-list" class="list-group"></ol>
                                </div>
                            </div>
                        </div>
                        <div id="comment-form-wrapper" class="panel pt-2 mt-8 xl:mt-9">
                            <h4 class="h5 xl:h4 mb-5 xl:mb-6">Leave a Comment</h4>
                            <div class="comment_form_holder">
                                <form id="comment-form" onsubmit="submitComment(event)">
                                    <textarea class="form-control h-150px w-full fs-6" name="comment" id="comment" title="Add your comment" placeholder="Your comment" required></textarea>
                                    @if (auth()->check())
                                    <button class="btn btn-primary btn-sm mt-3 mb-3" type="submit">Send</button>
                                    @else
                                    <a class="btn btn-primary btn-sm mt-3 mb-3" href="#uc-account-modal" data-uc-toggle>Send</a>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        <!-- Newsletter -->
        <input type="hidden" id="user_id" value="{{auth()->user()->id ?? ''}}">
    </div>
    <div class="share-div"></div>
    <!-- Wrapper end -->
@endsection
@section('script')
<script defer src="{{asset('front_end/'.$theme.'/js/custom/post-detail.js')}}"></script>
@endsection
