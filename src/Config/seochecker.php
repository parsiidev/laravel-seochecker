<?php

return [
    /* set models */
    'models' => [
        'Post' => [
            'class' => \Modules\Posts\Entities\Post::class ,
            'primary_key' => 'id' ,
            'focal_keyword_field' => 'seo_focal_keyword'
        ]
    ] ,

    /* config route */
    'route' => [
        'prefix' => 'admin/seo-checker' ,
        'middleware' => [
            'web' ,
            'auth'
        ] ,
    ] ,

    /* config seo details */
    'seo' => [
        'title-max-length' => 68 ,
        'title-min-length' => 15 ,
        'content-min-length' => 300 ,
        'description-min-length' => 80 ,
        'description-max-length' => 168 ,
    ]

];