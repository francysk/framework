<?php

namespace Francysk\Framework\Model;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Francysk\Framework\Core\AbstractClass\Model;

class FCIBlockElement extends Model
{

    public function fetch()
    {
        return $this->oBDResult->getNext(true, false);
    }

    public function execute()
    {
        $this->oBDResult = \CIBlockElement::getList(
                        $this->aOrder, $this->aFilter, false, false, $this->aSelect
        );

        return $this;
    }

}
