<?php

/*
    Points to Note:
    1.  No need to put svg in any children.
    2.  Any nav that does not have Ability key will be available for all users.
    3.  if any child does not have any ability key then that child and its parent will be available for all roles.
    4.  if you want to explicitly give ability to parent for all the roles then put ability in parent as ["*"].
    5.  Name is a label that will be translated in view.
    6.  All the routes in the nav should be named.
    7.  Add ability to
        - Main category only when it has no child and has route in it.
        - if child has route the add ability to the child not to the parent.
    8.  If no svg is given then default svg is Home svg.
    9.  Refer /config/rolepermission.php for all the available abilities.
*/

$nav = [
    [
        "name" => "DASHBOARD",
        "route" => 'dashboard',
        "svg" => "home"
    ],
    [
        "name" => "POSTS",
        "route" => 'posts.index',
        "svg" => "post"
    ],

    [
        "name" => "STORIES",
        "route" => "stories.publicIndex",
        "svg" => "web_story"  
    ],

    [
        "name" => "CHANNELS",
        "route" => 'channels.index',
        "ability" => ['channel-list', 'customer-create', 'customer-update', 'customer-delete'],
        "svg" => "channels"
    ],
    [
        "name" => "TOPICS",
        "route" => 'topics.index',
        "svg" => "topic"
    ],

    [
        "name" => "RSS_FEEDS",
        "route" => 'rss-feeds.index',
        "svg" => "rss-feed"
    ],
    [
        "name" => "USERS",
        "route" => 'users.index',
        "ability" => ['customer-list', 'customer-create', 'customer-update', 'customer-delete'],
        "svg" => "customer"
    ],
    [
        "name" => "SUBSCRIBERS",
        "route" => 'subscriber.index',
        "svg" => "subscriber"
    ],

    [
        "name" => "NOTIFICATION",
        "route" => 'notification.index',
        "svg" => "notification"
    ],
    [
        "name" => "REPORTED_COMMENTS",
        "route" => 'report-comments.index',
        "svg" => "comment-spam"
    ],
    [
        "name" => "CONTACT_US",
        "route" => 'contact-us.index',
        "svg" => "contact-us"
    ],

    /*   [
        "name" => "COUNTRIES",
        "route" =>'countries.index',
        "svg" => "countries"
    ], */
    [
        "name" => "ADMIN_USERS",
        "svg" => "admin",
        "children" => [
            [
                "name" => "ROLES",
                "route" => "roles.index",
                "ability" => ['role-list', 'role-create', 'role-update', 'role-delete',],
            ],
            [
                "name" => "ADMINS",
                "route" => "admin-users.index",
                "ability" => ['adminuser-list', 'adminuser-create', 'adminuser-update', 'adminuser-delete'],
            ]
        ]
    ],
    [
        "name" => "SETTINGS",
        "route" => "settings.index",
        "svg" => 'settings'
    ],
];

$svgs = [

    "home" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-home">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
              <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
              <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
            </svg>',

    "countries" => '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-world">
                 <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                 <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                 <path d="M3.6 9h16.8" />
                 <path d="M3.6 15h16.8" />
                 <path d="M11.5 3a17 17 0 0 0 0 18" />
                 <path d="M12.5 3a17 17 0 0 1 0 18" />
                 </svg>',

    "admin" => '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user-cog">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                <path d="M6 21v-2a4 4 0 0 1 4 -4h2.5" />
                <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                <path d="M19.001 15.5v1.5" />
                <path d="M19.001 21v1.5" />
                <path d="M22.032 17.25l-1.299 .75" />
                <path d="M17.27 20l-1.3 .75" />
                <path d="M15.97 17.25l1.3 .75" />
                <path d="M20.733 20l1.3 .75" />
                </svg>',

    "customer" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                </svg>',

    "settings" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-settings">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                  <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                </svg>',

    "channels" => '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-brand-youtube">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M2 8a4 4 0 0 1 4 -4h12a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-12a4 4 0 0 1 -4 -4v-8z" />
                <path d="M10 9l5 3l-5 3z" />
                </svg>',

    "rss-feed" => '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-brand-facebook">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                </svg>',

    "post"    =>  '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-article">
               <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
               <path d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
               <path d="M7 8h10" />
               <path d="M7 12h10" />
               <path d="M7 16h10" />
               </svg>',

    "comment" =>  '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-message-plus">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M8 9h8" />
              <path d="M8 13h6" />
              <path d="M12.01 18.594l-4.01 2.406v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v5.5" />
              <path d="M16 19h6" />
              <path d="M19 16v6" />
              </svg>',

    "comment-spam" =>  '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-message-report">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" />
                <path d="M12 8v3" />
                <path d="M12 14v.01" />
                </svg>',

    "notification" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-bell">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                </svg>',

    'topic'  => '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-circle-letter-t">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                <path d="M10 8h4" />
                <path d="M12 8v8" />
                </svg>',

    'contact-us' => '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-headphones">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M4 13m0 2a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2 -2z" />
                <path d="M15 13m0 2a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2 -2z" />
                <path d="M4 15v-3a8 8 0 0 1 16 0v3" />
                </svg>',

    'subscriber' => '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                <path d="M3 7l9 6l9 -6" />
                </svg>',

    'web_story' => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M15 6H9C8.44772 6 8 6.44772 8 7V17C8 17.5523 8.44772 18 9 18H15C15.5523 18 16 17.5523 16 17V7C16 6.44772 15.5523 6 15 6ZM9 4C7.34315 4 6 5.34315 6 7V17C6 18.6569 7.34315 20 9 20H15C16.6569 20 18 18.6569 18 17V7C18 5.34315 16.6569 4 15 4H9Z" fill="#929090"></path> <path d="M2 6C2 5.44772 2.44772 5 3 5C3.55228 5 4 5.44772 4 6V18C4 18.5523 3.55228 19 3 19C2.44772 19 2 18.5523 2 18V6Z" fill="#929090"></path> <path d="M20 6C20 5.44772 20.4477 5 21 5C21.5523 5 22 5.44772 22 6V18C22 18.5523 21.5523 19 21 19C20.4477 19 20 18.5523 20 18V6Z" fill="#929090"></path> </g></svg>'

];

function mergeChildAbilities($navs, $svgs)
{
    foreach ($navs as &$nav) {
        if (isset($nav['svg']) && array_key_exists($nav['svg'], $svgs)) {
            $nav['svg'] = $svgs[$nav['svg']];
        } else {
            $nav['svg'] = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-home">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
              <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
              <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
            </svg>';
        }

        if (!isset($nav["ability"]) && !isset($nav["children"])) {
            $nav["ability"] = ["*"];
        }

        if (isset($nav['children'])) {
            $parentAbility = $nav['ability'] ?? [];

            foreach ($nav['children'] as $child) {
                $childAbility = $child['ability'] ?? ["*"];
                $parentAbility = array_merge($parentAbility, $childAbility);
            }

            $nav['ability'] = array_unique($parentAbility);
            $nav['children'] = mergeChildAbilities($nav['children'], $svgs);
        }
    }
    return $navs;
}
return mergeChildAbilities($nav, $svgs);