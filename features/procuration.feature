@javascript
Feature:
  As a non logged user
  I can fill a form and became a representative

  Background:
    Given the following fixtures are loaded:
      | LoadProcurationData |

  Scenario: As a non logged user, I can fill a form
    Given I am on "/procuration/choisir/proposition"
    And I check "election_context[elections][]"
    When I press "Continuer"
    Then I should be on "procuration/je-propose"

