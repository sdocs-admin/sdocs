<?php

namespace sDocs\sDocs;

use Sabre\DAV;

class MyFile extends MyNode implements DAV\IFile {

    function put($data) {
        WriteLog("file", $this->path, "put");
        file_put_contents($this->path, $data);
        clearstatcache(true, $this->path);
    }

    function get() {
        WriteLog("file", $this->path, "get");
        return fopen($this->path, 'r');
    }

    function delete() {
        WriteLog("file", $this->path, "delete");
        return;
        unlink($this->path);
    }

    function getSize() {
        WriteLog("file", $this->path, "getSize");
        return filesize($this->path);
    }

    function getETag() {
        WriteLog("file", $this->path, "getEtag");
        return '"' . sha1(
            fileinode($this->path) .
            filesize($this->path) .
            filemtime($this->path)
        ) . '"';
    }

    function getContentType() {
        WriteLog("file", $this->path, "getConntType");
        return null;
    }

}
