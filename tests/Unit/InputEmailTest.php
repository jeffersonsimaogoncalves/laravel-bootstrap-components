<?php

namespace Okipa\LaravelBootstrapComponents\Tests\Unit;

use Illuminate\Support\MessageBag;
use Okipa\LaravelBootstrapComponents\Form\Input;
use Okipa\LaravelBootstrapComponents\Test\BootstrapComponentsTestCase;
use Okipa\LaravelBootstrapComponents\Test\Fakers\UsersFaker;

class inputEmailTest extends BootstrapComponentsTestCase
{
    use UsersFaker;

    public function testConfigStructure()
    {
        // components
        $this->assertTrue(array_key_exists('input_email', config('bootstrap-components')));
        // components.input
        $this->assertTrue(array_key_exists('view', config('bootstrap-components.input_email')));
        $this->assertTrue(array_key_exists('icon', config('bootstrap-components.input_email')));
        $this->assertTrue(array_key_exists('legend', config('bootstrap-components.input_email')));
        $this->assertTrue(array_key_exists('class', config('bootstrap-components.input_email')));
        $this->assertTrue(array_key_exists('html_attributes', config('bootstrap-components.input_email')));
        // components.input.class
        $this->assertTrue(array_key_exists('container', config('bootstrap-components.input_email.class')));
        $this->assertTrue(array_key_exists('component', config('bootstrap-components.input_email.class')));
        // components.input.html_attributes
        $this->assertTrue(array_key_exists('container', config('bootstrap-components.input_email.html_attributes')));
        $this->assertTrue(array_key_exists('component', config('bootstrap-components.input_email.html_attributes')));
    }

    public function testExtendsInput()
    {
        $this->assertEquals(Input::class, get_parent_class(inputText()));
    }

    public function testSetTypeAndName()
    {
        $html = inputEmail()->type('text')->name('name')->toHtml();
        $this->assertContains('<input id="input-name"', $html);
        $this->assertContains('name="name"', $html);
        $this->assertContains('aria-describedby="input-name"', $html);
        $this->assertContains('type="email"', $html);
    }

    public function testInputWithoutType()
    {
        $html = inputEmail()->name('name')->toHtml();
        $this->assertContains('type="email"', $html);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Name must be declared for the Okipa\LaravelBootstrapComponents\Form\Input component
     *                           generation.
     */
    public function testInputWithoutName()
    {
        inputEmail()->toHtml();
    }

    public function testSetModel()
    {
        $user = $this->createUniqueUser();
        $html = inputEmail()->model($user)->name('name')->toHtml();
        $this->assertContains('value="' . $user->name . '"', $html);
    }

    public function testConfigIcon()
    {
        $configIcon = 'test-config-icon';
        config()->set('bootstrap-components.input_email.icon', $configIcon);
        $html = inputEmail()->name('name')->toHtml();
        $this->assertContains('<span class="icon input-group-text">' . $configIcon . '</span>', $html);
    }

    public function testSetIcon()
    {
        $configIcon = 'test-config-icon';
        $customIcon = 'test-custom-icon';
        config()->set('bootstrap-components.input_email.icon', $configIcon);
        $html = inputEmail()->name('name')->icon($customIcon)->toHtml();
        $this->assertContains('<span class="icon input-group-text">' . $customIcon . '</span>', $html);
        $this->assertNotContains('<span class="icon input-group-text">' . $configIcon . '</span>', $html);
    }

    public function testNoIcon()
    {
        config()->set('bootstrap-components.input_email.icon', null);
        $html = inputEmail()->name('name')->toHtml();
        $this->assertNotContains('<span class="icon input-group-text">', $html);
    }

    public function testConfigLegend()
    {
        $configLegend = 'test-config-legend';
        config()->set('bootstrap-components.input_email.legend', $configLegend);
        $html = inputEmail()->name('name')->toHtml();
        $this->assertContains(
            '<small id="input-name-legend" class="form-text text-muted">' . $configLegend . '</small>',
            $html
        );
    }

    public function testSetLegend()
    {
        $configLegend = 'test-config-legend';
        $customLegend = 'test-custom-legend';
        config()->set('bootstrap-components.input_email.legend', $configLegend);
        $html = inputEmail()->name('name')->legend($customLegend)->toHtml();
        $this->assertContains(
            '<small id="input-name-legend" class="form-text text-muted">' . $customLegend . '</small>',
            $html
        );
        $this->assertNotContains(
            '<small id="input-name-legend" class="form-text text-muted">' . $configLegend . '</small>',
            $html
        );
    }

    public function testNoLegend()
    {
        config()->set('bootstrap-components.input_email.legend', null);
        $html = inputEmail()->name('name')->toHtml();
        $this->assertNotContains('id="input-name-legend"', $html);
    }

    public function testSetPlaceholder()
    {
        $placeholder = 'test-custom-placeholder';
        $html = input()->type('text')->name('name')->placeholder($placeholder)->toHtml();
        $this->assertContains('placeholder="' . $placeholder . '"', $html);
        $this->assertNotContains(
            'placeholder="bootstrap-components::bootstrap-components.validation.attributes.name"',
            $html
        );
    }

    public function testNoPlaceholder()
    {
        $html = input()->type('text')->name('name')->toHtml();
        $this->assertContains(
            'placeholder="bootstrap-components::bootstrap-components.validation.attributes.name"',
            $html
        );
    }

    public function testSetValue()
    {
        $customValue = 'test-custom-value';
        $html = input()->type('text')->name('name')->value($customValue)->toHtml();
        $this->assertContains('value="' . $customValue . '"', $html);
    }

    public function testOldValue()
    {
        $oldValue = 'test-old-value';
        $customValue = 'test-custom-value';
        $this->app['router']->get('test', [
            'middleware' => 'web', 'uses' => function() use ($oldValue) {
                $request = request()->merge(['name' => $oldValue]);
                $request->flash();
            },
        ]);
        $this->call('GET', 'test');
        $html = input()->type('text')->name('name')->value($customValue)->toHtml();
        $this->assertContains('value="' . $oldValue . '"', $html);
        $this->assertNotContains('value="' . $customValue . '"', $html);
    }

    public function testSetLabel()
    {
        $label = 'test-custom-label';
        $html = inputEmail()->name('name')->label($label)->toHtml();
        $this->assertContains('<label for="input-name">' . $label . '</label>', $html);
        $this->assertContains('aria-label="' . $label . '"', $html);
    }

    public function testNoLabel()
    {
        $html = inputEmail()->name('name')->toHtml();
        $this->assertContains(
            '<label for="input-name">bootstrap-components::bootstrap-components.validation.attributes.name</label>',
            $html
        );
        $this->assertContains(
            'aria-label="bootstrap-components::bootstrap-components.validation.attributes.name"',
            $html
        );
    }

    public function testHideLabel()
    {
        $html = inputEmail()->name('name')->hideLabel()->toHtml();
        $this->assertNotContains(
            '<label for="input-name">bootstrap-components::bootstrap-components.validation.attributes.name</label>',
            $html
        );
        $this->assertContains(
            'aria-label="bootstrap-components::bootstrap-components.validation.attributes.name"',
            $html
        );
    }

    public function testError()
    {
        $errorMessage = 'This a test error message';
        $messageBag = app(MessageBag::class)->add('name', $errorMessage);
        $html = inputEmail()->name('name')->render(['errors' => $messageBag]);
        $this->assertContains('<span class="invalid-feedback d-flex">', $html);
        $this->assertContains('<strong>' . $errorMessage . '</strong>', $html);
    }

    public function testNoError()
    {
        $html = inputEmail()->name('name')->render();
        $this->assertNotContains('<span class="invalid-feedback d-flex">', $html);
    }

    public function testConfigContainerClass()
    {
        $configContainerCLass = 'test-config-class-container';
        config()->set('bootstrap-components.input_email.class.container', [$configContainerCLass]);
        $html = inputEmail()->name('name')->toHtml();
        $this->assertContains('class="input-name-container ' . $configContainerCLass . '"', $html);
    }

    public function testSetContainerClass()
    {
        $configContainerCLass = 'test-config-class-container';
        $customContainerCLass = 'test-custom-class-container';
        config()->set('bootstrap-components.input_email.class.container', [$configContainerCLass]);
        $html = inputEmail()->name('name')->containerClass([$customContainerCLass])->toHtml();
        $this->assertContains('class="input-name-container ' . $customContainerCLass . '"', $html);
        $this->assertNotContains('class="input-name-container ' . $configContainerCLass . '"', $html);
    }

    public function testConfigComponentClass()
    {
        $configComponentCLass = 'test-config-class-component';
        config()->set('bootstrap-components.input_email.class.component', [$configComponentCLass]);
        $html = inputEmail()->name('name')->toHtml();
        $this->assertContains('class="form-control input-name-component ' . $configComponentCLass . '"', $html);
    }

    public function testSetComponentClass()
    {
        $configComponentCLass = 'test-config-class-component';
        $customComponentCLass = 'test-custom-class-component';
        config()->set('bootstrap-components.input_email.class.component', [$customComponentCLass]);
        $html = inputEmail()->name('name')->componentClass([$customComponentCLass])->toHtml();
        $this->assertContains('class="form-control input-name-component ' . $customComponentCLass . '"', $html);
        $this->assertNotContains('class="form-control input-name-component ' . $configComponentCLass . '"', $html);
    }

    public function testConfigContainerHtmlAttributes()
    {
        $configContainerAttributes = 'test-config-attributes-container';
        config()->set('bootstrap-components.input_email.html_attributes.container', [$configContainerAttributes]);
        $html = inputEmail()->name('name')->toHtml();
        $this->assertContains($configContainerAttributes, $html);
    }

    public function testSetContainerHtmlAttributes()
    {
        $configContainerAttributes = 'test-config-attributes-container';
        $customContainerAttributes = 'test-custom-attributes-container';
        config()->set('bootstrap-components.input_email.html_attributes.container', [$configContainerAttributes]);
        $html = inputEmail()->name('name')->containerHtmlAttributes([$customContainerAttributes])->toHtml();
        $this->assertContains($customContainerAttributes, $html);
        $this->assertNotContains($configContainerAttributes, $html);
    }

    public function testConfigComponentHtmlAttributes()
    {
        $configComponentAttributes = 'test-config-attributes-component';
        config()->set('bootstrap-components.input_email.html_attributes.component', [$configComponentAttributes]);
        $html = inputEmail()->name('name')->toHtml();
        $this->assertContains($configComponentAttributes, $html);
    }

    public function testSetComponentHtmlAttributes()
    {
        $configComponentAttributes = 'test-config-attributes-component';
        $customComponentAttributes = 'test-custom-attributes-component';
        config()->set('bootstrap-components.input_email.html_attributes.component', [$configComponentAttributes]);
        $html = inputEmail()->name('name')->componentHtmlAttributes([$customComponentAttributes])->toHtml();
        $this->assertContains($customComponentAttributes, $html);
        $this->assertNotContains($configComponentAttributes, $html);
    }
}
