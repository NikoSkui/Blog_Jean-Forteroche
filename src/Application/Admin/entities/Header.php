<?php

namespace App\Admin\entities;

use  System\Renderer\RendererInterface;

class Header
{
  private $renderer;

  private $prefixName;
  private $typePage = 'dashboard';
  private $name;
  private $title = 'Administration';
  private $subtitle = 'Gestion du site';
  private $callToAction;
  private $navBar;

  public function __construct (RendererInterface $renderer) {

    $this->renderer = $renderer;
        
    if ($this->renderer->hasView('@blog/')) {
      $this->navBar['Book'] = [
        'name' => 'Livres',
        'prefixName' => 'Admin#Books'
      ];
      $this->navBar['Chapter'] = [
        'name' => 'Chapitres',
        'prefixName' => 'Admin#Chapters'
      ];
    }

    if ($this->renderer->hasView('@comment/')) {
      $this->navBar['Comments'] = [
        'name' => 'Commentaires',
        'prefixName' => 'Admin#Comments'
      ];
    }
  }

  /**
   * Method to get private attribute
   **/
  private function getPrefixName()
  {
    return $this->prefixName;
  }

  /**
   * Method to get private attribute
   **/
  private function getName()
  {
    return $this->name;
  }

  /**
   * Method to get private attribute
   **/
  private function getSubtitle()
  {
    return $this->subtitle;
  }

  /**
   * Method to get private attribute
   **/
  private function getCallToAction()
  {
    return $this->callToAction;
  }

  /**
   * Method to get private attribute
   **/
  private function getTypePage()
  {
    return $this->typePage;
  }

  /**
   * Method to get private attribute
   **/
  private function getNavBar()
  {
    return $this->navBar;
  }


  /**
   * Method to set private attribute
   **/
  private function setPrefixName($value)
  {
    $this->prefixName = $value;
    return $this->prefixName;
  }

  /**
   * Method to set private attribute
   **/
  private function setName($value)
  {
    $this->name = $value;
    return $this->name;
  }
  
  /**
   * Method to set private attribute
   **/
  private function setSubtitle($value)
  {
    $this->subtitle = $value;
    return $this->subtitle;
  }
  
  /**
   * Method to set private attribute
   **/
  private function setCallToAction($value)
  {
    $this->callToAction = $value;
    return $this->callToAction;
  }
  
  /**
   * Method to set private attribute
   **/
  private function setTypePage($value)
  {
    $this->typePage = $value;
    return $this->typePage;
  }
  
  /**
   * Method to set private attribute
   **/
  private function setNavBar($value)
  {
    $this->navBar = $value;
    return $this->navBar;
  }

  /**
   * Method magique __get
   */
  public function __GET($name)
  {
    $method = 'get'.ucfirst($name);
    $this->$name = $this->$method();
    return $this->$name;
  }

  /**
   * Method magique __set
   */
  public function __SET($name, $value)
  {
    $method = 'set'.ucfirst($name);
    $this->$name = $this->$method($value);
    return $this->$name;
  }

  /**
   * Method magique __isset
   */
  public function __ISSET($name)
  {
    if(isset($this->$name)){
      return true;
    }
  }
}

