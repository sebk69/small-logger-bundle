<?php

/**
 * This file is a part of SebkSmallLoggerBundle
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLoggerBundle\Contracts;

interface OutputInterface
{

    /**
     * Return true if require dependencies are installed
     * @return bool
     */
    public static function checkCompatibility(): bool;

    /**
     * Set output config
     * @param OutputConfigInterface $outputConfig
     * @return mixed
     */
    public function setConfig(OutputConfigInterface $outputConfig): OutputInterface;

    /**
     * Write message to output
     * @param mixed $message
     * @return OutputInterface
     */
    public function write(string $message): OutputInterface;

}