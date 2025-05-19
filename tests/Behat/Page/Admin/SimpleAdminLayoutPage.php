<?php

declare(strict_types=1);

namespace Tests\ThreeBRS\SyliusAdminSimpleLayoutPlugin\Behat\Page\Admin;

use Behat\Mink\Element\NodeElement;
use Behat\Mink\Session;
use Sylius\Behat\Page\SymfonyPage;
use Symfony\Component\Routing\RouterInterface;

class SimpleAdminLayoutPage extends SymfonyPage implements SimpleAdminLayoutPageInterface
{
    /**
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<TKey, TValue>|\ArrayAccess<TKey, TValue> $minkParameters
     */
    public function __construct(
        Session              $session,
        array | \ArrayAccess $minkParameters,
        RouterInterface      $router,
    ) {
        parent::__construct($session, $minkParameters, $router);
    }

    public function getRouteName(): string
    {
        /** @link tests/Application/config/routes/sylius_admin.yaml */
        return 'threebrs_simple_admin_layout_page_plugin';
    }

    public function getBreadcrumb(): NodeElement
    {
        return $this->getElement('breadcrumb');
    }

    public function getPageTitle(): NodeElement
    {
        return $this->getElement('page_title');
    }

    public function getPageSubtitle(): NodeElement
    {
        return $this->getElement('page_subtitle');
    }

    public function getPageBody(): NodeElement
    {
        return $this->getElement('page_body');
    }

    /** @return array<string, string> */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'breadcrumb'    => 'ol.breadcrumb',
            'page_title'    => 'h1.page-title',
            'page_subtitle' => 'h1.page-title+div',
            'page_body'     => '.page-body',
        ]);
    }
}
