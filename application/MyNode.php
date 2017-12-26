<?php

namespace sDocs\sDocs;

use Sabre\DAV;
use Sabre\HTTP\URLUtil;

abstract class MyNode implements DAV\INode {

    protected $path;
    protected $authPlugin;

    function __construct($path, $authPlugin) {
        //WriteLog("node", $path, "constructor");
        $this->authPlugin = $authPlugin;
        $this->path = $path;
    }

    function getName() {
        WriteLog("node", $this->path, "getName");
        list(, $name) = URLUtil::splitPath($this->path);
        return $name;
    }

    function setName($name) {
        WriteLog("node", $this->path, "setName", $name);
        list($parentPath, ) = URLUtil::splitPath($this->path);
        list(, $newName) = URLUtil::splitPath($name);

        $newPath = $parentPath . '/' . $newName;
        rename($this->path, $newPath);

        $this->path = $newPath;
    }

    function getLastModified() {
        WriteLog("node", $this->path, "getLastModified");
        return filemtime($this->path);
    }

}
