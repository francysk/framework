<?php

namespace Francysk\Framework\Entity;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Francysk\Framework\Decorator\File;
use Francysk\Framework\Model\FCIBlockElementAllProp;
use Francysk\Framework\Model\FCFile;
use Francysk\Framework\Collection\ResultByID;

class ElementWithProp extends Element
{

    protected function initVars()
    {
        parent::initVars();
        $this->oModel = new FCIBlockElementAllProp();
    }

    public function process($logic, $row)
    {
        parent::process($logic, $row);

        if ($logic == "ITEMS") {
            $this->pushFilesProp($row);
        }
    }

    public function pushFilesProp($row)
    {
        foreach ($this->aFilesCode as $fileCode) {
            if (isset($row["PROPERTIES"][$fileCode])) {
                if (is_array($row["PROPERTIES"][$fileCode]["VALUE"])) {
                    if (!is_array($this->aFilesIDs)) {
                        $this->aFilesIDs = [];
                    }
                    $this->aFilesIDs = array_merge($this->aFilesIDs, $row["PROPERTIES"][$fileCode]["VALUE"]);
                } else {
                    $this->aFilesIDs[] = $row["PROPERTIES"][$fileCode]["VALUE"];
                }
            }
        }
    }
    public function getResult(): array
    {
        $this->executeEntity();

        return [
            "ITEMS" => $this->aCollectionResult["ITEMS"]->getResult(),            
            "FILES" => $this->aCollectionResult["FILES"]->getResult(),
            "DB" => $this->oModel->getMetaData(),
        ];
    }

    protected function initLogic()
    {
        $this->aLogic = [
            "ITEMS",
            "FILES",
        ];

        return $this;
    }

    protected function initDecorator()
    {
        $this->aDecorator = [
            "ITEMS" => [],
            "FILES" => [
                new File(),
            ],
        ];
    }

    protected function initCollectionResult()
    {
        $this->aCollectionResult = [
            "ITEMS" => $this->oCollectionResult,            
            "FILES" => new ResultByID(),
        ];
    }

}
