<?php

namespace src\Driver;

use Sebk\SmallLoggerBundle\Contracts\OutputConfigInterface;
use Sebk\SmallLoggerBundle\Contracts\OutputInterface;
use Sebk\SmallLoggerBundle\Driver\Exception\DriverException;
use Sebk\SmallLoggerBundle\Driver\FileOutput;
use Sebk\SmallLoggerBundle\Driver\GuzzleHttpOutput;
use Sebk\SmallLoggerBundle\Driver\StdOutput;
use Sebk\SmallLoggerBundle\Driver\SwooleHttpOutput;

class DriverFactory
{

    /**
     * List of driver classes by type ordered by priority
     */
    protected array $driversByType = [
        'std' => [StdOutput::class],
        'file' => [FileOutput::class],
        'http' => [SwooleHttpOutput::class, GuzzleHttpOutput::class]
    ];

    /**
     * Add a driver class
     * @param string $type
     * @param string $class
     * @return $this
     * @throws DriverException
     */
    public function addDriver(string $type, string $class): DriverFactory
    {
        if (!class_exists($class)) {
            throw new DriverException('Driver class ' . $class . ' does not exists !');
        }

        if (!class_implements($class)) {
            throw new DriverException('Driver class must implements ' . OutputInterface::class);
        }

        if (!in_array($type, $this->driversByType)) {
            $this->driversByType[$type] = [];
        }

        $this->driversByType[$type] = $class;

        return $this;
    }

    /**
     * Get a driver object
     * @param string $type
     * @param OutputConfigInterface $config
     * @return OutputInterface
     * @throws DriverException
     */
    public function get(string $type, OutputConfigInterface $config): OutputInterface
    {
        if (!in_array($type, $this->driversByType)) {
            throw new DriverException('There is no log driver for type \'' . $type . '\'');
        }

        foreach ($this->driversByType[$type] as $driverClass) {
            try {
                $driver = new $driverClass();
                if ($driver->checkCompatibility()) {
                    return $driver->setConfig($config);
                }
            } catch (\Exception $e) {}
        }

        throw new DriverException('Can\'t get compatible driver for ' . $type . ' with this config');
    }

}