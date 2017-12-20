<?php

require_once 'mynode.php';

use Sabre\DAV;

class MyFile extends MyNode implements DAV\IFile {

    function put($data) {
        file_put_contents($this->path, $data);
        clearstatcache(true, $this->path);
    }

    function get() {
        return fopen($this->path, 'r');
    }

    function delete() {
        unlink($this->path);
    }

    function getSize() {
        return filesize($this->path);
    }

    function getETag() {
        return '"' . sha1(
            fileinode($this->path) .
            filesize($this->path) .
            filemtime($this->path)
        ) . '"';
    }

    function getContentType() {
        return null;
    }

}
