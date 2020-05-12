<?php

/**
 * @author Francysk Interactive Studio
 * @email support@francysk.com
 */

namespace Francysk\Framework\Object;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Francysk\Framework\Core\AbstractClass\FObject;

class CurrencyLang extends FObject
{
    private $aCurrency;

    public function __construct($iIBlock = 0)
    {
        $this->aCurrency = [];                

        parent::__construct($iIBlock);
    }   

    protected function initModel()
    {
        $this->oModel = \Bitrix\Currency\CurrencyLangTable::getList([
            "filter" => [
                "LID" => $this->iIBlock,
            ]
        ]);
    }

    public function get(String $sCode)
    {
        return $this->aCurrency[$sCode];
    }

    protected function getData(): array
    {
        $aResult = [];
        while ($row = $this->oModel->fetch() ) {    
            $aResult[$row["CURRENCY"]] = $row;
        }

        return $aResult;
    }

    protected function initParams($aResult)
    {
        $this->aCurrency = $aResult;
    }
    
    /**
     * Возвращает ID кэша
     * @return String
     */
    protected function getCacheID(): String
    {
        return md5("OBJECTS_CURRENCY_LANG" . $this->iIBlock);
    }

}
