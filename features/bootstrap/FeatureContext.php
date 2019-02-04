<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Bravo3\Properties\Conf;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use PHPUnit\Framework\Assert;
use Features\DataTransferObjects\ArticleDataTransferObject;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Features\Pages\HomePage;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $driver;
    private $homePage;
    private $searchBoxPage;
    private $searchPage;
    private $memberLoginPage;
    private $articlePage;

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
        $this->homePage = new HomePage($this->driver);
        $this->homePage->accessCFR();
    }

    /**
     * @Given I am aware of the Cookies Policy
     */
    public function iAmAwareOfTheCookiesPolicy()
    {
        $this->homePage->closeEUCookieMessage();
    }

    /**
     * @When I visit the Search area
     */
    public function iVisitTheSearchArea()
    {
        $this->searchBoxPage = $this->homePage->openSearchBox();
    }

    /**
     * @When I search by :query
     */
    public function iSearchBy($query)
    {
        $this->searchPage = $this->searchBoxPage->search($query);
    }

    /**
     * @Then I see :termSearched in the first :amountOfTitles article results
     */
    public function iSeeInTheFirstArticleResults($termSearched, $amountOfTitles)
    {
        $publicationTitles = $this->searchPage->getPublicationResultTitlesHighlightedWith($termSearched);


        Assert::assertEquals($amountOfTitles,
            count($publicationTitles),
            'Some publication titles does not contains Venezuela');
    }

    /**
     * @When I visit the Member Login area
     */
    public function iVisitTheMemberLoginArea()
    {
        $this->memberLoginPage = $this->homePage->openMemberLoginPage();
    }

    /**
     * @When submit the form with invalid data:
     */
    public function submitTheFormWithInvalidData(TableNode $table)
    {
        $this->memberLoginPage->fillTheLoginForm($table->getHash()[0]['email'], $table->getHash()[0]['password']);
        $this->memberLoginPage->submitTheLoginFormWithInvalidData();
    }

    /**
     * @Then I see a message saying my member credentials are wrong
     */
    public function iSeeAMessageSayingMyMemberCredentialsAreWrong()
    {
        $invalidCredentialsMessage = $this->memberLoginPage->getTheErrorMessage();

        Assert::assertEquals('You have entered an invalid email and password.', $invalidCredentialsMessage);
    }

    /**
     * @When I access the first Article by clicking on it
     */
    public function iAccessTheFirstArticleByClickingOnIt()
    {
        $this->articlePage = $this->homePage->readThePrimaryArticle();
    }

    /**
     * @Then the data inside is exactly what I saw in the Home Page:
     */
    public function theDataInsideIsExactlyWhatISawInTheHomePage(TableNode $table)
    {
        $articleExpected = new  ArticleDataTransferObject();
        $articleExpected->setArticleTitle($table->getHash()[0]['title']);
        $articleExpected->setArticleAuthor($table->getHash()[0]['author']);

        $article = $this->articlePage->getArticleHeaderData();

        Assert::assertEquals($articleExpected, $article);
    }

    /** @AfterScenario */
    public function after(AfterScenarioScope $scope)
    {
        $this->driver->quit();
    }
}
