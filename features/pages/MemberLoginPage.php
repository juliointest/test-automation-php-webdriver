<?php
/**
 * Created by PhpStorm.
 * User: julio.lima
 * Date: 2019-02-01
 * Time: 09:37
 */

namespace Features\Pages;

use Facebook\WebDriver\WebDriverBy;
use Features\Support\Template;

class MemberLoginPage extends Template
{

    public function fillTheLoginForm($email, $password)
    {
        $this->driver->findElement(WebDriverBy::name('username'))->sendKeys($email);
        $this->driver->findElement(WebDriverBy::name('password'))->sendKeys($password);

        return $this;
    }

    public function submitTheLoginFormWithInvalidData()
    {
        $this->driver->findElement(WebDriverBy::id('edit-submit'))->click();

        return $this;
    }

    public function getTheErrorMessage()
    {
        return $this->driver->findElement(WebDriverBy::cssSelector('.msp-account__form-item-messages-list-item'))->getText();
    }
}