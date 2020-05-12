<?php

namespace Francysk\Framework\Core\Interfaces;

if ( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true )
    die();

interface Fabrica
{
    /**
     * 
     * @param int $iType
     */
    public function getClass($iType);
}