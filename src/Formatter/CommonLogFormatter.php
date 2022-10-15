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
use Sebk\SmallLoggerBundle\Log\CommonLog;

class CommonLogFormatter implements FormatterInterface
{

    /**
     * @param CommonLog $log
     * @return string
     * @throws FormatterException
     */
    public function format(\Sebk\SmallLoggerBundle\Contracts\LogInterface $log): mixed
    {
        if (!$log instanceof CommonLog) {
            throw new FormatterException(static::class . ' can format only ' . LogInterface::class . ' class that implements ' . CommonLog::class);
        }

        return $log->getIp() . ' - ' . $log->getUserId() . ' [' . strtotime('%d/%b/%Y:%H:%M:%S %z', $log->getDateTime()->getTimestamp()) .
            '] ' . $log->getMethod() . ' ' . $log->getUri() . ' ' . $log->getHttpProtocol() . ' ' . $log->getHttpStatus() . ' ' . $log->getSizeInBytes();
    }

}