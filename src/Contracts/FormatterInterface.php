<?php

/**
 * This file is a part of SebkSmallLoggerBundle
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLoggerBundle\Contracts;

use Sebk\SmallLoggerBundle\Contracts\LogInterface;

interface FormatterInterface
{
    public function format(LogInterface $log): mixed;
}