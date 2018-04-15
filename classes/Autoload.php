<?php
spl_autoload_register(function ($class) {

    # Директории в которых ищем классы
    $paths = [
        ROOT.'/classes/',
        ROOT.'/models/',
    ];

    foreach ($paths as $path) {
        $fileClass = $path . $class . '.php';

        if(file_exists($fileClass)) {
            require_once ($fileClass);
            break;
        }
    }
});