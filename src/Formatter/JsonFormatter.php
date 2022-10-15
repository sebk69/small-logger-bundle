<?php

/**
 * This file is a part of SebkSmallLoggerBundle
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLoggerBundle\Formatter;

use Sebk\SmallLoggerBundle\Contracts\FormatterInterface;
use Sebk\SmallLoggerBundle\Contracts\LogInterface;
use Sebk\SmallLoggerBundle\Formatter\Exception\FormatterException;
use Sebk\SmallLoggerBundle\Log\BasicLog;

class JsonFormatter implements FormatterInterface
{

    /**
     * Format BasicLog log to standard string
     * @param BasicLog $log
     * @return string
     * @throws FormatterException
     */
    public function format(LogInterface $log): mixed
    {

        if (!$log instanceof \JsonSerializable) {
            throw new FormatterException(static::class . ' can format only ' . LogInterface::class . ' class that implements ' . \JsonSerializable::class);
        }

        return json_encode($log);
    }

}