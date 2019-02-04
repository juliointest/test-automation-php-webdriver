<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Bravo3\Properties\Conf;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Features\Support\Support;
use Features\DataTransferObjects\ArticleDataTransferObject;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Hook\Scope\AfterScenarioScope;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $driver;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        Conf::init('./features');
    }

    /** @BeforeScenario */
    public function before(BeforeScenarioScope $scope)
    {
        $this->driver = RemoteWebDriver::create(
            Conf::get('endpoints.remoteWebDriver'),
            DesiredCapabilities::chrome(),
            Conf::get('timeouts.connectionTimeout'),
            Conf::get('timeouts.requestTimeout'));

        $this->driver->manage()->timeouts()->implicitlyWait(Conf::get('timeouts.minimumAwaitingForElements'));
        $this->driver->manage()->window()->maximize();
    }

    /**
     * @Given I am on the CFR home page
     */
    public function iAmOnTheCfrHomePage()
    {
        $this->driver->get(Conf::get('endpoints.cfrHomePage'));
    }

    /**
     * @Given I am aware of the Cookies Policy
     */
    public function iAmAwareOfTheCookiesPolicy()
    {
        $this->driver->findElement(
            WebDriverBy::cssSelector('.eu-cookie-compliance-content .agree-button'))->click();

        Support::waitUntilTheObjectDisappears(
            $this->driver, WebDriverBy::cssSelector('.eu-cookie-compliance-content .agree-button'));
    }

    /**
     * @When I visit the Search area
     */
    public function iVisitTheSearchArea()
    {
        $this->driver->findElement(WebDriverBy::cssSelector('.main-nav__search-hotspot'))->click();
    }

    /**
     * @When I search by :query
     */
    public function iSearchBy($query)
    {
        $this->driver->findElement(WebDriverBy::xpath('//*[@data-id="header_search"]'))->sendKeys($query);
        $this->driver->findElement(WebDriverBy::cssSelector('.search-overlay .button-container__btn'))->click();
    }

    /**
     * @Then I see :termSearched in the first :amountOfTitles article results
     */
    public function iSeeInTheFirstArticleResults($termSearched, $amountOfTitles)
    {
        $publicationTitles = $this->driver->findElements(WebDriverBy::xpath('//*[@class="card-search-results__title clamp-js"]//*[@class="card-search-results__highlight"][contains(text(), "' . $termSearched . '")]'));

        PHPUnit\Framework\Assert::assertEquals(10,
            count($publicationTitles),
            'Some publication titles does not contains Venezuela');
    }

    /**
     * @When I visit the Member Login area
     */
    public function iVisitTheMemberLoginArea()
    {
        $this->driver->findElement(
            WebDriverBy::cssSelector('.main-nav__members--wider-than-tablet a'))->click();
    }

    /**
     * @When submit the form with invalid data:
     */
    public function submitTheFormWithInvalidData(TableNode $table)
    {
        $this->driver->findElement(WebDriverBy::name('username'))->sendKeys($table->getHash()[0]['email']);
        $this->driver->findElement(WebDriverBy::name('password'))->sendKeys($table->getHash()[0]['password']);
        $this->driver->findElement(WebDriverBy::id('edit-submit'))->click();
    }

    /**
     * @Then I see a message saying my member credentials are wrong
     */
    public function iSeeAMessageSayingMyMemberCredentialsAreWrong()
    {
        $invalidCredentialsMessage = $this->driver->findElement(
            WebDriverBy::cssSelector('.msp-account__form-item-messages-list-item'))->getText();

        PHPUnit\Framework\Assert::assertEquals('You have entered an invalid email and password.', $invalidCredentialsMessage);
    }

    /**
     * @When I access the first Article by clicking on it
     */
    public function iAccessTheFirstArticleByClickingOnIt()
    {
        $this->driver->findElement(
            WebDriverBy::cssSelector('.top-package-dual__articles_primary .card-article__link'))->click();
    }

    /**
     * @Then the data inside is exactly what I saw in the Home Page:
     */
    public function theDataInsideIsExactlyWhatISawInTheHomePage(TableNode $table)
    {
        $articleExpected = new  ArticleDataTransferObject();
        $articleExpected->setArticleTitle($table->getHash()[0]['title']);
        $articleExpected->setArticleAuthor($table->getHash()[0]['author']);

        $article = new ArticleDataTransferObject();
        $article->setArticleTitle(
            $this->driver->findElement(WebDriverBy::cssSelector('.article-header__title'))->getText());
        $article->setArticleAuthor(
            $this->driver->findElement(WebDriverBy::cssSelector('.article-header__link'))->getText());

        PHPUnit\Framework\Assert::assertEquals($articleExpected, $article);
    }

    /** @AfterScenario */
    public function after(AfterScenarioScope $scope)
    {
        $this->driver->quit();
    }
}
