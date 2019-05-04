<?php

//Корневая директория сайта
define('DIR_ROOT',		$_SERVER['DOCUMENT_ROOT']);
//Директория с изображениями (относительно корневой)
define('DIR_IMAGES',	'/storage/tiny/images');
//Директория с файлами (относительно корневой)
define('DIR_FILES',		'/storage/tiny/files');


//Высота и ширина картинки до которой будет сжато исходное изображение и создана ссылка на полную версию
define('WIDTH_TO_LINK', 1000);
define('HEIGHT_TO_LINK', 1000);

//Атрибуты которые будут присвоены ссылке (для скриптов типа lightbox)
define('CLASS_LINK', 'lightview');
define('REL_LINK', 'lightbox');

date_default_timezone_set('Asia/Yekaterinburg');

if (!file_exists(DIR_ROOT.DIR_IMAGES)) {
    \RS\File\Tools::makePath(DIR_ROOT.DIR_IMAGES);
}

if (!file_exists(DIR_ROOT.DIR_FILES)) {
    \RS\File\Tools::makePath(DIR_ROOT.DIR_FILES);
}