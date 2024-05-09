<?php

namespace Bl\LaravelUploadable\Classes;

class FileArgument
{
    protected $argument;

    public function __construct($argument = 'default')
    {
        $this->argument = $argument;
    }

    /**
     * set the arugment value.
     *
     * @param  string $value
     * @return void
     */
    public function setValue($value)
    {
        $this->argument = $value;
    }

    /**
     * get the arugment value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->argument;
    }

    /**
     * check if the arugment value is default or not.
     *
     * @return bool
     */
    public function isDefault()
    {
        return $this->getValue() === 'default';
    }

    /**
     * check if the arugment value is [null|nullable] or not.
     *
     * @return void
     */
    public function isNullable()
    {
        return in_array($this->getValue(), ['null', 'nullable']);
    }
}
