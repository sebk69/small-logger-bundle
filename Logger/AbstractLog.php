<?php
/**
 * This file is a part of SebkSmallHttpLoggerBundle
 * Copyright 2020 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallHttpLoggerBundle\Logger;

abstract class AbstractLog implements \JsonSerializable
{
    const LEVEL_INFO = "info";
    const LEVEL_ERROR = "error";
    const LEVEL_FATAL = "fatal";

    /** @var string */
    protected $level = self::LEVEL_INFO;
    /** @var string */
    protected $message;
    /** @var \DateTime */
    protected $timestamp;

    /**
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param string $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp()
    {
        if($this->timestamp === null) {
            $this->timestamp = new \DateTime();
        }

        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function getUTCTimestamp()
    {
        return $this->getTimestamp()->format("c");
    }

    public function toArray(): array
    {
        return [
            'date' => $this->getUTCTimestamp(),
            'level' => $this->level,
            'message' => $this->message,
        ];
    }
    
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

}