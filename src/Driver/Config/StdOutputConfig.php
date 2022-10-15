<?php

/**
 * This file is a part of SebkSmallLoggerBundle
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLoggerBundle\Driver\Config;

use Sebk\SmallLoggerBundle\Contracts\DriverConfigException;
use Sebk\SmallLoggerBundle\Contracts\OutputConfigInterface;

class StdOutputConfig implements OutputConfigInterface
{

    public function __construct(protected string $output)
    {
        if (!in_array($this->output, [STDOUT, STDERR])) {
            throw new DriverConfigException('The output parameter must be \'STDOUT\' or \'STDERR\'');
        }
    }

    public function getOutput(): string
    {
        return $this->output;
    }

}