<?php

namespace Francysk\Framework\Core\Component;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Francysk\Framework\Core\Config\FieldsClassParams;

class Parameters
{

    const IBLOCK = 1;
    const SECTION = 2;
    const F_SYSTEM = 3;
    const F_ENTITY = 4;
    const F_CLASS = 5;
    const NAV_PARAMS = 6;
    const FILTER_REQUEST = 7;
    const IBLOCK_ELEMENT = 8;
    const SAVE_SET = 9;
    const SAVE_GET = 10;
    const PROPERTY = 11;
    const SORT = 12;

    private $args;
    private $currentValues;
    private $arComponentParameters;

    public function __construct($args)
    {
        $this->args = $args;
        $this->currentValues = array();
    }

    private function getIBlocksParams()
    {
        $this->getIBlockType();
        if (!empty($this->arComponentParameters["IBLOCK_TYPE"])) {
            $this->getIBlock();
        }
        if (!empty($this->arComponentParameters["IBLOCK_ID"])) {
            $this->getSections();
        }
    }

    private function getIBlockElements()
    {
        if (!empty($this->arComponentParameters["IBLOCK_ID"])) {
            $aElements = [];
            $dbl = \CIBlockElement::getList(["SORT" => "ASC"], ["ACTIVE" => "Y", "IBLOCK_ID" => $this->currentValues["IBLOCK_ID"]]);
            while ($ar = $dbl->fetch()) {
                $aElements[$ar["ID"]] = $ar["NAME"];
            }

            $this->arComponentParameters["ID"] = array(
                "PARENT" => "BASE",
                "NAME" => "Элементы",
                "TYPE" => "LIST",
                "VALUES" => $aElements,
            );
        }
    }

    private function getIBlockType()
    {
        $arTypesEx = \CIBlockParameters::GetIBlockTypes(Array("-" => " "));

        $this->arComponentParameters["IBLOCK_TYPE"] = array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("FRANCYSK_CORE_COMPONENT_PARAMETERS_TYPE_IBLOCK"),
            "TYPE" => "LIST",
            "VALUES" => $arTypesEx,
            "REFRESH" => "Y"
        );
    }

    private function getIBlock()
    {
        $arIBlocks = [[]];
        $db_iblock = \CIBlock::GetList(Array("SORT" => "ASC"), Array("TYPE" => ($this->currentValues["IBLOCK_TYPE"] != "-" ? $this->currentValues["IBLOCK_TYPE"] : "")));
        while ($arRes = $db_iblock->Fetch()) {
            $arIBlocks[$arRes["ID"]] = $arRes["NAME"] . "(" . $arRes["ID"] . ")";
        }

        $this->arComponentParameters["IBLOCK_ID"] = array(
            "PARENT" => "BASE",
            "NAME" => "Инфоблок",
            "TYPE" => "LIST",
            "VALUES" => $arIBlocks,
            "REFRESH" => "Y"
        );
    }

    private function getSections()
    {

        $this->arComponentParameters["GET_SECTION_BOOL"] = array(
            "PARENT" => "BASE",
            "NAME" => "Получить из раздела",
            "TYPE" => "CHECKBOX",
            "VALUES" => "N",
            "REFRESH" => "Y"
        );

        if ($this->currentValues["GET_SECTION_BOOL"]["VALUES"] == "Y") {
            unset($this->arComponentParameters["GET_SECTION_BOOL"]);

            $db_section = \CIBlockSection::getList(array("SORT" => "ASC"), array("IBLOCK_ID" => $this->currentValues["IBLOCK_ID"]));
            while ($arRes = $db_section->fetch()) {
                $arSections[$arRes["ID"]] = $arRes["NAME"] . " (" . $arRes["ID"] . ")";
            }

            $this->arComponentParameters["SECTION_ID"] = array(
                "PARENT" => "BASE",
                "NAME" => "Раздел",
                "TYPE" => "LIST",
                "VALUES" => $arSections,
                    //"REFRESH" => "Y"
            );
        }
    }

    private function getEntity()
    {
        $this->arComponentParameters[FieldsClassParams::ENTITY] = array(
            "PARENT" => "FRANCYSKWRAEMROWK",
            "NAME" => "Готовая сущность",
            "TYPE" => "LIST",
            "VALUES" => \Francysk\Framework\Core\Fabrica\Entity::getEntityByName()
        );
    }

    private function getClasses()
    {
        $this->arComponentParameters[FieldsClassParams::MODEL] = array(
            "PARENT" => "FRANCYSKWRAEMROWK",
            "NAME" => "Модель",
            "TYPE" => "LIST",
            "VALUES" => array(
                "Нет"
            )
        );

        $this->arComponentParameters[FieldsClassParams::DECORATOR] = array(
            "PARENT" => "FRANCYSKWRAEMROWK",
            "NAME" => "Декоратор",
            "TYPE" => "LIST",
            "VALUES" => array(
                "Нет"
            )
        );

        $this->arComponentParameters[FieldsClassParams::COLLECTION_RESULT] = array(
            "PARENT" => "FRANCYSKWRAEMROWK",
            "NAME" => "Коллекция",
            "TYPE" => "LIST",
            "VALUES" => array(
                "Нет"
            )
        );

        $this->arComponentParameters[FieldsClassParams::ENTITY] = array(
            "PARENT" => "FRANCYSKWRAEMROWK",
            "NAME" => "Сущность",
            "TYPE" => "LIST",
            "VALUES" => array(
            )
        );
    }

    private function getTypeFraemwork()
    {
        $this->arComponentParameters[FieldsClassParams::SYSTEM_FRAEMWORK] = array(
            "PARENT" => "FRANCYSKWRAEMROWK",
            "NAME" => "Тип работы",
            "TYPE" => "LIST",
            "VALUES" => array(
                "Нет",
                "Готовая сущность (ENTITY)",
                "Без сущность"
            ),
            "DEFAULT" => 0,
            "REFRESH" => "Y"
        );

        $bDecorator = false;

        if ($this->currentValues[FieldsClassParams::SYSTEM_FRAEMWORK] == 1) {
            $bDecorator = true;
            $this->getEntity();
        } elseif ($this->currentValues[FieldsClassParams::SYSTEM_FRAEMWORK] == 2) {
            $bDecorator = true;
            $this->getClasses();
        }

        if ($bDecorator) {
            $this->arComponentParameters[FieldsClassParams::FUNCTION_DECORATOR] = array(
                "PARENT" => "FRANCYSKWRAEMROWK",
                "NAME" => "Функция декорированя в компоненте",
                "TYPE" => "STRING",
                "MULTIPLE" => "Y",
                "VALUE" => ""
            );
        }
    }

    private function getNavParams()
    {
        $this->arComponentParameters[FieldsClassParams::NAV_COUNT] = array(
            "PARENT" => "NAVPARAMS",
            "NAME" => "Количество элементов на странице",
            "TYPE" => "STRING",
            "VALUE" => "",
        );
    }

    private function getFilterRequest()
    {
        $this->arComponentParameters[FieldsClassParams::REQUEST_FITLER_SECTION] = array(
            "PARENT" => "FRANCYSKFILTER",
            "NAME" => "Код переменой для раздела",
            "TYPE" => "STRING",
            "VALUE" => "",
        );

        $this->arComponentParameters[FieldsClassParams::REQUEST_FILTER_ELEMENT] = array(
            "PARENT" => "FRANCYSKFILTER",
            "NAME" => "Код переменной для элемента",
            "TYPE" => "STRING",
            "VALUE" => ""
        );
    }

    private function getSort()
    {
        $this->arComponentParameters["SORT_FIELD_1"] = array(
            "PARENT" => "BASE",
            "NAME" => "Сортировать по полю",
            "TYPE" => "LIST",
            "VALUES" => [
                "NAME" => "По названию",
                "SORT" => "Сортировка",
                "ID" => "ID-шнику",
                "ACTIVE_FROM" => "Дата начала активности",
            ]
        );

        $this->arComponentParameters["SORT_VALUE_1"] = array(
            "PARENT" => "BASE",
            "NAME" => "Сортировать по",
            "TYPE" => "LIST",
            "VALUES" => [
                "" => "Нет",
                "asc" => "По возрастанию",
                "desc" => "По убыванию",
            ]
        );

        $this->arComponentParameters["SORT_FIELD_2"] = array(
            "PARENT" => "BASE",
            "NAME" => "Сортировать по полю (вторая сортировка)",
            "TYPE" => "LIST",
            "VALUES" => [
                "NAME" => "По названию",
                "SORT" => "Сортировка",
                "ID" => "ID-шнику",
                "ACTIVE_FROM" => "Дата начала активности",
            ]
        );

        $this->arComponentParameters["SORT_VALUE_2"] = array(
            "PARENT" => "BASE",
            "NAME" => "Сортировать по полю (вторая сортировка)",
            "TYPE" => "LIST",
            "VALUES" => [
                "" => "Нет",
                "asc" => "По возрастанию",
                "desc" => "По убыванию",
            ]
        );
    }

    private function getProperty()
    {

    }

    private function setSaveParams()
    {
        $this->arComponentParameters[FieldsClassParams::SAVE_SET] = [
            "PARENT" => "BASE",
            "NAME" => "Имя индефикатора для сохранения",
            "TYPE" => "STRING",
            "VALUE" => "items",
        ];
    }

    private function getSaveParams()
    {
        $this->arComponentParameters[FieldsClassParams::SAVE_GET] = [
            "PARENT" => "BASE",
            "NAME" => "Имя индефикатора сохранненого значения",
            "TYPE" => "STRING",
            "VALUE" => "items",
        ];
    }

    private function paramsByArgs()
    {
        foreach ($this->args as $arg) {
            switch ($arg) {
                case self::IBLOCK :
                    $this->getIBlocksParams();
                    break;
                case self::IBLOCK_ELEMENT :
                    $this->getIBlockElements();
                    break;
                case self::F_SYSTEM :
                    $this->getTypeFraemwork();
                    break;
                case self::NAV_PARAMS :
                    $this->getNavParams();
                    break;
                case self::FILTER_REQUEST :
                    $this->getFilterRequest();
                    break;
                case self::SAVE_SET :
                    $this->setSaveParams();
                    break;
                case self::SAVE_GET :
                    $this->getSaveParams();
                    break;
                case self::PROPERTY :
                    $this->getProperty();
                    break;
                case self::SORT :
                    $this->getSort();
                    break;
            }
        }
    }

    public function getParameters()
    {
        $this->paramsByArgs();

        return $this->arComponentParameters;
    }

    public function getGroups()
    {
        return array(
            "NAVPARAMS" => array(
                "NAME" => "Настройка постраничной навигации",
            ),
            "FRANCYSKWRAEMROWK" => array(
                "NAME" => "Утилиты Francysk"
            ),
            "FRANCYSKFILTER" => array(
                "NAME" => "Параметры фильтра"
            )
        );
    }

    public function setCurrentValues($arCurrentValues)
    {
        $this->currentValues = $arCurrentValues;
    }

}
