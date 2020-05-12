<?php

namespace Francysk\Framework\Entity;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Francysk\Framework\Decorator\File;
use Francysk\Framework\Decorator\Product;
use Francysk\Framework\Collection\ResultByID;

class SimpleProduct extends ElementWithProp
{       
    
    public function process($logic, $row) {
        parent::process($logic, $row);
        
        if( $logic == "ITEMS" ) {
            $this->aProductID[] = $row["ID"];
        }
    }
    
    public function getLogicModelPRODUCT() {
        $this->aCollectionResult["PRODUCT"]->setKey("PRODUCT_ID");
        
        $iPriceType = 1;//$this->oComponent->getPersonType();
        $model = new \Francysk\Framework\Model\FCatalog;
        $model->addFilter(["PRODUCT_ID" => $this->aProductID, "CATALOG_GROUP_ID" => $iPriceType])
                ->execute();

        return $model;
    }    
        
    public function getResult(): array
    {
        $this->initEntityParams()
                ->executeEntity();
        
        return [
            "ITEMS" => $this->aCollectionResult["ITEMS"]->getResult(),
            "PRODUCT" => $this->aCollectionResult["PRODUCT"]->getResult(),
            "FILES" => $this->aCollectionResult["FILES"]->getResult(),
            "DB" => $this->oModel->getMetaData(),
        ];
    }
    
    protected function initLogic()
    {
        $this->aLogic = [
            "ITEMS",
            "PRODUCT",
            "FILES",
        ];
        
        return $this;
    }
    
    protected function initDecorator()
    {
        $this->aDecorator = [
            "ITEMS" => [],
            "PRODUCT" => [
                new Product(),
            ],
            "FILES" => [
                new File(),
            ],
        ];
    }
    
    protected function initCollectionResult()
    {
        $this->aCollectionResult = [
            "ITEMS" => $this->oCollectionResult,
            "PRODUCT" => new \Francysk\Framework\Collection\ResultByKey(),
            "FILES" => new ResultByID(),
        ];
    }
}