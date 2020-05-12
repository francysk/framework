<?php

namespace Francysk\Framework\Core;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

class Context {
    
    static private $instance = null;
    
    private $objCache;
    
    private $context;
    
    private function __construct($sCacheID) {
        $this->objCache = new \CPHPCache;
        
        $this->context = array();
    }
    
    static public function getInstance($sCacheID = '') {
        if( self::$instance === null ) {
            self::$instance = new self($sCacheID);
        }
        
        return self::$instance;
    }
    
    
    public function get($key) {
        return $this->context[$key] ? $this->context[$key] : [];
    }
    
    public function set($key, $value) {
        $this->context[$key] = $value;
    }
    
    
}