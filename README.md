<p align="center">
    <a href="https://www.3brs.com" target="_blank">
        <img src="https://3brs1.fra1.cdn.digitaloceanspaces.com/3brs/logo/3BRS-logo-sylius-200.png"/>
    </a>
</p>
<h1 align="center">
simple Twig Template Plugin
<br />
	<a href="https://packagist.org/packages/3brs/sylius-admin-simple-layout-plugin" title="License" target="_blank">
        <img src="https://img.shields.io/packagist/l/3brs/sylius-admin-simple-layout-plugin" />
    </a>
    <a href="https://packagist.org/packages/3brs/sylius-admin-simple-layout-plugin" title="Version" target="_blank">
        <img src="https://img.shields.io/packagist/v/3brs/sylius-admin-simple-layout-plugin" />
    </a>
    <a href="https://circleci.com/gh/3BRS/sylius-admin-simple-layout-plugin" title="Build status" target="_blank">
        <img src="https://circleci.com/gh/3BRS/sylius-admin-simple-layout-plugin.svg?style=shield" />
    </a>
</h1>

## Usage

Inject your custom content into admin template to get your content with Sylius 2 admin menu, header and footer.

## Installation

1. Run `composer require 3brs/sylius-admin-simple-layout-plugin`.
2. Register `ThreeBRS\SyliusAdminSimpleLayoutPlugin\ThreeBRSSyliusAdminSimpleLayoutPluginn::class => ['all' => true]` in your `config/bundles.php`.

4. Import plugin configuration in your `config/packages/_sylius.yaml`

```yaml
imports:
    - { resource: "@ThreeBRSSyliusAdminSimpleLayoutPlugin/Resources/config/config.yaml" }
```

### Usage

a) Inject custom string content into your custom template, extending simple layout template
```php
// src/Controller/MyCustomAdminSimplePageController.php
    public function index(): Response
    {
            $this->templatingEngine->render(
                'my_custom_content_index.html.twig',
                [
                    'custom_content' => $this->templatingEngine->render(
                        'completely_isolated_custom_template.html.twig',
                        [
                            'myCustomVariableFromController' => 'ISO-late',
                        ],
                    ),
                ],
            ),
        );
    }
```

```twig
# templates/my_custom_content_index.html.twig
{% extends '@ThreeBRSSyliusAdminSimpleLayoutPlugin/shared/layout/simple.html.twig' %}

{% block title %}My custom HTML <title>{% endblock %}

{% block body %}My custom HTML <body>{% endblock %}

{% block javascripts %}
    {{ parent() }}
    <script>
    // My custom global JS injected at the end of the page right before </body>
    </script>
{% endblock %}
```

b) Or create your custom template skeleton, calling inside your desired custom content hook (render this template by controller, email service, etc.)

```twig
# templates/my_custom_content_index.html.twig
{% extends '@ThreeBRSSyliusAdminSimpleLayoutPlugin/shared/layout/simple.html.twig' %}

{% block title %}My custom HTML <title>{% endblock %}

{% block body %}

	{% hook [ 'sylius_admin.simple.page' ] with {
		'title' : 'My custom breadcrumb and page H1 title, mandatory',
		'subtitle' : 'Some subtitle, optional',
		'icon' : 'Some icon for \Symfony\UX\Icons\Twig\UXIconRuntime::renderIcon, optional',
		'test_attribute' : 'Some helper name for tests, optional',
		'custom_hook' : 'my_custom_hook_inside_simple_page_hook_witch_should_have_shorter_name',
	} %}

{% endblock %}

{% block javascripts %}
	{{ parent() }}
	<script>
        // My custom global JS injected at the end of the page right before </body>
    </script>
{% endblock %}
```

```yaml
# config/packages/twig_hooks.yaml
sylius_twig_hooks:
    hooks:
        'sylius_admin.simple.page.content.custom':
            'my_optional_custom_content_global_block':
                template: '@MyCustomPlugin/twig_hooks/my_custom_content_rendered_on_every_custom_page.html.twig'
            'my_optional_custom_content_global_javascript_block':
                template: '@MyCustomPlugin/twig_hooks/my_custom_javascript_rendered_on_every_custom_page.html.twig'
        'sylius_admin.simple.page.content.my_custom_hook_inside_simple_page_hook_witch_should_have_shorter_name':
            my_first_custom_block_witch_i_should_name_more_originally:
                template: '@MyCustomPlugin/twig_hooks/my_custom_first_block.html.twig'
            my_second_custom_block_witch_i_should_name_more_originally:
                template: '@MyCustomPlugin/twig_hooks/my_custom_second_block.html.twig'
```

```twig
{# templates/twig_hooks/my_custom_first_block.html.twig #}
Completely custom content for my first block

{# variables from controller and parent hookables are passed in hookable_metadata.context #}
{% set myCustomVariable = hookable_metadata.context.myCustomVariable %}

```

```twig
# templates/twig_hooks/my_custom_second_block.html.twig
Completely custom content for my second block

{# variables from controller and parent hookables are passed in hookable_metadata.context #}
{% set myCustomVariable = hookable_metadata.context.myCustomVariable %}
```

```php
// src/Controller/MyCustomAdminSimplePageController.php
    public function index(): Response
    {
        return new Response(
            $this->templatingEngine->render(
                'my_custom_content_index.html.twig',
                [
                    'myCustomVariable' => 'My custom variable content',
                ],
            ),
        );
    }
```

## Development

### Testing

After your changes you must ensure that the tests are still passing.

```bash
make ci
```

License
-------
This library is under the MIT license.

Credits
-------
Developed by [3BRS](https://3brs.com)
