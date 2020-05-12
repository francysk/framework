<?php

namespace Francysk\Framework\Collection;

use Francysk\Framework\Core\AbstractClass;

class Result extends AbstractClass\Result
{
    public function add($aItem) {
        $this->result[] = $aItem;
    }
}
