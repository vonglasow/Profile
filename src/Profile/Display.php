<?php

namespace Profile;

class Display
{
    const CLI = 'Cli';
    const HTML = 'Html';
    const INACTIVE = 'Inactive';

    private $decorator;

    public function __construct()
    {
        $this->decorator = ('cli' === php_sapi_name()) ? static::CLI : static::HTML;
    }

    public function profile(Bench\State\IMark $bench)
    {
        $class = substr(get_class($bench), strrpos(get_class($bench), '\\') + 1);

        if (self::INACTIVE === $class) {
            return '';
        }

        $decorator = $this->getDecorator();
        $decorator->setData($bench);

        return (string) $decorator;
    }

    /**
     * @return Decorators\IDecorator
     */
    public function getDecorator()
    {
        $class = '\\Profile\\Decorators\\' . $this->decorator;
        return new $class;
    }

    public function setDecorator($decorator)
    {
        $this->decorator = (string)$decorator;
    }
}