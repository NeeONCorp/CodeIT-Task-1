<?php
return $routes = [
    ''                  => 'App/index',
    '404'               => 'App/page404',
    'login'             => 'User/PageLogin',
    'registration'      => 'User/PageRegistration',

    # Аккаунт
    'account'           => 'Account/index',
    'account/logout'    => 'Account/logout',

    # Ajax запросы
    'ajax/registration' => 'User/ajaxRegistration',
    'ajax/login'        => 'User/ajaxLogin',
];