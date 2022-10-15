<?php
/**
 * This file is a part of SebkSmallHttpLoggerBundle
 * Copyright 2020 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallHttpLoggerBundle\Logger;

use App\Log\AuthFlowLog;
use Sebk\SmallSwoolePatterns\Observable\Observable;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
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
        if (class_exists(\Co\Http\Client::class)) {
            $this->swooleLog($log);
            return;
        }

        $this->httpClient->request(
            "POST",
            "http://".$this->config["http_logger_server"].":".$this->config["http_logger_port"],
            [
                "headers" => ["content-type" => "application/json"],
                "body" => json_encode($log),
            ]
        );
    }

    /**
     * Send a log to log server async
     * @param AbstractLog $log
     * @return void
     * @throws \Sebk\SmallSwoolePatterns\Observable\ObservableAlreadyRanException
     */
    public function swooleLog(AbstractLog $log)
    {
	$server = $this->config["http_logger_server"];
	$port = $this->config["http_logger_port"];
        $func = function($log) use($server, $port) {
            // Get access token infos
            $client = new \Co\Http\Client($server, $port);
            $client->setHeaders(["content-type" => "application/json"]);
            $client->post('/', json_encode($log));
            $client->close();
	};
	(new Observable($func))->run($log);
    }
}
