<?php

namespace Yoga\Generator;

use gossi\codegen\generator\CodeFileGenerator;
use Yoga\Utils\Traits\HasGettersAndSetters;
use gossi\codegen\model\PhpClass;
use Yoga\Utils\Helpers\FileHelper;

class ClassGenerator
{
  use HasGettersAndSetters;

  /**
   * Generated Class Name
   */
  public $name = '';

  /**
   * Generated Class Namespace
   */
  public $namespace = '';

  /**
   * Path Where to Write the Class Code
   */
  public $filePath = '';

  /**
   * Use Statements Placed on Top of the File
   */
  public $useStatements = [];

  /**
   * Generated Class Traits
   */
  public $traits = [];

  /**
   * Generated Class Properties
   */
  public $properties = [];

  /**
   * Generated Class Methods
   */
  public $methods = [];

  /**
   * Class Instance
   */
  protected $_classInstance; 

  /**
   * Boot the Class Generator Using a Existing Class File
   */
  function bootFrom(string $filePath)
  {
    $this->_classInstance = PhpClass::fromFile($filePath);
    $this->filePath       = $filePath;
    return $this;
  }

  /**
   * Boot the Class Generator
   */
  function boot(string $name, string $path)
  {
    // Sets the properties
    $this->name = $name;
    $this->path = $path;
    
    // Creates the instance
    $this->_classInstance = new PhpClass();
    $this->_classInstance->setName($this->name);

    // Returns the instance
    return $this;
  }

  /**
   * Gets the Generated Class Code
   */
  function getCode()
  {
    $generator = new CodeFileGenerator();
    return $generator->generate($this->_classInstance);
  }

  /**
   * Writes the Class Into the File
   */
  function writeClass()
  {
    FileHelper::write($this->filePath, $this->getCode());
  }
}
