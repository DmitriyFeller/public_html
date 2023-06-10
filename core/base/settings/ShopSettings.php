<?php


namespace core\base\settings;




class ShopSettings
{

    use BaseSettings;

    private $routes = [
        'plugins' => [
            'dir' => false,
            'routes' => [

                ]

        ]

    ];
    private $templateArr = [
        'text' => ['price', 'short', 'name'],
        'textarea' => ['goods_content']
    ];

}