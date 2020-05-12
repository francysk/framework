<?php

namespace Francysk\Framework\Collection;

if ( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true )
    die();

use Francysk\Framework\Core\AbstractClass;

class ResultsByID extends AbstractClass\Result
{
    public function add(array $aItem) {
        $this->result[$aItem["ID"]][] = $aItem;
    }
}
