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
use Sebk\SmallLoggerBundle\Driver\Config\FileOutputConfig;

class FileOutput implements OutputInterface
{

    protected FileOutputConfig $outputConfig;

    /**
     * Set config
     * @param OutputConfigInterface $outputConfig
     * @return OutputInterface
     * @throws DriverConfigException
     */
    public function setConfig(OutputConfigInterface $outputConfig): OutputInterface
    {
        if (!$outputConfig instanceof FileOutputConfig) {
            throw new DriverConfigException('Config must be a \'' . FileOutputConfig::class . '\' instance');
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
        $f = fopen($this->outputConfig->getFilename(), 'a');
        fwrite($f, $message . "\n");
        fclose($f);

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