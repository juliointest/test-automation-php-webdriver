<?php
/**
 * Created by PhpStorm.
 * User: julio.lima
 * Date: 2019-01-31
 * Time: 23:16
 */

namespace Tests\Support;


use Bravo3\Properties\Conf;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use PHPUnit\Framework\TestCase;

use Tests\DataTransferObjects\ArticleDataTransferObject;
use Tests\Pages\HomePage;

class HomeTests extends TestCase
{
    private $driver;

    /**
     * @BeforeClass
     */
    public static function setUpBeforeClass()
    {
        Conf::init('./tests');
    }

    /**
     * @Before
     */
    public function setUp()
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
     * @Test
     */
    public function testTermSearchedShouldBeIncludedInEachPublicationTitleResult()
    {
        $publicationTitles = (new HomePage($this->driver))
            ->accessCFR()
            ->closeEUCookieMessage()
            ->openSearchBox()
            ->search('Venezuela')
            ->getPublicationResultTitlesHighlightedWith('Venezuela');

        $this->assertEquals(10,
            count($publicationTitles),
            'Some publication titles does not contains Venezuela');
    }

    /**
     * @Test
     * @dataProvider dataToBeUsedOnSubmitMemberLoginUsingWrongEmailShouldShowsAProperErrorMessage
     */
    public function testSubmitMemberLoginUsingWrongEmailShouldShowsAProperErrorMessage($email, $password, $expectedErrorMessage)
    {
        $invalidEmailAndPasswordErrorMessage = (new HomePage($this->driver))
            ->accessCFR()
            ->closeEUCookieMessage()
            ->openMemberLoginPage()
            ->fillTheLoginForm($email, $password)
            ->submitTheLoginFormWithInvalidData()
            ->getTheErrorMessage();

        $this->assertEquals($expectedErrorMessage, $invalidEmailAndPasswordErrorMessage);
    }

    public static function dataToBeUsedOnSubmitMemberLoginUsingWrongEmailShouldShowsAProperErrorMessage()
    {
        return array(
            'Invalid Email and Password' => array(
                'invalid@email.com',
                'invalid-password',
                'You have entered an invalid email and password.'),
            'SQL Injection' => array(
                'sql-injection@email.com',
                "' or 1=1--",
                'You have entered an invalid email and password.'),
        );
    }

    /**
     * @Test
     */
    public function testThePrimaryArticleShouldHaveTheSameTitleAndAuthor()
    {
        $articleExpected = new  ArticleDataTransferObject();
        $articleExpected->setArticleTitle('What Would a No-Deal Brexit Look Like?');
        $articleExpected->setArticleAuthor('Andrew Chatzky');

        $article = (new HomePage($this->driver))
            ->accessCFR()
            ->closeEUCookieMessage()
            ->readThePrimaryArticle()
            ->getArticleHeaderData();

        $this->assertEquals($articleExpected, $article);
    }

    /**
     * @After
     */
    public function tearDown()
    {
        $this->driver->quit();
    }
}