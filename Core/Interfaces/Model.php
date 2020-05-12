<?php

namespace Francysk\Framework\Core\AbstractClass;

if ( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true )
    die();

interface iModel
{
    public function addOrder();
    public function setOrder();
    
    public function addFilter();
    public function setFilter();
    
    public function addSelect();
    public function setSelect();
}