<?php
/**
 * Created by PhpStorm.
 * User: julio.lima
 * Date: 2019-02-01
 * Time: 00:23
 */

namespace Tests\Pages;


use Facebook\WebDriver\WebDriverBy;
use Tests\Support\Template;

class SearchPage extends Template
{
    public function getPublicationResultTitlesHighlightedWith($word)
    {
        return $this->driver->findElements(WebDriverBy::xpath('//*[@class="card-search-results__title clamp-js"]//*[@class="card-search-results__highlight"][contains(text(), "' . $word . '")]'));
    }
}