<?php

namespace sDocs\sDocs;

use Sabre\DAV;
use Sabre\HTTP\URLUtil;

abstract class Node implements DAV\INode {

    protected $path;
    public $server;

    function __construct($path, $server = null) {
        //WriteLog("node", $path, "constructor");
        if ($server != null) {
            $this->server = $server;
        }
        $this->path = $path;
    }

    function getName() {
        $this->server->WriteLog("node", $this->path, "getName");
        list(, $name) = URLUtil::splitPath($this->path);
        return $name;
    }

    function setName($name) {
        $this->server->WriteLog("node", $this->path, "setName", $name);
        list($parentPath, ) = URLUtil::splitPath($this->path);
        list(, $newName) = URLUtil::splitPath($name);

        $newPath = $parentPath . '/' . $newName;

        rename($this->path, $newPath);

        $this->path = $newPath;
    }

    function getLastModified() {
        $this->server->WriteLog("node", $this->path, "getLastModified");
        return filemtime($this->path);
    }

}
