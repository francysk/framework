<?php

namespace Francysk\Framework\Model;

if ( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true )
    die();

use Francysk\Framework\Core\AbstractClass\Model;

class FCatalog extends Model
{
    public function fetch() {
        return $this->oBDResult->fetch();
    }
    
    public function execute() {
        $this->oBDResult = \Bitrix\Catalog\PriceTable::getList(
                        [
                          "order" => $this->aOrder,
                          "filter" => $this->aFilter,
                          "select" => ["*", "PRODUCT"]
                        ]
        );

        return $this;
    }

}
