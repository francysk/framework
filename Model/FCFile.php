<?php

namespace Francysk\Framework\Model;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Francysk\Framework\Core\AbstractClass\Model;

class FCFile extends Model
{

    public function setFilter(array $aFilter)
    {
        if( array_key_exists("ID", $aFilter) ) {
            $_v = $aFilter["ID"];
            
            if( is_array($_v) ) {
                $_v = implode(",", $_v);
            }
            
            $aFilter["@ID"] = $_v;
            unset($aFilter["ID"]);
        }
        
        return parent::setFilter($aFilter);
    }

    public function execute()
    {
        $this->oBDResult = \CFile::getList(array(), $this->aFilter);

        return $this;
    }

}
