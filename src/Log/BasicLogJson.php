<?php

/**
 * This file is a part of SebkSmallLoggerBundle
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLoggerBundle\Log;

class BasicLogJson extends BasicLog implements \JsonSerializable
{

    public function jsonSerialize()
    {
        return [
            'date' => $this->getDateTime(),
            'level' => $this->getLevel(),
            'message' => $this->getMessage(),
        ];
    }

}