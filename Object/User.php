<?php

/**
 * @author Francysk Interactive Studio
 * @email support@francysk.com
 */

namespace Francysk\Framework\Object;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

class User
{
    static public function isModerate(): bool
    {
        $iUserID = \CUser::getID();

        if( in_array($iUserID,[1,7,6]) ) {
            return true;
        }

        return false;
    }
}
