<?php

namespace Francysk\Framework\Core\Fabrica;

if ( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true )
    die();

use Francysk\Framework\Core\Interfaces\Fabrica;

class Entity implements Fabrica
{
    private $oComponent;

    const ELEMENT = 1;
    const ELEMENTWITHPROP = 2;
    const SECTION = 3;
    const ELEMENTSECTION = 4;
    const ITEMS = 0;
    const USER = 6;
    const USERALLPROP = 7;
    const COMMENTS = 8;
    const SIMPLEPRODUCT = 9;
    const ELEMENTSSECTIONS = 10;

    public function __construct($oComponent = null) {
        $this->oComponent = $oComponent;
    }

    static public function initEntity($oComponent = null) {
        return new static($oComponent);
    }

    static public function getEntityByName() {
        return array(
          self::ITEMS => "Простой элемент",
          self::ELEMENT => "Обычный элемент",
          self::ELEMENTWITHPROP => "Элемент со всеми свойствами",
          self::SECTION => "Раздел",
          self::ELEMENTSECTION => "Элементы с разделами",
          self::USER => "Пользователь",
          self::USERALLPROP => "Пользователь со всеми пользовательскими свойствами",
          self::COMMENTS => "Комментарии",
          self::SIMPLEPRODUCT => "Простые товары",
          self::ELEMENTSSECTIONS => "Элементы со всеми привязками к разделам",
        );
    }

    public function getClass($iType) {
        switch ($iType) {
            case self::ITEMS :
                return new \Francysk\Framework\Entity\Base($this->oComponent);
            case self::ELEMENT :
                return new \Francysk\Framework\Entity\Element($this->oComponent);
            case self::ELEMENTWITHPROP :
                return new \Francysk\Framework\Entity\ElementWithProp($this->oComponent);
            case self::SECTION :
                return new \Francysk\Framework\Entity\Section($this->oComponent);
            case self::ELEMENTSECTION :
                return new \Francysk\Framework\Entity\ElementsSections($this->oComponent);
            case self::USER :
                return new \Francysk\Framework\Entity\User($this->oComponent);
            case self::USERALLPROP :
                return new \Francysk\Framework\Entity\UserAllProp($this->oComponent);
            case self::COMMENTS :
                return new \Francysk\Framework\Entity\Comments($this->oComponent);
            case self::SIMPLEPRODUCT :
                return new \Francysk\Framework\Entity\SimpleProduct($this->oComponent);
            case self::ELEMENTSSECTIONS :
                return new \Francysk\Framework\Entity\ElementSections($this->oComponent);
            default:
                return new \Francysk\Framework\Entity\Elements($this->oComponent);
        }
    }
}
