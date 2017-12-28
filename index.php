<?php

use Sabre\DAV;
use sDocs\sDocs;

require 'vendor/autoload.php';
require 'application/users.php';
require 'application/documents.php';

$rootDirectory = new sDocs\Directory("webdav");
//$rootDirectory = new sDocs\Directory("/");
$server = new sDocs\Server($rootDirectory);
$server->setBaseUri('/');

$authBackend = new Sabre\DAV\Auth\Backend\BasicCallBack(function($userName, $password) {
    global $users;

    if (($users[$userName] != null) && ($users[$userName]['pass'] == $password)) {
        return true;
    } else {
        return false;
    }
});

$authPlugin = new Sabre\DAV\Auth\Plugin($authBackend);

$server->addPlugin($authPlugin);

$lockBackend = new DAV\Locks\Backend\File("locks");
$lockPlugin = new DAV\Locks\Plugin($lockBackend);
$server->addPlugin($lockPlugin);

$server->addPlugin(new DAV\Browser\Plugin());
//$server->addPlugin(new DAV\Mount\Plugin());
$server->exec();