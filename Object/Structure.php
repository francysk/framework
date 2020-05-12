<?php

/**
 * @author Francysk Interactive Studio
 * @email support@francysk.com
 */

namespace Francysk\Framework\Object;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

\CBitrixComponent::includeComponentClass("francysk:framework.object.structure.params");

use Francysk\Framework\Core\AbstractClass\FObject;

class Structure extends FObject
{

    // массив структуры разделов
    private $aTree;
    // массив [символьный код разделай] - [id раздела]
    private $aHashByCodeCollection;
    // массив [id раздела] - [символьный код разделай]
    private $aHashByIDCollection;
    private $aSectionCollection;

    public function __construct($iIBlock = 0)
    {
        $this->aTree = [];
        $this->aHashByCodeCollection = [];
        $this->aHashByIDCollection = [];

        parent::__construct($iIBlock);
    }

    public function getSections()
    {
        return $this->aSectionCollection;
    }

    public function getSectionByCode($sCode): array
    {
        $iID = $this->aHashByCodeCollection[$sCode];
        return $this->aSectionCollection[$iID] ?? [];
    }

    public function getSectionByID($iID): array
    {
        return $this->aSectionCollection[$iID] ?? [];
    }

    public function getPathNameByID($iID): array
    {
        $aSection = $this->aSectionCollection[$iID];

        $result[(int)($aSection["DEPTH_LEVEL"]-1)] = $aSection["NAME"];
        if( $aSection["DEPTH_LEVEL"] > 1 ) {
            $iDepth = $aSection["DEPTH_LEVEL"];
            for( $i = $iDepth; $i > 1; --$i ) {
                $aSection = $this->aSectionCollection[$aSection["IBLOCK_SECTION_ID"]];
                $result[(int)($aSection["DEPTH_LEVEL"]-1)] = $aSection["NAME"];
            }
        }
        ksort($result);
        return $result;
    }

    protected function initModel()
    {
        // до лучших времен
        //$oEntity = \Bitrix\Iblock\Model\Section::compileEntityByIblock($this->iIBlock);

        $this->oModel = \CIBlockSection::getList(
                            \FrameworkObjectStructureParams::getOrder(),
                            \FrameworkObjectStructureParams::getFilter($this->iIBlock),
                            false,
                            \FrameworkObjectStructureParams::getSelect()
        );
    }

    public function getTree(): array
    {
        return $this->aTree;
    }

    protected function getData(): array
    {
        $aResult = [];
        while ($row = $this->oModel->getNext(true, false)) {

            foreach( \FrameworkObjectStructureParams::getFilesCode() as $sCode ) {
                if( isset($row[$sCode]) ) {
                    // todo
                    $row[$sCode."_SRC"] = \CFile::getPath($row[$sCode]);
                }
            }

            $aResult[] = $row;
        }

        return $aResult;
    }

    protected function initParams($aResult)
    {
        foreach ($aResult as $aItem) {
            if ($aItem["DEPTH_LEVEL"] == 1) {
                $this->aTree[0][$aItem["ID"]] = $aItem;
            } elseif ($aItem["IBLOCK_SECTION_ID"] > 0) {
                $this->aTree[$aItem["IBLOCK_SECTION_ID"]][$aItem["ID"]] = $aItem;
            }

            $this->aHashByCodeCollection[$aItem["CODE"]] = $aItem["ID"];
            $this->aHashByIDCollection[$aItem["ID"]] = $aItem["CODE"];
            $this->aSectionCollection[$aItem["ID"]] = $aItem;
        }
    }

}
