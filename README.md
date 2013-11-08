Profile
=======

Profile class with time and memory use, not needed to pollute any code with memory_get_usage or memory_get_peak_usage or
microtime.

    <?php

    $loader = require 'vendor/autoload.php';

    class HelloWorld {
        public function hello()
        {
            usleep(100);
            return 'hello';
        }

        public function world()
        {
            usleep(200);
            return 'world';
        }
    }

    $helloworld = new Profile\Profile(new HelloWorld());
    $helloworld->hello();
    $helloworld->world();
    $helloworld2 = new Profile\Profile(new HelloWorld());
    $helloworld2->hello();
    $helloworld2->world();
    $helloworld2->getBenchmark()->computeStatistics();

    $display = new Profile\Display;
    echo $display->profile($helloworld2->getBenchmark());