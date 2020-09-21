<?php
/**
 * This file is a part of SebkSmallHttpLoggerBundle
 * Copyright 2020 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallHttpLoggerBundle\Logger;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class Logger
{
    /** @var array */
    protected $config;
    /** @var  */
    protected $httpClient;

    public function __construct(array $config, HttpClientInterface $httpClient)
    {
        $this->config = $config;
        $this->httpClient = $httpClient;
    }

    /**
     * Send a log to log server
     * @param AbstractLog $log
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function log(AbstractLog $log)
    {
        $this->httpClient->request(
            "POST",
            "http://".$this->config["http_logger_server"].":".$this->config["http_logger_port"],
            [
                "headers" => ["content-type" => "application/json"],
                "body" => json_encode($log),
            ]
        );
    }
}