<?php

namespace Sebk\SmallLoggerBundle\Output;

use Sebk\SmallLogger\Contracts\OutputConfigInterface;
use Sebk\SmallLogger\Contracts\OutputInterface;
use Sebk\SmallLogger\Output\Config\HttpConfig;
use Sebk\SmallLogger\Output\Exception\OutputConfigException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\ScopingHttpClient;

class SymfonyHttpOutput implements OutputInterface
{

    protected HttpConfig $outputConfig;

    /**
     * Return true if require dependencies are installed
     * @return bool
     */
    public static function checkCompatibility(): bool
    {
        return class_exists(HttpClient::class);
    }

    /**
     * Set config
     * @param OutputConfigInterface $outputConfig
     * @return OutputInterface
     * @throws OutputConfigException
     */
    public function setConfig(OutputConfigInterface $outputConfig): OutputInterface
    {
        if (!$outputConfig instanceof HttpConfig) {
            throw new OutputConfigException('Config must be a \'' . HttpConfig::class . '\' instance');
        }

        $this->outputConfig = $outputConfig;

        return $this;
    }

    /**
     * Create client
     * @return ScopingHttpClient
     */
    protected function getClient(): ScopingHttpClient
    {
        return HttpClient::createForBaseUri(($this->outputConfig->isSsl() ? 'https://' : 'http://') .
            $this->outputConfig->getHost() .
            ($this->outputConfig->getPort() != 80 ? ':' . $this->outputConfig->getPort() : '')
        );
    }

    /**
     * Write message to http service
     * @param string $message
     * @return OutputInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function write(string $message): OutputInterface
    {
        $method = $this->outputConfig->getMethod();
        $this->getClient()->request(strtoupper($method), $this->outputConfig->getUri(), [
            'body' => $message,
            'headers' => $this->outputConfig->getHeaders(),
        ]);

        return $this;
    }

}