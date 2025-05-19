<?php

declare(strict_types=1);

namespace Tests\ThreeBRS\SyliusAdminSimpleLayoutPlugin\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

readonly class MyCustomAdminSimplePageController
{
    public function __construct(private Environment $templatingEngine)
    {
    }

    public function index(): Response
    {
        return new Response(
            $this->templatingEngine->render(
                'my_custom_content_index.html.twig',
                [
                    'custom_content' => $this->templatingEngine->render(
                        'completely_isolated_custom_template.html.twig',
                        [
                            'myCustomVariableFromController' => 'ISO-late',
                        ],
                    ),
                    'myCustomVariableFromController' => 'My custom variable content',
                ],
            ),
        );
    }
}
