<?php 
namespace Rabbit\Utils; 

class FileContent {

  private $content='';
  private $name;
  private $path;
  private $extension;

  public function __construct($name, $path='./api/storage', $extension='txt') {
    $this->setName($name);
    $this->setPath($path);
    $this->setExtension($extension);
  }

  public function getContent() {
    return $this->content;
  }

  public function setContent($content, $concatenate=true) {
    if($concatenate) {
      $this->content .= $content;
    } else {
      $this->content = $content;
    }
  }

  // Getter y Setter para $name
  public function getName() {
      return $this->name;
  }

  public function setName($name) {
      $this->name = $name;
  }

  // Getter y Setter para $path
  public function getPath() {
      return $this->path;
  }

  public function setPath($path) {
      $this->path = $path;
  }

  // Getter y Setter para $extension
  public function getExtension() {
      return $this->extension;
  }

  public function setExtension($extension) {
      $this->extension = $extension;
  }

  public function setContentLine($content, $tabs = 0, $concatenate = true) {
    $tabSpace = str_repeat(' ', (TAB_SPACE * $tabs));
    $this->setContent($tabSpace . $content . "\n", $concatenate);
  }


  public function create() {
    $filePath = $this->getPath() . $this->getName() . '.' . $this->getExtension();
    file_put_contents($filePath, $this->getContent());
  }

}