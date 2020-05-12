<?php

namespace Francysk\Framework\Collection;

if ( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true )
    die();

use Francysk\Framework\Core\AbstractClass;

class ResultByKey extends AbstractClass\Result
{
    protected $sKey;

    public function add(array $aItem) {
        if ($this->sKey) {
            $aItem["KEY"] = $aItem[$this->sKey];
        }

        $this->result[$aItem["KEY"]] = $aItem;
    }

    public function setKey($key) {
        $this->sKey = $key;
    } 
}