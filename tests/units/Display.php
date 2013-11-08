<?php

namespace Profile\tests\units;

require_once 'vendor/autoload.php';

use mageekguy\atoum;
use Profile;

class Display extends atoum\test
{
    public function testDecorator()
    {
        $display = new Profile\Display();
        $this->object($display->getDecorator())
            ->isInstanceOf('\Profile\Decorators\Cli')
            ->when($display->setDecorator('Html'))
            ->then()->object($display->getDecorator())->isInstanceOf('\Profile\Decorators\Html')
        ;
    }

    public function testProfileActive()
    {
        $mockActive = new \mock\Profile\Bench\State\Active;

        $display = new Profile\Display();

        $this->object($decorator = $display->getDecorator())
            ->isInstanceOf('\Profile\Decorators\Cli')
            ->when($decorator->setData($mockActive))
            ->mock($mockActive)
                ->call('getStatistics')
                ->once()
            ->when($this->calling($mockActive)->getStatistics = array (
                            'HelloWorld' =>
                            array (
                                'HelloWorldHelloWorld::hello52949c4d54bba' =>
                                array (
                                    'startTime' => 1385471053.3478,
                                    'stopTime' => 1385471053.348,
                                    'processTime' => 0.00020790100097656,
                                    'memoryUsageStart' => 1107880,
                                    'memoryUsageStop' => 1108904,
                                    'memoryUsageConsume' => 1024,
                                    'memoryPeakStart' => 1168224,
                                    'memoryPeakStop' => 1168224,
                                    'memoryPeakConsume' => 0,
                                    'name' => 'HelloWorld::hello52949c4d54bba',
                                    'group' => 'HelloWorld',
                                    'uniqid' => '52949c4d54bba',
                                    'processTimeRatio' => 21.2,
                                    'processMemoryRatio' => 100,
                                    ),
                                'HelloWorldHelloWorld::world52949c4d54bba' =>
                                array (
                                    'startTime' => 1385471053.3481,
                                    'stopTime' => 1385471053.3484,
                                    'processTime' => 0.00029182434082031,
                                    'memoryUsageStart' => 1111856,
                                    'memoryUsageStop' => 1112880,
                                    'memoryUsageConsume' => 1024,
                                    'memoryPeakStart' => 1168224,
                                    'memoryPeakStop' => 1168224,
                                    'memoryPeakConsume' => 0,
                                    'name' => 'HelloWorld::world52949c4d54bba',
                                    'group' => 'HelloWorld',
                                    'uniqid' => '52949c4d54bba',
                                    'processTimeRatio' => 29.76,
                                    'processMemoryRatio' => 100,
                                    ),
                                      'HelloWorldHelloWorld::hello52949c4d55123' =>
                                          array (
                                                  'startTime' => 1385471053.3485,
                                                  'stopTime' => 1385471053.3487,
                                                  'processTime' => 0.00019097328186035,
                                                  'memoryUsageStart' => 1117224,
                                                  'memoryUsageStop' => 1118248,
                                                  'memoryUsageConsume' => 1024,
                                                  'memoryPeakStart' => 1168224,
                                                  'memoryPeakStop' => 1168224,
                                                  'memoryPeakConsume' => 0,
                                                  'name' => 'HelloWorld::hello52949c4d55123',
                                                  'group' => 'HelloWorld',
                                                  'uniqid' => '52949c4d55123',
                                                  'processTimeRatio' => 19.47,
                                                  'processMemoryRatio' => 100,
                                                ),
                                      'HelloWorldHelloWorld::world52949c4d55123' =>
                                          array (
                                                  'startTime' => 1385471053.3487,
                                                  'stopTime' => 1385471053.349,
                                                  'processTime' => 0.0002899169921875,
                                                  'memoryUsageStart' => 1121200,
                                                  'memoryUsageStop' => 1122224,
                                                  'memoryUsageConsume' => 1024,
                                                  'memoryPeakStart' => 1168224,
                                                  'memoryPeakStop' => 1168224,
                                                  'memoryPeakConsume' => 0,
                                                  'name' => 'HelloWorld::world52949c4d55123',
                                                  'group' => 'HelloWorld',
                                                  'uniqid' => '52949c4d55123',
                                                  'processTimeRatio' => 29.56,
                                                  'processMemoryRatio' => 100,
                                                ),
                                      ),
                                      'Total' => 0.00098061561584473,
                                      'TotalMemoryUsage' => 1024,
                                      'TotalMemoryPeak' => 0,
                                      )
                                )
            ->output(function () use ($display, $mockActive) {
                        echo (string) $display->profile($mockActive);
                    })
            ->contains('Total time: 0.98 ms.')
        ;
    }

    public function testProfileInactive()
    {
        $mockActive = new \mock\Profile\Bench\State\Inactive;

        $display = new Profile\Display();

        $this->object($decorator = $display->getDecorator())
            ->isInstanceOf('\Profile\Decorators\Cli')
            ->when($decorator->setData($mockActive))
            ->mock($mockActive)
            ->call('getStatistics')
            ->once()
            ->output(function () use ($display, $mockActive) {
                    echo (string) $display->profile($mockActive);
                    })
        ->isEmpty()
        ;
    }
}
