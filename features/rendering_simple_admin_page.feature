@rendering_simple_admin_page
Feature: Rendering simple admin page
    In order to display custom content
    As an Administrator
    I want to be able to see the content of the page without resources

    Background:
        Given I am logged in as an administrator

    @ui
    Scenario: Rendering simple_admin_page page
        When I browse my custom simple admin page
        Then I should see custom breadcrumb
        And I should see custom title
        And I should see custom subtitle
        And I should see custom body content
