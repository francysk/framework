<?php

namespace Francysk\Framework\Core\AbstractClass;

if ( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true )
    die();

abstract class Result
{
    protected $result;
    
    public function __construct() {
        $this->result = array();
    }
    
    public function count() {
        return count($this->result);
    }
    
    public function getResult() {
        return $this->result;
    }
    
    abstract public function add(array $aItem);
}