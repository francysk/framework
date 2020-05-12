<?php

namespace Francysk\Framework\Decorator;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Francysk\Framework\Object\CurrencyLang;
use Francysk\Framework\Object\Measure;

class Product
{    
    public function __construct()
    {        
    }

    public function decorateElement(array $row): array
    {
        $row["PRICE_FORMAT"] = number_format($row["PRICE"], 2, ".", " ");
        
        $currency = CurrencyLang::getInstance(LANGUAGE_ID)->get($row["CURRENCY"]);
        $mesuare = Measure::getInstance()->get($row["CATALOG_PRICE_PRODUCT_MEASURE"]);
        
        $sCurrency = str_ireplace("#", "", $currency["FORMAT_STRING"]);
        $sMesuare = $mesuare["SYMBOL"];
        
        $row["MESUARE"] = sprintf("%s/%s", $sCurrency, $sMesuare);
        
        return $row;
    }
}
