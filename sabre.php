<?php

use
    Sabre\DAV;

require 'vendor/autoload.php';
require_once 'mydir.php';
require_once 'myfile.php';
require_once 'mynode.php';

//$rootDirectory = new DAV\FS\Directory('public');
$rootDirectory = new MyDirectory('public');

$server = new DAV\Server($rootDirectory);

//$server->setBaseUri('/');
$server->setBaseUri('/dav');
//$server->setBaseUri('/sabre.php');

$lockBackend = new DAV\Locks\Backend\File('data/locks');
$lockPlugin = new DAV\Locks\Plugin($lockBackend);
$server->addPlugin($lockPlugin);

$server->addPlugin(new DAV\Browser\Plugin());

$server->exec();

?>