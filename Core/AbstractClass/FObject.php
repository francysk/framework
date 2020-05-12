<?php

namespace Francysk\Framework\Core\AbstractClass;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

abstract class FObject
{

    static protected $instance = null;
    // объект модели
    protected $oModel;
    // ИД инфоблока
    protected $iIBlock;

    public function __construct($iIBlock = 0)
    {
        $this->iIBlock = $iIBlock;

        // выборка данных из базы
        $this->initModel();
        // получение данных из базы и кеширование
        $this->initialize();
    }

    protected function initialize()
    {
        $oCache = new \CPHPCache;

        if ($oCache->InitCache($this->getTimeCache(), $this->getCacheID(), $this->getPath())) {
            $result = $oCache->GetVars();
        } elseif ($oCache->StartDataCache($this->getTimeCache(), $this->getCacheID(), $this->getPath())) {
            $result = $this->getData();

            $oCache->endDataCache($result);
        }

        $this->initParams($result);
    }

    /**
     * Возвращает время сколько будет длиться кэш
     * @return int
     */
    protected function getTimeCache(): int
    {
        return 30 * 60;
    }

    /**
     * Возвращает ID кэша
     * @return String
     */
    protected function getCacheID(): String
    {
        return md5("OBJECTS" . $this->iIBlock);
    }

    /**
     * папка кэша
     * @return String
     */
    protected function getPath(): String
    {
        return "/object" . $this->iIBlock;
    }

    static public function getInstance($iIBlock = 0): FObject
    {

        if (static::$instance[$iIBlock] == null) {
            static::$instance[$iIBlock] = new static($iIBlock);
        }

        return static::$instance[$iIBlock];
    }

    abstract protected function initModel();

    abstract protected function getData();

    abstract protected function initParams($result);
}
