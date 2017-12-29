<?php

namespace sDocs\sDocs;
//234234 sdf

use Sabre\DAV;

class File extends Node implements DAV\IFile {

    function put($data) {
        $this->server->WriteLog("file", $this->path, "put");
        file_put_contents($this->path, $data);
        clearstatcache(true, $this->path);
    }

    function get() {
        $this->server->WriteLog("file", $this->path, "get");
        return fopen($this->path, 'r');
    }

    function delete() {
        $this->server->WriteLog("file", $this->path, "delete");
        return;
        unlink($this->path);
    }

    function getSize() {
        $this->server->WriteLog("file", $this->path, "getSize");
        return filesize($this->path);
    }

    function getETag() {
        $this->server->WriteLog("file", $this->path, "getEtag");
        return '"' . sha1(
            fileinode($this->path) .
            filesize($this->path) .
            filemtime($this->path)
        ) . '"';
    }

    function getContentType() {
        $this->server->WriteLog("file", $this->path, "getConntType");
        return null;
    }

}
