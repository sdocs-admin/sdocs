<?php

use Sabre\DAV;
use sDocs\sDocs;

$start = "../";

if (php_sapi_name() == 'cli-server') {
   $start = "";
}

require $start . 'vendor/autoload.php';
require $start . 'application/users.php';

function WriteLog($class, $name, $func, $str = "") {
    global $start;
    $log = $start . "logs/dav.log";
    $s = PHP_EOL . "class=$class,func=$func,name=$name,str=$str";
    file_put_contents($log, $s, FILE_APPEND);
}

WriteLog("------------------", "", "");

$authBackend = new Sabre\DAV\Auth\Backend\BasicCallBack(function($userName, $password) {
    WriteLog("auth", $userName, "");

    global $users;

    $u = $users[$userName];

    if (($u != null) && ($u['pass'] == $password)) {
        return true;
    } else {
        return false;
    }
});
$authPlugin = new Sabre\DAV\Auth\Plugin($authBackend);

$rootDirectory = new sDocs\MyDirectory($start . "webdav", $authPlugin);

$server = new DAV\Server($rootDirectory);
$server->setBaseUri('/');

$server->addPlugin($authPlugin);

$lockBackend = new DAV\Locks\Backend\File("locks");
$lockPlugin = new DAV\Locks\Plugin($lockBackend);
$server->addPlugin($lockPlugin);

$server->addPlugin(new DAV\Browser\Plugin());

$server->addPlugin(new DAV\Mount\Plugin());

$server->exec();
