<?php
/**
 * Created by PhpStorm.
 * User: julio.lima
 * Date: 2019-02-01
 * Time: 10:39
 */

namespace Features\Pages;

use Facebook\WebDriver\WebDriverBy;
use Features\DataTransferObjects\ArticleDataTransferObject;
use Features\Support\Template;

class ArticlePage extends Template
{
    public function getArticleHeaderData()
    {
        $articleDataTransferObject = new ArticleDataTransferObject();

        $articleDataTransferObject->setArticleTitle(
            $this->driver->findElement(WebDriverBy::cssSelector('.article-header__title'))->getText());
        $articleDataTransferObject->setArticleAuthor(
            $this->driver->findElement(WebDriverBy::cssSelector('.article-header__link'))->getText());

        return $articleDataTransferObject;
    }
}