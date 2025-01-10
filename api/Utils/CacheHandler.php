<?php
namespace Rabbit\Utils; 

use Exception;

class CacheHandler {

    private $cachePath;
    private $cacheExpiration;
    private $extension;

    /**
     * Constructor de la clase CacheHandler.
     *
     * @param int $cacheExpiration Tiempo de expiración de la caché en segundos (0 para sin expiración).
     * @param string|null $path Ruta donde se almacenará la caché (si no se especifica, se utilizará la variable de entorno RAM_DISK_API_CACHE).
     * @param string $extension Extensión del archivo de caché (por defecto '.json').
     * @throws Exception Si RAM_DISK_API_CACHE no está definida y no se proporciona una ruta.
     */
    public function __construct($cacheExpiration = 0, $path = null, $extension = 'json') {
        if (is_null($path)) {
            if (!defined("RAM_DISK_API_CACHE")) {
                throw new Exception('RAM_DISK_API_CACHE is not defined');
            }
            $this->cachePath = RAM_DISK_API_CACHE;
        } else {
            $this->cachePath = $path;
        }

        if (!file_exists($this->cachePath)) {
            @mkdir($this->cachePath, 0755, true); 
        }

        $this->cachePath = rtrim($this->cachePath, '/') . '/';
        $this->cacheExpiration = $cacheExpiration;
        $this->extension = $extension;
    }

    /**
     * Obtener la ruta completa del archivo de caché para una clave dada.
     *
     * @param string $key Nombre diferenciado del caché.
     * @return string Ruta completa del archivo de caché.
     */
    private function getCacheFilePath($key) {
        return $this->cachePath . $key . '.' . $this->extension;
    }

    /**
     * Obtener los datos de la caché para una clave dada.
     *
     * @param string $key Nombre diferenciado del caché.
     * @return mixed Los datos de la caché o false si no existe o está expirado.
     */
    public function getCache($key, $decode=false) {
        $cacheFile = $this->getCacheFilePath($key);
        
        if (file_exists($cacheFile)) {
            if (($this->cacheExpiration > 0) && (time() - filemtime($cacheFile) > $this->cacheExpiration)) {
                unlink($cacheFile);
                return false;
            }
            
            $data = file_get_contents($cacheFile);
            
            if ($decode) {
                $data = $this->decodeData($data);
            }

            return $data;
        }
        return false;
    }

    /**
     * Guardar datos en la caché para una clave dada.
     *
     * @param string $key Nombre diferenciado del caché.
     * @param string $data Los datos que se almacenarán en la caché.
     * @return bool true si los datos se guardaron correctamente, false en caso contrario.
     */
    public function setCache($key, $data, $encode=false) {
        $cacheFileName = $this->getCacheFilePath($key);

        $file = fopen($cacheFileName, 'w');
   
        if ($file) {

            if($encode) {
                $data = $this->encodeData($data);
            }

            fwrite($file, $data);
            fflush($file); 
            exec('sync');  // Sincronizar los datos al disco
            fclose($file);  
            return true;
        } else {
            return false;
        }
   }

    /**
     * Eliminar un archivo de caché específico.
     *
     * @param string $key Nombre diferenciado del caché. a eliminar.
     * @return bool true si el archivo se eliminó correctamente, false en caso contrario.
     */
    public function clearCacheFile($key) {
        $cacheFile = $this->getCacheFilePath($key);
        if (file_exists($cacheFile)) {
            return unlink($cacheFile);
        }
        return false;
    }

    /**
     * Eliminar los archivos de caché expirados.
     *
     * @param string $prefix Prefijo de los archivos de caché a limpiar (opcional). Si no se indica borrará toda la caché expirada.
     * @return bool true si se ha eliminado correctamente o false en caso contrario
     */
    public function clearExpiredCache($prefix = '') {
        if ($this->cacheExpiration > 0) {
            foreach (glob($this->cachePath . $prefix . '*.' . $this->extension) as $file) {
                if (time() - filemtime($file) > $this->cacheExpiration) {
                    return unlink($file);
                }
            }
        }
    }

    /**
     * Eliminar los archivos de caché que coinciden con un prefijo dado.
     *
     * @param string $prefix El prefijo de los archivos de caché a eliminar.
     * @return bool true si se eliminaron archivos correctamente, false si no se eliminaron archivos.
     * @throws Exception Si no se encontraron archivos de caché con el prefijo dado.
     */
    public function clearPrefixCache($prefix) {
      $cacheFileList = glob($this->cachePath . $prefix . "*." . $this->extension);
      
      if (empty($cacheFileList)) {
          throw new Exception('Not found cache files with prefix ' . $prefix);
      }

      $success = array_reduce($cacheFileList, function($carry, $file) {
          return $carry && unlink($file); 
      }, true);

      return $success;
    }


    /**
     * Obtener los datos de la caché como un array para una clave dada.
     *
     * @param string $key Nombre diferenciado del caché..
     * @return array|false El contenido de la caché como un array o false si no existe.
     */
    public function getArrayCacheFile($key) {
        $cacheFile = $this->getCacheFilePath($key);
        if (file_exists($cacheFile)) {
            $fileContent = file_get_contents($cacheFile);
            return json_decode($fileContent, true);
        }
        return false;
    }

    /**
     * Modificar un archivo de caché, eliminándolo y luego escribiendo nuevos datos.
     *
     * @param string $key Nombre diferenciado del caché..
     * @param string $data Los nuevos datos que se escribirán en la caché.
     * @return bool true si la operación fue exitosa, false en caso contrario.
     */
    public function modifyCacheFile($key, $data) {
        if ($this->clearCacheFile($key)) {
            return $this->setCache($key, $data);
        }
        return false;
    }

    /**
     * Codifica los datos cacheados
     *
     * @param mixed $data Datos para codificar
     * @return mixed Datos codificados o los mismos datos si esta en una extension no contemplada en la lógica.
     */
    private function encodeData($data){
        switch($this->extension) {
            case 'json':
                return json_encode($data);
                break;
            default:
                return $data;
                break;
        }
    }

    /**
     * Decodifica los datos cacheados
     *
     * @param string $data Datos para descodificar
     * @return mixed Datos decodificados o los mismos datos si esta en una extension no contemplada en la lógica.
     */
    private function decodeData($data){
        switch($this->extension) {
            case 'json':
                return json_decode($data, true);
                break;
            default:
                return $data;
                break;
        }
    }

}