<?php

namespace Profile\tests\units\Bench\State;

require 'vendor/autoload.php';

use mageekguy\atoum;
use Profile\Bench\State\Active as Bench;

class Active  extends atoum\test {
    public function testBenchStatusBeforeInitialisation()
    {
        $this->object($bench = new Bench())
            ->isInstanceOf('\Profile\Bench\State\Active')
            ->and()->castToString($bench)->isEqualTo('[]')
            ->and()->sizeOf($bench)->isEqualTo(0)
            ->and()->boolean($bench->valid())->isFalse()
            ->and()->variable($bench->getGroup())->isNull()
            ->and()->variable($bench->getUniqid())->isNull()
            ->and()->array($bench->getStatistics())->isEmpty()
            ->and()->integer($bench->count())->isEqualTo(0)
            ->when($bench->setGroup('foo'))
            ->then()->string($bench->getGroup())->isEqualTo('foo')
            ->when($bench->setUniqid('bar'))
            ->then()->string($bench->getUniqid())->isEqualTo('bar')
            ->when($bench->unsetAll())
            ->then()->integer($bench->count())->isEqualTo(0)
        ;
    }

    public function testBenchStatusWhenMarkIsDefine()
    {
        $this->object($bench = new Bench())
            ->isInstanceOf('\Profile\Bench\State\Active')
            ->and()->integer($bench->count())->isEqualTo(0)
            ->when($mark = $bench->hello)
            ->then()->object($mark)->isInstanceOf('\Profile\Bench\Active')
            ->and()->integer($bench->count())->isEqualTo(1)
            ->when($mark2 = $bench->world)
            ->then()->object($mark2)->isInstanceOf('\Profile\Bench\Active')
            ->and()->integer($bench->count())->isEqualTo(2)
            ->and()->when($markHello = $bench->hello)
            ->then()->object($mark)->isIdenticalTo($markHello)
            ->and()->when($markWorld = $bench->world)
            ->then()->object($mark2)->isIdenticalTo($markWorld)
            ->and()->boolean($bench->valid())->isTrue()
        ;
    }

    public function testComputeStatisticsWhenNoMarkCreatedShouldNotBreak()
    {
        $this->object($bench = new Bench())
            ->isInstanceOf('\Profile\Bench\State\Active')
            ->when($bench->computeStatistics())
            ->then()->array($bench->getStatistics())->isEmpty()
            ->and()->castToString($bench)->isEqualTo('[]')
        ;
    }

    public function testComputeStatisticsWhenMarkAreCreated()
    {
        $this->object($bench = new Bench())
            ->isInstanceOf('\Profile\Bench\State\Active')
            ->when($mark = $bench->hello)
            ->then()->object($mark)->isInstanceOf('\Profile\Bench\Active')
            ->and()->integer($bench->count())->isEqualTo(1)
            ->when($mark2 = $bench->world)
            ->then()->object($mark2)->isInstanceOf('\Profile\Bench\Active')
            ->and()->integer($bench->count())->isEqualTo(2)
            ->when($bench->computeStatistics())
            ->then()->array($bench->getStatistics())->isNotEmpty()
        ;
    }

    public function testComputeStatisticsWhenMarkAreInGroup()
    {
        $this->object($bench = new Bench())
            ->isInstanceOf('\Profile\Bench\State\Active')
            ->when($bench->setGroup('foo'))
            ->and($foo = $bench->hello->start())
            ->and($bench->setGroup('bar'))
            ->and($bar = $bench->hello->start())
            ->and()->object($foo->stop())->isInstanceOf('\Profile\Bench\Active')
            ->and()->object($bar->stop())->isInstanceOf('\Profile\Bench\Active')
            ->then()->boolean($bench->computeStatistics())->isTrue()
            ->and()->castToString($bench)->contains('foohello')
            ->and()->castToString($bench)->contains('barhello')
            ;
    }
}
