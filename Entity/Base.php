<?php

namespace Francysk\Framework\Entity;

use Francysk\Framework\Decorator;
use Francysk\Framework\Core\AbstractClass\Entity;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

class Base extends Entity
{

    public function __construct(\CBitrixComponent $oComponent = null)
    {
        parent::__construct($oComponent);
    }

    public function executeEntity()
    {
        $this->initEntityParams();

        foreach ($this->aLogic as $logic) {
            $model = call_user_func([$this, "getLogicModel{$logic}"]);
            if (!is_object($model)) {
                continue;
            }
            while ($row = $model->fetch()) {
                $row = $this->decorateElement($logic, $row);

                $this->process($logic, $row);

                if( !empty($this->aCallback) ) {
                    foreach( $this->aCallback as $sCallback ) {
                        if (is_object($this->oComponent) && $sCallback) {
                            $row = call_user_func([$this->oComponent, $sCallback], $row, $logic);
                        }
                    }
                }
                $this->aCollectionResult[$logic]->add($row);
            }
        }
    }

    public function process($logic, $row)
    {
        if( $logic == "ITEMS" ) {
            $this->pushFiles($row);
        }

        return $row;
    }

    public function getLogicModelITEMS()
    {
        $this->oModel->execute();
        return $this->oModel;
    }

    public function getResult()
    {
        $this->executeEntity();
        return array(
            "ITEMS" => $this->aCollectionResult["ITEMS"]->getResult(),
        );
    }

    protected function initLogic()
    {
        $this->aLogic = array(
            "ITEMS",
        );

        return $this;
    }

    protected function initDecorator()
    {
        $this->aDecorator["ITEMS"] = array();
    }

    protected function initCollectionResult()
    {
        $this->aCollectionResult["ITEMS"] = $this->oCollectionResult;
    }

}
