<?php

namespace Francysk\Framework\Model;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Francysk\Framework\Core\AbstractClass\Model;

class FCIBlockSection extends Model
{

    public function fetch()
    {
        return $this->oBDResult->getNext(true, false);
    }

    public function initSelect(array $arParams): Model
    {
        $this->aSelect = ["UF_*"];
        return $this;
    }

    public function execute()
    {
        $this->oBDResult = \CIBlockSection::getList(
                        $this->aOrder, $this->aFilter, false, $this->aSelect
        );

        return $this;
    }

}
