<?php

defined('VG_ACCESS') or die('Access denied');

const MS_MODE = false;

const TEMPLATE = 'templates/default/';
const ADMIN_TEMPLATE = 'core/admin/view/';
const UPLOAD_DIR = 'userfiles/';
const DEFAULT_IMAGE_DIRECTORY = 'default_images';

const COOKIE_VERSION = '1.0.0';
const CRYPT_KEY= 'p2s5v8y/B?E(H+MbUjXn2r5u8x/A?D(GcRfUjWnZr4u7x!A%H@McQfTjWmZq4t7w?E(H+MbQeThWmYq3x/A?D(G+KbPeShVk4u7x!A%D*G-KaPdS';
const COOKIE_TIME = 60;
const BLOCK_TIME = 3;


const END_SLASH = '/';
const QTY = 8;
const QTY_LINKS = 3;

const ADMIN_CSS_JS = [
    'styles' => ['css/main.css'],
    'scripts' => [
        'js/frameworkfunctions.js', 'js/scripts.js','js/tinymce/tinymce.min.js',
        'js/tinymce/tinymce_init.js'
    ]
];
const USER_CSS_JS = [
    'styles' => [
        'https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700&display=swap&subset=cyrillic',
        'https://fonts.googleapis.com/css?family=Didact+Gothic&display=swap&subset=cyrillic',
        'https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css',
        'https://unpkg.com/swiper/swiper-bundle.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css',
        'assets/css/animate.css',
        'assets/css/style.css'
    ],
    'scripts' => [
        'https://code.jquery.com/jquery-3.4.1.min.js',
        'https://unpkg.com/swiper/swiper-bundle.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.2.5/gsap.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.0.2/gsap.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/ScrollMagic.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/animation.gsap.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/debug.addIndicators.min.js',
        'assets/js/jquery.maskedinput.min.js',
        'assets/js/TweenMax.min.js',
        'assets/js/ScrollMagic.min.js',
        'assets/js/animation.gsap.min.js',
        'assets/js/bodyscrolllock/bodyScrollLock.min.js',
        'assets/js/app.js',
        'assets/js/script.js'
    ]
];

use core\base\exceptions\RouteException;

function autoloadMainClasses($class_name){
    $class_name = str_replace('\\','/', $class_name);

    if (!@include_once $class_name . '.php'){
        throw new RouteException ('Не верное имя файла для подключения - '.$class_name);
    }
}
spl_autoload_register('autoloadMainClasses');
