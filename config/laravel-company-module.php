<?php

return [
    /*
    |--------------------------------------------------------------------------
    | General config
    |--------------------------------------------------------------------------
    */
    'date_format'           => 'd.m.Y H:i:s',
    'icons' => [
        'company'           => 'icon-puzzle'
    ],

    /*
    |--------------------------------------------------------------------------
    | URL config
    |--------------------------------------------------------------------------
    */
    'url' => [
        'company'                   => 'company-profile',       // company profile url
        'admin_url_prefix'          => 'admin',                 // admin dashboard url prefix
        'middleware'                => ['auth', 'permission']   // company module middleware
    ],

    /*
    |--------------------------------------------------------------------------
    | Controller config
    | if you make some changes on controller, you create your controller
    | and then extend the Laravel Company Module Controller. If you don't need
    | change controller, don't touch this config
    |--------------------------------------------------------------------------
    */
    'controller' => [
        'company_admin_namespace'   => 'ErenMustafaOzdal\LaravelCompanyModule\Http\Controllers',
        'company'                   => 'CompanyController'
    ],

    /*
    |--------------------------------------------------------------------------
    | View config
    |--------------------------------------------------------------------------
    | dot notation of blade view path, its position on the /resources/views directory
    */
    'views' => [
        // company view
        'company' => [
            'layout'    => 'laravel-modules-core::layouts.admin',               // company layout
            'edit'      => 'laravel-modules-core::company.operation',           // get company edit view blade
        ]
    ],


    /*
    |--------------------------------------------------------------------------
    | Routes on / off
    | if you don't use any route; set false
    |--------------------------------------------------------------------------
    */
    'routes' => [
        'admin' => [
            'company_edit'          => true,        // admin company edit route
            'company_update'        => true,        // admin company update route
        ],
        'api' => [
            'company_removePhoto'   => true,        // admin company remove photo route
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Models config
    |--------------------------------------------------------------------------
    |
    | ## Options
    |
    | - default_img_path                : model default avatar or photo
    |
    | --- uploads                       : model uploads options
    | - path                            : file path
    | - max_size                        : file allowed maximum size
    | - max_file                        : maximum file count
    | - aspect_ratio                    : if file is image; crop aspect ratio
    | - mimes                           : file allowed mimes
    | - thumbnails                      : if file is image; its thumbnails options
    |
    | NOT: Thumbnails fotoğrafları yüklenirken bakılır:
    |       1. eğer post olarak x1, y1, x2, y2, width ve height değerleri gönderilmemiş ise bu değerlere göre
    |       thumbnails ayarlarında belirtilen resimleri sistem içine kaydeder.
    |       Yani bu değerler post edilmişse aşağıdaki değerleri yok sayar.
    |       2. Eğer yukarıdaki ilgili değerler post edilmemişse, thumbnails ayarlarında belirtilen değerleri
    |       dikkate alarak thumbnails oluşturur
    |
    |       Ölçü Belirtme:
    |       1. İstenen resmin width ve height değerleri verilerek istenen net bir ölçüde resimler oluşturulabilir
    |       2. Width değeri null verilerek, height değerine göre ölçeklenebilir
    |       3. Height değeri null verilerek, width değerine göre ölçeklenebilir
    |--------------------------------------------------------------------------
    */
    'company' => [
        'default_img_path'              => 'vendor/laravel-modules-core/assets/global/img/company',
        'uploads' => [
            // company photo options
            'photo' => [
                'relation'              => 'hasMany',
                'relation_model'        => '\App\CompanyPhoto',
                'type'                  => 'image',
                'column'                => 'photos.photo',
                'path'                  => 'uploads/company',
                'max_size'              => '5120',
                'max_file'              => 5,
                'aspect_ratio'          => 16/9,
                'mimes'                 => 'jpeg,jpg,jpe,png',
                'thumbnails' => [
                    'small'             => [ 'width' => 35, 'height' => null],
                    'normal'            => [ 'width' => 300, 'height' => null],
                    'big'               => [ 'width' => 800, 'height' => null],
                ]
            ]
        ]
    ],






    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */
    'permissions' => [
        'company' => [
            'title'                 => 'Firma Profili',
            'routes' => [
                'admin.company.edit' => [
                    'title'         => 'Güncelleme Sayfası',
                    'description'   => 'Bu izne sahip olanlar firma profilini güncelleme sayfasına gidebilir.',
                ],
                'admin.company.update' => [
                    'title'         => 'Güncelleme',
                    'description'   => 'Bu izne sahip olanlar firma profilini güncelleyebilir.',
                ],
                'admin.company.removePhoto' => [
                    'title'         => 'Fotoğraf Silme',
                    'description'   => 'Bu izne sahip olanlar firma profili fotoğrafını silebilir.',
                ],
            ],
        ],
    ],
];
