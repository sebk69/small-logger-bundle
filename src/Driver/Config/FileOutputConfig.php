<?php

/**
 * This file is a part of SebkSmallLoggerBundle
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLoggerBundle\Driver\Config;

use Sebk\SmallLoggerBundle\Contracts\OutputConfigInterface;

class FileOutputConfig implements OutputConfigInterface
{

    public function __construct(protected string $filename) {}

    /**
     * Get filename
     * @return string
     */
    public function getFilename(): string
    {
        return $this->getFilename();
    }
}