<?php
/**
 * Created by PhpStorm.
 * User: julio.lima
 * Date: 2019-02-01
 * Time: 10:42
 */

namespace Features\DataTransferObjects;


class ArticleDataTransferObject
{
    private $articleTitle;
    private $articleAuthor;

    public function getArticleTitle()
    {
        return $this->articleTitle;
    }

    public function setArticleTitle($articleTitle)
    {
        $this->articleTitle = $articleTitle;
    }

    public function getArticleAuthor()
    {
        return $this->articleAuthor;
    }

    public function setArticleAuthor($articleAuthor)
    {
        $this->articleAuthor = $articleAuthor;
    }
}