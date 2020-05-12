<?php

namespace Francysk\Framework\Entity;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Francysk\Framework\Decorator\File;
use Francysk\Framework\Collection\ResultsByID;
use Francysk\Framework\Collection\ResultByID;
use Bitrix\Iblock\SectionElementTable;

class ElementsSections extends ElementWithProp
{
    private $aElements = [];
    private $aSections = [];

    protected function initFilesCode()
    {
        parent::initFilesCode();
        $this->aFilesCode[] = "PICTURE";
    }

    public function process($logic, $row)
    {
        if ($logic == "ITEMS") {
            $this->pushFilesProp($row);
            $this->pushFiles($row);
            $this->aElements[] = $row["ID"];
        } elseif ($logic == "BIND") {
            $this->aSections[$row["ID"]] = $row["ID"];
        } elseif ($logic == "SECTIONS") {
            $this->pushFiles($row);
        }

        return $row;
    }

    public function getLogicModelSECTIONS()
    {
        if( empty($this->aSections) ) {
            return false;
        }

        $oModel = new \Francysk\Framework\Model\FCIBlockSection();
        $oModel->addFilter(["ID" => $this->aSections]);

        return $oModel->execute();
    }

    public function getLogicModelBIND()
    {
        if( empty($this->aElements) ) {
            return false;
        }

        return SectionElementTable::getList([
            "select" => [
                "ID" => "IBLOCK_SECTION_ID",
                "ELEMENT_ID" => "IBLOCK_ELEMENT_ID"
            ],
            "filter" => [
                "IBLOCK_ELEMENT_ID" => $this->aElements
            ]
        ]);
    }

    public function getResult(): array
    {
        $this->executeEntity();

        return [
            "ITEMS" => $this->aCollectionResult["ITEMS"]->getResult(),
            "BIND" => $this->aCollectionResult["BIND"]->getResult(),
            "SECTIONS" => $this->aCollectionResult["SECTIONS"]->getResult(),
            "FILES" => $this->aCollectionResult["FILES"]->getResult(),
            "DB" => $this->oModel->getMetaData(),
        ];
    }

    protected function initLogic()
    {
        $this->aLogic = [
            "ITEMS",
            "BIND",
            "SECTIONS",
            "FILES",
        ];

        return $this;
    }

    protected function initDecorator()
    {
        $this->aDecorator = [
            "ITEMS" => [],
            "BIND" => [],
            "SECTIONS" => [],
            "FILES" => [
                new File(),
            ],
        ];
    }

    protected function initCollectionResult()
    {
        $this->aCollectionResult = [
            "ITEMS" => new ResultByID(),
            "BIND" => new ResultsByID(),
            "SECTIONS" => new ResultByID(),
            "FILES" => new ResultByID(),
        ];
    }

}
