# small-logger-bundle
Symfony small logger

In reality, it is only a bridge between symfony and [small-logger](https://github.com/sebk69/small-logger).

Additionnaly, this package implement a symfony native http client for http output.

# Migrated

This lib has been migrated to [framagit](https://framagit.org/small) project.

A new composer package is available at https://packagist.org/packages/small/logger-bundle

Future commits will be done on framagit.

## Install

Use composer to install the package in your symfony project :
```bash
$ composer require sebk/small-logger-bundle
```

## Configure

First define service for SwitchLogicInterface :
```yaml
# config/service.yaml
services:
  _defaults:
    autowire: true      # Automatically injects dependencies in your services.
    autoconfigure: true # Automatically registers your services as commands, event subscribers, etc.

  App\:
    resource: '../src/'
    exclude:
      - '../src/DependencyInjection/'
      - '../src/Entity/'
      - '../src/Kernel.php'
      - '../src/Tests/'

  Sebk\SmallLogger\Contracts\SwitchLogicInterface:
    class: Sebk\SmallLogger\SwitchLogic\DefaultSwitchLogic
```

There is two default switches available in small-logger package :
- Sebk\SmallLogger\SwitchLogic\DefaultSwitchLogic -> log BasicLog to standard ouput
- Sebk\SmallLogger\SwitchLogic\CommonLogSwitchLoggic -> log CommonLog to file

See [small-logger documentation](https://github.com/sebk69/small-logger) to create your own switches, streams, formatters or logs

## Create shortcuts

Shortcuts are callback that simplify writing of logs by developer.

You are required to declare them in the contructor of a class. For example :
```php
namespace App\Log;

use Sebk\SmallLogger\Contracts\LogInterface;
use Sebk\SmallLogger\Log\BasicLog;
use Sebk\SmallLoggerBundle\Service\Logger;

class Shortcuts
{
    public function __construct(Logger $logger)
    {
        $logger->registerShortcut('info', function(Logger $logger, $message) {
            $logger->log(new BasicLog(new \DateTime(), LogInterface::ERR_LEVEL_INFO, $message));
        });
    }
}
```

And declare the Shortcuts class in config :
```yaml
# config/packages/small_logger.yaml
small_logger:
  shortcuts:
    - App\Log\Shortcuts
```

After declaring callback, just call it via logger :
```php
<?php

namespace App\Controller;

use Sebk\SmallLoggerBundle\Service\Logger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestLog extends AbstractController
{

    /**
     * @Route("/log")
     * @param Dao $daoFactory
     * @param Logger $logger
     * @return Response
     */
    public function logAction(Logger $logger)
    {
        $logger->info('This is a message');
        
        return new Response("That's done !");
    }

}
```
