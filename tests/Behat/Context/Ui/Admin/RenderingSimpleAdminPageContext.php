<?php

declare(strict_types=1);

namespace Tests\ThreeBRS\SyliusAdminSimpleLayoutPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Tests\ThreeBRS\SyliusAdminSimpleLayoutPlugin\Behat\Page\Admin\SimpleAdminLayoutPageInterface;
use Webmozart\Assert\Assert;

final readonly class RenderingSimpleAdminPageContext implements Context
{
    public function __construct(
        private SimpleAdminLayoutPageInterface $simpleAdminLayoutPage,
    ) {
    }

    /**
     * @When I browse my custom simple admin page
     */
    public function iBrowseMyCustomSimpleAdminPage(): void
    {
        $this->simpleAdminLayoutPage->open();
    }

    /**
     * @Then I should see custom breadcrumb
     */
    public function iShouldSeeCustomBreadcrumb(): void
    {
        Assert::same(
            $this->simpleAdminLayoutPage->getBreadcrumb()->getText(),
            'Dashboard My custom breadcrumb and page H1 title, mandatory',
        );
    }

    /**
     * @Then I should see custom title
     */
    public function iShouldSeeCustomH1Header(): void
    {
        Assert::same(
            $this->simpleAdminLayoutPage->getPageTitle()->getText(),
            'My custom breadcrumb and page H1 title, mandatory',
        );
    }

    /**
     * @Then I should see custom subtitle
     */
    public function iShouldSeeCustomSubtitle(): void
    {
        Assert::same(
            $this->simpleAdminLayoutPage->getPageSubtitle()->getText(),
            'Some subtitle, optional',
        );
    }

    /**
     * @Then I should see custom body content
     */
    public function iShouldSeeCustomBodyContent(): void
    {
        Assert::same(
            $this->simpleAdminLayoutPage->getPageBody()->getText(),
            'Well, well, well Before nothing dwell ISO-late First! Second! And some given variable from controller: My custom variable content And some given variable from parent hookable template: Just a test variable from parent template',
        );
    }
}
