<?php
/**
 * Created by PhpStorm.
 * User: julio.lima
 * Date: 2019-02-01
 * Time: 00:23
 */

namespace Features\Pages;

use Facebook\WebDriver\WebDriverBy;
use Features\Support\Template;

class SearchBoxPage extends Template
{
    public function search($query)
    {
        $this->driver->findElement(WebDriverBy::xpath('//*[@data-id="header_search"]'))->sendKeys($query);
        $this->driver->findElement(WebDriverBy::cssSelector('.search-overlay .button-container__btn'))->click();

        return new SearchPage($this->driver);
    }
}