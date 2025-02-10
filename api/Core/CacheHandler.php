<?php

/*
namespace Rabbit\Core
use Exception;

class CacheHandler {
    private $prefix;
    private $cachePath;
    private $cacheExpiration;
    private $extension;

    public function __construct($prefix, $cacheExpiration = 0, $path=null, $extension='json') {
      if(is_null($path)) {
        if(!defined("RAM_DISK_API_CACHE")) {
          throw new Exception('RAM_DISK_API_CACHE is not defined');
        }
        $path = RAM_DISK_API_CACHE;
      }
      
      if(trim($prefix) == '') {
        throw new Exception('Prefix cannot be empty');
      }

      $this->setPrefix($prefix);
      $this->setCachePath($path);
      $this->setCacheExpiration($cacheExpiration);
      $this->setExtension($extension);

      $this->clearExpiredCache();

    }

    public function getPrefix(){
      return $this->prefix;
    }

    private function setPrefix($value){
      $this->prefix = $value . "_";
    }

    public function getCachePath(){
      return $this->cachePath;
    }

    public function setCachePath($value){
      $this->cachePath = rtrim($value, '/') . '/';

      if ( !file_exists($this->cachePath) ) {
        @mkdir($this->cachePath);
      }
    }

    public function getCacheExpiration(){
      return $this->cacheExpiration;
    }

    public function setCacheExpiration($value){
      $this->cacheExpiration = $value;
    }

    public function getExtension(){
      return $this->extension;
    }

    public function setExtension($value){
      $this->extension = '.' . ltrim($value, '.');
    }

    private function getCacheFilePath($filename) {
      return $this->getCachePath() . $this->getPrefix() . $filename . $this->getExtension();
    }

    public function getCache($filename) {
      $cacheFile = $this->getCacheFilePath($filename);
      if (file_exists($cacheFile)) {
          return file_get_contents($cacheFile);
      }
      return false;
    }

    public function setCache($filename, $data) {
      $cacheFile = $this->getCacheFilePath($filename);
      file_put_contents($cacheFile, $data);
    }

    public function clearCache($filename) {
      $cacheFile = $this->getCacheFilePath($filename);
      if (file_exists($cacheFile)) {
          unlink($cacheFile);
      }
    }

    public function clearExpiredCache() {
      // Solo limpia la caché si la expiración es mayor que 0
      if ($this->getCacheExpiration() > 0) {
        foreach (glob($this->getCacheFilePath('*')) as $file) {
          if (time() - filemtime($file) > $this->getCacheExpiration()) {
              unlink($file);
          }
        }
      }
    }

    public function clearPrefixCache($prefix) {
      foreach (glob($this->getCacheFilePath('*') ) as $file) {
        unlink($file);
      }
    }
  
}

*/