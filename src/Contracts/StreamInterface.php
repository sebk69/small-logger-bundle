<?php

/**
 * This file is a part of SebkSmallLoggerBundle
 * Copyright 2020-2022- - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLoggerBundle\Contracts;

use Symfony\Component\Console\Output\OutputInterface;

interface StreamInterface
{

    const ALL_LEVELS = 'ALL_LEVELS';

    /**
     * Write to output
     * @param LogInterface $log
     * @return StreamInterface
     */
    public function write(LogInterface $log): StreamInterface;

    /**
     * Set log formatter
     * @param FormatterInterface $formatter
     * @return StreamInterface
     */
    public function setFormatter(FormatterInterface $formatter): StreamInterface;

    /**
     * Set stream output
     * @param OutputInterface $output
     * @return StreamInterface
     */
    public function setOutputFor(OutputInterface $output): StreamInterface;
}