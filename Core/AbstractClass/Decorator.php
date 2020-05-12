<?php

namespace Francysk\Framework\Core\AbstractClass;

if ( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true )
    die();

abstract class Decorator
{
    /**
     *
     * @var CCBitrixComponent
     */
    protected $oComponent;
    
    protected $oEntity;
    
    public function __construct() {
        $this->oComponent = null;
    }
    
    public function initComponent(CCBitrixComponent $oComponent) {
        $this->oComponent = $oComponent;
    }
    
    public function initEntity($oEntity) {
        $this->oEntity = $oEntity;
    }
}