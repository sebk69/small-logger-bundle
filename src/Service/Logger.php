<?php
/**
 * This file is a part of small-logger-bundle
 * Copyright 2020 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallLoggerBundle\Service;

use Sebk\SmallLogger\Contracts\LogInterface;
use Sebk\SmallLogger\Contracts\SwitchLogicInterface;
use Sebk\SmallLogger\Output\OutputFactory;
use Sebk\SmallLoggerBundle\Contracts\ShortcutInterface;
use Sebk\SmallLoggerBundle\Output\SymfonyHttpOutput;

class Logger
{
    /** @var \Closure[] */
    protected array $shortcuts = [];

    public function __construct(protected SwitchLogicInterface $switchLogic, array $shortcuts)
    {
        // Add symfony output to OutputFactory
        OutputFactory::addOutput('http', SymfonyHttpOutput::class);

        // Add shortcuts
        foreach ($shortcuts as $shortcutsClass) {
            new $shortcutsClass($this);
        }
    }

    /**
     * Write log
     * @param LogInterface $log
     * @param array $data
     * @return $this
     */
    public function log(LogInterface $log, array $data = []): Logger
    {
        $this->switchLogic->getStream($log, $data)->write($log);
        
        return $this;
    }

    /**
     * Register a shortcut
     * For example after calling :
     * $container->get('logger')->registerShortcut('info', function(Logger $logger, string $message) {
     *   $logger->log(new BassicLog(new \DateTime, LogInterface::ERR_LEVEL_INFO, $message));
     * }
     * All application can use shortcut :
     * $container->get('logger')->info('This is an info message');
     * 
     * @param string $name
     * @param Closure $closure
     * @return $this
     */
    public function registerShortcut(string $name, \Closure $closure): Logger {
        $this->shortcuts[$name] = $closure;
        
        return $this;
    }

    /**
     * Call shortcuts
     * @param $name
     * @param $arguments
     * @return $this
     * @throws \Exception
     */
    public function __call($name, $arguments): Logger {
        if (array_key_exists($name, $this->shortcuts)) {
            $closure = $this->shortcuts[$name];
            $closure($this, ...$arguments);
            
            return $this;
        }

        throw new \Exception("Method $name doesn't exists in class Logger. Do you have forget to register shortcut ?");
    }

}
