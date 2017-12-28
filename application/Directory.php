<?php

//werwer

namespace sDocs\sDocs;

use Sabre\DAV;

class Directory extends Node implements DAV\ICollection, DAV\IQuota {

    function createFile($name, $data = null) {
        $this->server->WriteLog("dir", $this->path, "createFile", $name);
        $newPath = $this->path . '/' . $name;
        file_put_contents($newPath, $data);
        clearstatcache(true, $newPath);
    }

    function createDirectory($name) {
        $this->server->WriteLog("dir", $this->path, "createDirectory", $name);
        $newPath = $this->path . '/' . $name;
        mkdir($newPath);
        clearstatcache(true, $newPath);
    }

    function getChild($name) {
        $this->server->WriteLog("dir", $this->path, "getChild", $name);
        $path = $this->path . '/' . $name;

        if (!file_exists($path)) throw new DAV\Exception\NotFound('File with name ' . $path . ' could not be located');

        if (is_dir($path)) {
            return new self($path, $this->server);
        } else {
            return new File($path, $this->server);
        }
    }

    function getChildren() {
        //WriteLog("dir", $this->path, "getChildren", "user=" . $this->authPlugin->getCurrentPrincipal());
        $this->server->WriteLog("dir", $this->path, "getChildren", "user=" . $this->server->plugins['auth']->getCurrentPrincipal());

        $nodes = [];
        $iterator = new \FilesystemIterator(
            $this->path,
            \FilesystemIterator::CURRENT_AS_SELF
          | \FilesystemIterator::SKIP_DOTS
        );

        foreach ($iterator as $entry) {
            $nodes[] = $this->getChild($entry->getFilename());
        }
        return $nodes;
    }

    function childExists($name) {
        $this->server->WriteLog("dir", $this->path, "childExists", $name);
        $path = $this->path . '/' . $name;
        return file_exists($path);
    }

    function delete() {
        $this->server->WriteLog("dir", $this->path, "delete");
        return;
        foreach ($this->getChildren() as $child) {
            $child->delete();
        }
        rmdir($this->path);
    }

    function getQuotaInfo() {
        $absolute = realpath($this->path);
        return [
            disk_total_space($absolute) - disk_free_space($absolute),
            disk_free_space($absolute)
        ];
    }

}
