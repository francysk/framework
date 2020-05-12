<?php

namespace Francysk\Framework\Model;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Francysk\Framework\Core\AbstractClass\Model;

class FCIBlockElementAllProp extends Model
{

    public function fetch()
    {
        $row = $this->oBDResult->getNextElement(true, false);

        $result = false;
        if(is_object($row)) {
            $result = $row->getFields();
            $result["PROPERTIES"] = $row->getProperties();
        }

        return $result ? $result : $row;
    }

    public function execute()
    {
        $this->oBDResult = \CIBlockElement::getList(
                        $this->aOrder, $this->aFilter, false, $this->aNavParams, $this->aSelect
        );

        return $this;
    }

}
