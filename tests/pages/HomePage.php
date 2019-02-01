<?php
/**
 * Created by PhpStorm.
 * User: julio.lima
 * Date: 2019-01-31
 * Time: 23:16
 */

namespace Tests\Pages;


use Bravo3\Properties\Conf;
use Facebook\WebDriver\WebDriverBy;
use Tests\Support\Template;

class HomePage extends Template
{
    public function accessCFR()
    {
        $this->driver->get(Conf::get('endpoints.cfrHomePage'));

        return $this;
    }

    public function closeEUCookieMessage()
    {
        $this->driver->findElement(
            WebDriverBy::cssSelector('.eu-cookie-compliance-content .agree-button'))->click();

        $this->waitUntilTheObjectDisappears(
            WebDriverBy::cssSelector('.eu-cookie-compliance-content .agree-button'));

        return $this;
    }

    public function openSearchBox()
    {
        $this->driver->findElement(WebDriverBy::cssSelector('.main-nav__search-hotspot'))->click();

        return new SearchBoxPage($this->driver);
    }

    public function openMemberLoginPage()
    {
        $this->driver->findElement(
            WebDriverBy::cssSelector('.main-nav__members--wider-than-tablet a'))->click();

        return new MemberLoginPage($this->driver);
    }

    public function readThePrimaryArticle()
    {
        $this->driver->findElement(
            WebDriverBy::cssSelector('.top-package-dual__articles_primary .card-article__link'))->click();

        return new ArticlePage($this->driver);
    }
}