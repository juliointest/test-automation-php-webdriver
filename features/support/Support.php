<?php
/**
 * Created by PhpStorm.
 * User: julio.lima
 * Date: 2019-02-03
 * Time: 20:26
 */

namespace Features\Support;


use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;

class Support
{
    public static function waitUntilTheObjectDisappears(WebDriver $driver, WebDriverBy $elementThatShouldDisappear, $timeout = 5)
    {
        $explicitlyWait = new WebDriverWait($driver, $timeout);
        $explicitlyWait->until(WebDriverExpectedCondition::invisibilityOfElementLocated($elementThatShouldDisappear));
    }
}