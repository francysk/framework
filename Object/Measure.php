<?php

/**
 * @author Francysk Interactive Studio
 * @email support@francysk.com
 */

namespace Francysk\Framework\Object;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Francysk\Framework\Core\AbstractClass\FObject;

class Measure extends FObject
{

    private $aMeasure;

    public function __construct($iIBlock = 0)
    {
        $this->aMeasure = [];                

        parent::__construct($iIBlock);
    }   

    protected function initModel()
    {        
        $this->oModel = \Bitrix\Catalog\MeasureTable::getList();
    }

    public function get(int $iID)
    {
        return $this->aMeasure[$iID];
    }

    protected function getData(): array
    {
        $aResult = [];
        while ($row = $this->oModel->fetch() ) {    
            $aResult[$row["ID"]] = $row;
        }

        return $aResult;
    }

    protected function initParams($aResult)
    {
        $this->aMeasure = $aResult;
    }
    
    /**
     * Возвращает ID кэша
     * @return String
     */
    protected function getCacheID(): String
    {
        return md5("OBJECTS_MEASURE" . $this->iIBlock);
    }

}
