<?php

namespace Francysk\Framework\Collection;

if ( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true )
    die();

use Francysk\Framework\Core\AbstractClass;

class ResultBySection extends AbstractClass\Result
{
    public function add(array $aItem) {
        if( $aItem["IBLOCK_SECTION_ID"] == "" ) {
            $this->result[0][] = $aItem;
        } else {
            $this->result[$aItem["IBLOCK_SECTION_ID"]][] = $aItem;
        }
    }
}