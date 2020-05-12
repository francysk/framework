<?php

namespace Francysk\Framework\Core\AbstractClass;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

abstract class Model
{
    /**
     * Массив для сортировки выборки из БД
     * @var array
     */
    protected $aOrder;
    
    /**
     * Массив фильтра для получения выборки
     * @var array
     */
    protected $aFilter;
    
    /**
     * Массив для подстраничной навигации
     * @var array
     */
    protected $aNavParams;
    
    /**
     * Массив для указанния select-ов
     * @var array
     */
    protected $aSelect;
    
    /**
     * Объект результата из БД
     * @var CDBResult
     */
    protected $oBDResult;

    public function __construct(array $arParams = array()) {
        $this->initParams($arParams);
    }

    /**
     * Инициализация осовных переменных
     * 
     * @param array $arParams  - массив параметров из компонента
     */
    protected function initParams(array $arParams) {
        $this->initOrder($arParams)
                ->initFilter($arParams)
                ->initNavParams($arParams)
                ->initSelect($arParams);
    }

    /**
     * Инициализация сортировки
     * 
     * @param array $arParams - массив параметров из компонента
     * @return \Francysk\Framework\Core\AbstractClass\Model
     */
    protected function initOrder(array $arParams): Model {
        $this->aOrder = array();
        return $this;
    }

    /**
     * Инициализация фильтра
     * 
     * @param array $arParams - массив параметров из компонента
     * @return \Francysk\Framework\Core\AbstractClass\Model
     */
    protected function initFilter(array $arParams): Model {
        $this->aFilter = array();
        return $this;
    }

    /**
     * Инициализация постраничной навигации
     * 
     * @param array $arParams - массив параметров из компонента
     * @return \Francysk\Framework\Core\AbstractClass\Model
     */
    protected function initNavParams(array $arParams): Model {
        $this->aNavParams = false;
        return $this;
    }
    
    /**
     * Инициализация выборки
     * 
     * @param array $arParams - массив параметров из компонента
     * @return \Francysk\Framework\Core\AbstractClass\Model
     */
    protected function initSelect(array $arParams): Model {
        $this->aSelect = array();
        return $this;
    }

    /**
     * Переписывает массив сортировки
     * 
     * @param array $aOrder - массив сортировки
     * @return \Francysk\Framework\Core\AbstractClass\Model
     */
    public function setOrder(array $aOrder): Model {
        if (is_array($aOrder)) {
            $this->aOrder = $aOrder;
        }

        return $this;
    }

    /**
     * Дополняет параметрами массив фильтра
     * 
     * @param array $aFilter
     * @return \Francysk\Framework\Core\AbstractClass\Model
     */
    public function addFilter($aFilter) {
        if (is_array($aFilter)) {
            $this->aFilter = array_merge($this->aFilter, $aFilter);
        }

        return $this;
    }
    
    /**
     * Переписывает массив фильтра
     * 
     * @param array $aFilter
     * @return \Francysk\Framework\Core\AbstractClass\Model
     */
    public function setFilter($aFilter) {
        if (is_array($aFilter)) {
            $this->aFilter = $aFilter;
        }

        return $this;
    }
    
    /**
     * Дополняет параметрами массив постраничной навигации
     * 
     * @param array $aNavParams
     * @return \Francysk\Framework\Core\AbstractClass\Model
     */
    public function addNavParams($aNavParams) {
        if(is_array($aNavParams)) {
            $this->aNavParams = array_merge($this->aNavParams, $aNavParams);
        }
        
        return $this;
    }
    
    /**
     * Переписывает массив постраничной навигации
     * 
     * @param array $aNavParams
     * @return \Francysk\Framework\Core\AbstractClass\Model
     */
    public function setNavParams($aNavParams) {
        $this->aNavParams = $aNavParams;
        return $this;
    }

    /**
     * Вовзращает строки из БД
     * 
     * @return array
     */
    public function fetch() {
        return $this->oBDResult->fetch(true, false);
    }

    /**
     * Вовзращает объект выборки из БД
     * 
     * @return object CDBResult
     */
    public function getMetaData() {
        return $this->oBDResult;
    }
    
    abstract function execute();
}
