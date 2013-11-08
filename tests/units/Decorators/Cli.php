<?php

namespace Profile\tests\units\Decorators;

require_once 'vendor/autoload.php';

use mageekguy\atoum;
use Profile;

class Cli extends atoum\test
{
    public function testSeparator() {
        $this->object($decorator= new Profile\Decorators\Cli())
            ->isInstanceOf('\Profile\Decorators\Cli')
            ->and()->string($decorator->separator())->contains('--')
        ;
    }

    public function testGetColor()
    {
        $this->object($decorator= new Profile\Decorators\Cli())
            ->isInstanceOf('\Profile\Decorators\Cli')
            ->and()->string($decorator->separator())->contains('--')
        ;
    }
}

