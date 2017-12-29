<?php

namespace sDocs\sDocs;
// sdf s

use Sabre\DAV;

class Server extends DAV\Server {
    public $plugins = [];

    function __construct($treeOrNode = null) {
        $this->WriteLog("---------------", "", "");

        parent::__construct($treeOrNode);

        if ($treeOrNode != null) {
            $treeOrNode->server = $this;
        }
    }

    function WriteLog($class, $name, $func, $str = "") {
        $log = "logs/dav.log";
        $s = PHP_EOL . "class=$class,func=$func,name=$name,str=$str";
        file_put_contents($log, $s, FILE_APPEND);
    }

}

