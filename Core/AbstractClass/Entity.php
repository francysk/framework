<?php

namespace Francysk\Framework\Core\AbstractClass;

use Francysk\Framework\Model\FCIBlockElement;
use Francysk\Framework\Collection\Result;

abstract class Entity
{
    /**
     * Объект компонента
     * @var CBitrixComponent
     */
    protected $oComponent;

    /**
     * Массив логики работы
     * @var array
     */
    protected $aLogic;

    /**
     * Массив декораторов для каждой логики
     * @var array
     */
    protected $aDecorator;

    /**
     * Массив коллекций результатов каждой логики
     * @var array
     */
    protected $aCollectionResult;

    /**
     * Имя функции callback-а
     * @var string
     */
    protected $aCallback;

    protected $aFilesCode;

    protected $aFilesIDs;

    protected function __construct(\CBitrixComponent $oComponent = null) {
        if ($oComponent) {
            $this->oComponent = $oComponent;
        }

        $this->initVars();
        $this->initFilesCode();

        $this->initEntityParams();
    }

    protected function initFilesCode()
    {
        $this->aFilesCode = [
            "PREVIEW_PICTURE",
            "DETAIL_PICTURE",
            "MORE_PHOTO"
        ];
    }

    protected function initVars() {
        $this->oModel = new FCIBlockElement();
        $this->oCollectionResult = new Result();
        $this->sCallback = false;
        $this->aFilesIDs = [];
    }

    protected function getLogicResult($logic) {
        return $this->aCollectionResult[$logic];
    }

    protected function decorateElement($logic, $row) {
        foreach ($this->aDecorator[$logic] as $oDecorator) {
            $row = $oDecorator->decorateElement($row);
        }

        return $row;
    }

    public function setCallbackDecoratorFunction($aCallback) {
        $this->aCallback = $aCallback;
    }

    public function setCollectionResult($oCollection) {
        $this->oCollectionResult = $oCollection;
        return $this;
    }

    public function getModel() {
        return $this->oModel;
    }

    public function setModel($oModel) {
        $this->oModel = $oModel;
        return $this;
    }

    public function pushFiles($row) {
        foreach( $this->aFilesCode as $fileCode ) {
            if( isset($row[$fileCode]) && $row[$fileCode] > 0) {
                $this->aFilesIDs[] = $row[$fileCode];
            }
        }
    }

    protected function initEntityParams()
    {
        $this->initLogic();
        $this->initDecorator();
        $this->initCollectionResult();
        return $this;
    }

    abstract protected function initLogic();
    abstract protected function initDecorator();
    abstract protected function initCollectionResult();
    abstract protected function getResult();

}
