<?php

namespace Francysk\Framework\Core\Component;

if ( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true )
    die();

use Francysk\Framework\Core\Config\FieldsClassParams;

class ParamsValue
{
    private $arParams;

    private $aModel = null;

    public function __construct($arParams) {
        $this->arParams = $arParams;
        $this->aModel = [];
    }

    public function makeEntity() {
        return $this->arParams[FieldsClassParams::SYSTEM_FRAEMWORK] == 1;
    }

    public function getDecorator() {
        return $this->arParams[FieldsClassParams::DECORATOR];
    }

    public function getModel() {
        return $this->arParams[FieldsClassParams::MODEL];
    }

    public function getEntity() {
        return $this->arParams[FieldsClassParams::ENTITY];
    }

    public function getCollectionResult() {
        return $this->arParams[FieldsClassParams::COLLECTION_RESULT];
    }

    public function getCallabackDecoratorFunction() {
        return $this->arParams[FieldsClassParams::FUNCTION_DECORATOR];
    }

    public function getNavParams() {
        $iPage = FRANCYSK_FRAMEWORK_CATALOG_COUNT;

        $iNumPage = isset($_REQUEST["PAGEN_1"]) ? (int)$_REQUEST["PAGEN_1"] : 1;

        if( $this->arParams[FieldsClassParams::NAV_COUNT] != '' ) {
            $iPage = $this->arParams[FieldsClassParams::NAV_COUNT];
        }
        return [
            "nPageSize" => $iPage,
            "iNumPage" => $iNumPage,
        ];
    }

    public function getModelOrder() {
        $result = $GLOBALS["arrSort"] ?? ["SORT" => "ASC"];

        if( $this->arParams["SORT_VALUE_1"] != '' ) {
            $result = [];
            $result[$this->arParams["SORT_FIELD_1"]] = $this->arParams["SORT_VALUE_1"];
        }

        if( $this->arParams["SORT_VALUE_2"] != '' ) {
            $result[$this->arParams["SORT_FIELD_2"]] = $this->arParams["SORT_VALUE_2"];
        }

        return $result;
    }

    public function initModelFilter() {
        if( !\Francysk\Framework\Object\User::isModerate() ) {
            $this->aModel["ACTIVE"] = "Y";
        }

        $this->getUrlModelFilter();
        $this->getSmartModelFilter();
        $this->getParametersFilter();
        $this->getParametersUserFilter();

        $params = array("IBLOCK_ID", "SECTION_ID", "SECTION_CODE", "CODE");

        foreach( $params as $code ) {
            if( isset($this->arParams[$code]) ) {
                $this->aModel[$code] = $this->arParams[$code];
            }
        }

        return $this->aModel;
    }

    public function getModelFilter() {
        if( !$this->aModel ) {
            $this->initModelFilter();
        }

        return $this->aModel;
    }

    private function getParametersUserFilter() {
        if( isset($this->arParams["USER_ID"]) ) {
            if( is_array($this->arParams["USER_ID"]) ) {
                $this->aModel["@ID"] = implode(", ", $this->arParams["USER_ID"]);
            } else {
                $this->aModel["ID"] = $this->arParams["USER_ID"];
            }
        }
    }

    private function getParametersFilter() {
        if( $this->arParams["PROPERTIES"] ) {
            foreach( $this->arParams["PROPERTIES"] as $code ) {
                $this->aModel["PROPERTY_".$code] = $this->arParams["PROPERTY_".$code."_VALUE"];
            }
        }
    }

    private function getUrlModelFilter() {
        if( isset($_REQUEST["SECTION_CODE"]) && !isset($_REQUEST["ELEMENT_CODE"]) ) {
//            $oRequest = Request::createFromGlobals();
//
//            $sSection = $oRequest->query->filter("SECTION_CODE");
//            $aSection = \Bitrix\Iblock\SectionTable::getList(["filter" => ["CODE" => $sSection, "IBLOCK_ID" => $this->arParams["IBLOCK_ID"]]])->fetch();

            $aSection  = \Francysk\Framework\Object\Structure::getInstance($this->arParams["IBLOCK_ID"])->getSectionByCode($_REQUEST["SECTION_CODE"]);

            $this->aModel["SECTION_ID"] = $aSection["ID"];
            $this->aModel["INCLUDE_SUBSECTIONS"] = "Y";
        } elseif ( isset($_REQUEST["ELEMENCT_CODE"]) ) {
            $this->aModel["CODE"] = $sSection = $oRequest->query->filter("ELEMENCT_CODE");
        } elseif( isset($_REQUEST["filter"]) ) {
            $this->aModel = array_merge($this->aModel, $_REQUEST["filter"]);
        }
    }

    public function getSmartModelFilter() {

        if( isset($GLOBALS["arrFilter"]) ) {
            foreach($GLOBALS["arrFilter"] as $code => $val ) {
                $this->aModel[$code] = $val;
            }
            //$this->aModel = array_merge($this->aModel, $GLOBALS["arrFilter"]);
        }
    }
}
