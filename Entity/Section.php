<?php

namespace Francysk\Framework\Entity;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Francysk\Framework\Decorator\File;
use Francysk\Framework\Model\FCIBlockSection;
use Francysk\Framework\Collection\ResultByID;

class Section extends Element
{       
    protected function initVars() {
        parent::initVars();
        $this->oModel = new FCIBlockSection();        
    }
    
    protected function initFilesCode()
    {
        $this->aFilesCode = [
            "PICTURE"
        ];
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