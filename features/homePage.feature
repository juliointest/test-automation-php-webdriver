Feature: Home Page
  As a member
  I would like to have access to the CFR information and news
  In order to be updated about the world changes

  Background: Accessing the CFR Website and Already Aware of the Cookies Policy
    Given I am on the CFR home page
    And I am aware of the Cookies Policy

  Scenario: Search Articles Related to a Specific Term
    When I visit the Search area
    And I search by "Venezuela"
    Then I see "Venezuela" in the first 10 article results

  Scenario Outline: Submit an Invalid Data in the Member Login
    When I visit the Member Login area
    And submit the form with invalid data:
    | email     | password    |
    | <email>   | <password>  |
    Then I see a message saying my member credentials are wrong

  Examples:
    | email                   | password          |
    | invalid@email.com       | invalid-password  |

  Scenario: Read the First Article Showed in the Home Page
    When I access the first Article by clicking on it
    Then the data inside is exactly what I saw in the Home Page:
    | title                                   | author          |
    | What Would a No-Deal Brexit Look Like?  | Andrew Chatzky  |