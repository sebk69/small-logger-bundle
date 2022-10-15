<?php

/**
 * This file is a part of SebkSmallLoggerBundle
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLoggerBundle\Driver;

use Sebk\SmallLoggerBundle\Driver\Exception\DriverConfigException;
use Sebk\SmallLoggerBundle\Contracts\OutputConfigInterface;
use Sebk\SmallLoggerBundle\Contracts\OutputInterface;
use Sebk\SmallLoggerBundle\Driver\Config\StdOutputConfig;

class StdOutput implements OutputInterface
{

    protected StdOutputConfig $outputConfig;

    /**
     * Set config
     * @param OutputConfigInterface $outputConfig
     * @return OutputInterface
     * @throws DriverConfigException
     */
    public function setConfig(OutputConfigInterface $outputConfig): OutputInterface
    {
        if (!$outputConfig instanceof StdOutputConfig) {
            throw new DriverConfigException('Config must be a \'' . StdOutputConfig::class . '\' instance');
        }

        $this->outputConfig = $outputConfig;

        return $this;
    }

    /**
     * Write message in file
     * @param string $message
     * @return $this
     */
    public function write(string $message): FileOutput
    {
        fwrite($this->outputConfig->getOutput(), $message . "\n");

        return $this;
    }

    /**
     * No dependencies
     * @return bool
     */
    public static function checkCompatibility(): bool
    {
        return true;
    }

}