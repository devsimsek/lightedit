<?php
$config['/'] = 'home';

$config['/signin'] = 'auth/signin';
$config['/signup'] = 'auth/signup';
$config['/signout'] = 'auth/signout';
$config['/callback'] = ['auth/callback', 'POST'];

$config['/dashboard'] = 'dashboard/home/index';

$config['/dashboard/account'] = 'dashboard/account/index';
$config['/dashboard/account/update'] = ['dashboard/account/update', 'POST'];
$config['/dashboard/account/update'] = 'dashboard/account/update';
$config['/dashboard/account/update/{id}'] = ['dashboard/account/update', 'POST'];
$config['/dashboard/account/update/{id}'] = 'dashboard/account/update';
$config['/dashboard/account/create'] = ['dashboard/account/create', 'POST'];
$config['/dashboard/account/create'] = 'dashboard/account/create';
$config['/dashboard/account/delete/{id}'] = 'dashboard/account/delete';

$config['/dashboard/settings'] = 'dashboard/settings/index';
$config['/dashboard/settings/update'] = ['dashboard/settings/update', 'POST'];
$config['/dashboard/settings/update'] = 'dashboard/settings/update';
$config['/dashboard/settings/update/{id}'] = ['dashboard/settings/update', 'POST'];
$config['/dashboard/settings/update/{id}'] = 'dashboard/settings/update';
$config['/dashboard/settings/create'] = ['dashboard/settings/create', 'POST'];
$config['/dashboard/settings/create'] = 'dashboard/settings/create';
$config['/dashboard/settings/delete/{id}'] = 'dashboard/settings/delete';
