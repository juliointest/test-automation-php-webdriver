# PHP Test Automation using: 1) Facebook WebDriver and PageObjects, and 2) Simple Example using Behat 

This project was created to demonstrate how to do test automation in a Web Context using PHP. The stack used is based on PHP. The libraries used to create the test architecture are 1) PHPUnit, Facebook WebDriver, and Bravo Property, and 2) Behat. 

Two ways to structure the Test Scripts are demonstrated here: 1) PHPUnit and 2) Behat. PHPUnit basically is a programmatic way and Behat is more user-friendly and driven by the behaviour described in feature files.  

To run the Automated Test Scripts over PHP stack we need to use a Driver, in this case, Chrome Driver.

As a test structure, Page Objects was selected since it is pretty good to organize the test scripts as WebPages.

The project was created over a composer structure and namespaces with PSR-4. 

## Page Objects

Page Objects is a design pattern to test automation, basically, we divide the Page actions into classes and put into a driver that stores the Browser current state. All the pages are stored inside the folder tests/pages.

Each page has the same starter structure, that is an attribute to store the Browser current state and a constructor to set the current state on it. The Template class has this structure and all pages extend that class.

## PHPUnit

PHPUnit is a library used to structure, run and assert data inside tests. In this project, I used it to organize the tests and also to have hooks to set up and tear down each test.

The Test Classes are stored inside the folder tests.

## Behat

Behat is a PHP library inspired in Cucumber [link text](https://cucumber.io/), a Ruby framework, to create test scripts based on a user-friendly description written in Gherkin [link text](http://docs.behat.org/en/v2.5/guides/1.gherkin.html). The feature files are read and then Behat looks for the PHP code snippets stored in the features folder. Once it is found, Behat executed the function code. In this case, the function code has Facebook WebDriver code, to simulate the user interacting to the web site. 

## Facebook WebDriver

Facebook WebDriver is a library used to simulate user actions over the Browsers. It basically counts on a DSL to allows humans to write commands and when the test scripts are running the commands are sent to a Web Driver (eg. ChromeDriver for Chrome, GheckoDriver for Firefox, etc) and it reproduces the commands into the browser.

All Facebook WebDriver commands are store inside the Pages of Page Objects.

## Bravo 3 Property

It is a simple library to load a YML file and allows to access its properties values from the code.

Property file is inside the folder tests.

## Usage

You will need to have Google Chrome, Composer, and PHP installed in your computer.

### Download and run the ChromeDriver

1. Download the last version in http://chromedriver.chromium.org/downloads
2. Run the command `./chromedriver --port=4444`

It will start the Chrome Driver server on the URL http://localhost:4444

### installing the Project Dependencies

1. Open the project folder by command line prompt
2. Run the command `composer install`

### Running the test scripts on PHPUnit

1. Open the project folder by command line prompt
2. ./vendor/bin/phpunit --testsuite "The Test Suite"

### Running the test scripts on Behat

1. Open the project folder by command line prompt
2. ./vendor/bin/behat

