<?php

/**
 * This file is a part of SebkSmallLoggerBundle
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLoggerBundle\Contracts;

interface SwitchInterface
{

    /**
     * Return stream from log to write and optional data
     * @param LogInterface $log
     * @param array $data
     * @return StreamInterface
     */
    public function getStream(LogInterface $log, array $data = []): StreamInterface;

}