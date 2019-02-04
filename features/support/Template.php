<?php

namespace Features\Support;

use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;

class Template
{
    protected $driver;

    public function __construct(WebDriver $driver)
    {
        $this->driver = $driver;
    }

    public function waitUntilTheObjectDisappears(WebDriverBy $elementThatShouldDisappear, $timeout = 5)
    {
        $explicitlyWait = new WebDriverWait($this->driver, $timeout);
        $explicitlyWait->until(WebDriverExpectedCondition::invisibilityOfElementLocated($elementThatShouldDisappear));
    }
}