<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Social Networks
    |--------------------------------------------------------------------------
    |
    | This array social networks.
    |
    */
    'social_networks' => [
      'facebook',
      'instagram',
      'tiktok',
      'linkedin',
      'youtube',
      'vimeo',
      'twitter',
      'twitch',
      'tumblr',
      'pinterest',
      'whatsapp'
    ],
    /*
    |--------------------------------------------------------------------------
    | Facebook URL
    |--------------------------------------------------------------------------
    |
    | This URL resources is used by social network.
    |
    */
    'facebook' => [
      'show' => env('SOCIAL_NETWORK_FACEBOOK', true),

      'url' => env('SOCIAL_NETWORK_URL', 'https://facebook.com'),
    ],
    /*
    |--------------------------------------------------------------------------
    | Youtube URL
    |--------------------------------------------------------------------------
    |
    | This URL resources is used by social network.
    |
    */
    'youtube' => [
      'show' => env('SOCIAL_NETWORK_YOUTUBE', true),

      'url' => env('SOCIAL_NETWORK_URL', 'https://youtube.com/@fisicalcoach'),
    ],
    /*
    |--------------------------------------------------------------------------
    | Pinterest URL
    |--------------------------------------------------------------------------
    |
    | This URL resources is used by social network.
    |
    */
    'pinterest' => [
      'show' => env('SOCIAL_NETWORK_PINTEREST', false),

      'url' => env('SOCIAL_NETWORK_URL', 'https://pin.it/7w5WknD'),
    ],
    /*
    |--------------------------------------------------------------------------
    | Instagram URL
    |--------------------------------------------------------------------------
    |
    | This URL resources is used by social network.
    |
    */
    'instagram' => [
      'show' => env('SOCIAL_NETWORK_INSTAGRAM', true),

      'url' => env('SOCIAL_NETWORK_URL', 'https://instagram.com/fisicalcoach?igshid=YmMyMTA2M2Y='),
    ],
    /*
    |--------------------------------------------------------------------------
    | Twitter URL
    |--------------------------------------------------------------------------
    |
    | This URL resources is used by social network.
    |
    */
    'twitter' => [
      'show' => env('SOCIAL_NETWORK_TWITTER', true),

      'url' => env('SOCIAL_NETWORK_URL', 'https://twitter.com/fisicalcoach?s=11&t=JoVXSHxtKM5OAg5TmC8KAw'),
    ],
    /*
    |--------------------------------------------------------------------------
    | Whatsapp URL
    |--------------------------------------------------------------------------
    |
    | This URL resources is used by social network.
    |
    */
    'whatsapp' => [
      'show' => env('SOCIAL_NETWORK_WHATSAPP', false),

      'url' => env('SOCIAL_NETWORK_URL', 'https://whatsapp.com'),
    ],
    /*
    |--------------------------------------------------------------------------
    | Tiktok URL
    |--------------------------------------------------------------------------
    |
    | This URL resources is used by social network.
    |
    */
    'tiktok' => [
      'show' => env('SOCIAL_NETWORK_TIKTOK', true),

      'url' => env('SOCIAL_NETWORK_URL', 'https://www.tiktok.com/@fisicalcoach'),
    ],
    /*
    |--------------------------------------------------------------------------
    | Linkedin URL
    |--------------------------------------------------------------------------
    |
    | This URL resources is used by social network.
    |
    */
    'linkedin' => [
      'show' => env('SOCIAL_NETWORK_LINKEDIN', true),

      'url' => env('SOCIAL_NETWORK_URL', 'https://www.linkedin.com/in/fisicalcoach-app'),
    ],
    /*
    |--------------------------------------------------------------------------
    | Vimeo URL
    |--------------------------------------------------------------------------
    |
    | This URL resources is used by social network.
    |
    */
    'vimeo' => [
      'show' => env('SOCIAL_NETWORK_VIMEO', false),

      'url' => env('SOCIAL_NETWORK_URL', 'https://vimeo.com/user118089682'),
    ],
    /*
    |--------------------------------------------------------------------------
    | Twitch URL
    |--------------------------------------------------------------------------
    |
    | This URL resources is used by social network.
    |
    */
    'twitch' => [
      'show' => env('SOCIAL_NETWORK_TWITCH', true),

      'url' => env('SOCIAL_NETWORK_URL', 'https://www.twitch.tv/fisicalcoach'),
    ],
    /*
    |--------------------------------------------------------------------------
    | Tumblr URL
    |--------------------------------------------------------------------------
    |
    | This URL resources is used by social network.
    |
    */
    'tumblr' => [
      'show' => env('SOCIAL_NETWORK_TUMBLR', false),

      'url' => env('SOCIAL_NETWORK_URL', 'https://at.tumblr.com/fisicalcoach'),
    ],

];
