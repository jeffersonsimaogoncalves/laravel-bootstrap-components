<?php

namespace Okipa\LaravelBootstrapComponents\Tests\Unit\Form;

use Illuminate\Support\MessageBag;
use Okipa\LaravelBootstrapComponents\Form\Input;
use Okipa\LaravelBootstrapComponents\Test\BootstrapComponentsTestCase;
use Okipa\LaravelBootstrapComponents\Test\Fakers\UsersFaker;

class PasswordTest extends BootstrapComponentsTestCase
{
    use UsersFaker;

    public function testConfigStructure()
    {
        // components.form
        $this->assertTrue(array_key_exists('password', config('bootstrap-components.form')));
        // components.form.password
        $this->assertTrue(array_key_exists('view', config('bootstrap-components.form.password')));
        $this->assertTrue(array_key_exists('icon', config('bootstrap-components.form.password')));
        $this->assertTrue(array_key_exists('legend', config('bootstrap-components.form.password')));
        $this->assertTrue(array_key_exists('class', config('bootstrap-components.form.password')));
        $this->assertTrue(array_key_exists('html_attributes', config('bootstrap-components.form.password')));
        // components.form.password.class
        $this->assertTrue(array_key_exists('container', config('bootstrap-components.form.password.class')));
        $this->assertTrue(array_key_exists('component', config('bootstrap-components.form.password.class')));
        // components.form.password.html_attributes
        $this->assertTrue(array_key_exists('container', config('bootstrap-components.form.password.html_attributes')));
        $this->assertTrue(array_key_exists('component', config('bootstrap-components.form.password.html_attributes')));
    }

    public function testExtendsInput()
    {
        $this->assertEquals(Input::class, get_parent_class(password()));
    }

    public function testSetName()
    {
        $html = password()->name('name')->toHtml();
        $this->assertContains('name="name"', $html);
    }

    public function testType()
    {
        $html = password()->name('name')->toHtml();
        $this->assertContains('type="password"', $html);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Okipa\LaravelBootstrapComponents\Form\Password : Missing $name property. Please use
     *                           the name() method to set a name.
     */
    public function testInputWithoutName()
    {
        password()->toHtml();
    }

    public function testModelValue()
    {
        $user = $this->createUniqueUser();
        $html = password()->model($user)->name('name')->toHtml();
        $this->assertContains('value="' . $user->name . '"', $html);
    }

    public function testConfigIcon()
    {
        $configIcon = 'test-config-icon';
        config()->set('bootstrap-components.form.password.icon', $configIcon);
        $html = password()->name('name')->toHtml();
        $this->assertContains('<span class="icon input-group-text">' . $configIcon . '</span>', $html);
    }

    public function testSetIcon()
    {
        $configIcon = 'test-config-icon';
        $customIcon = 'test-custom-icon';
        config()->set('bootstrap-components.form.password.icon', $configIcon);
        $html = password()->name('name')->icon($customIcon)->toHtml();
        $this->assertContains('<span class="icon input-group-text">' . $customIcon . '</span>', $html);
        $this->assertNotContains('<span class="icon input-group-text">' . $configIcon . '</span>', $html);
    }

    public function testNoIcon()
    {
        config()->set('bootstrap-components.form.password.icon', null);
        $html = password()->name('name')->toHtml();
        $this->assertNotContains('<span class="icon input-group-text">', $html);
    }

    public function testHideIcon()
    {
        $configIcon = 'test-config-icon';
        config()->set('bootstrap-components.form.password.icon', $configIcon);
        $html = password()->name('name')->hideIcon()->toHtml();
        $this->assertNotContains('<span class="icon input-group-text">' . $configIcon . '</span>', $html);
    }

    public function testConfigLegend()
    {
        $configLegend = 'test-config-legend';
        config()->set('bootstrap-components.form.password.legend', $configLegend);
        $html = password()->name('name')->toHtml();
        $this->assertContains(
            '<small id="password-name-legend" class="form-text text-muted">' . $configLegend . '</small>',
            $html
        );
    }

    public function testSetLegend()
    {
        $configLegend = 'test-config-legend';
        $customLegend = 'test-custom-legend';
        config()->set('bootstrap-components.form.password.legend', $configLegend);
        $html = password()->name('name')->legend($customLegend)->toHtml();
        $this->assertContains(
            '<small id="password-name-legend" class="form-text text-muted">' . $customLegend . '</small>',
            $html
        );
        $this->assertNotContains(
            '<small id="password-name-legend" class="form-text text-muted">' . $configLegend . '</small>',
            $html
        );
    }

    public function testNoLegend()
    {
        config()->set('bootstrap-components.form.password.legend', null);
        $html = password()->name('name')->toHtml();
        $this->assertNotContains('<small id="password-name-legend" class="form-text text-muted">', $html);
    }

    public function testHideLegend()
    {
        $configLegend = 'test-config-legend';
        config()->set('bootstrap-components.form.password.legend', $configLegend);
        $html = password()->name('name')->hideLegend()->toHtml();
        $this->assertNotContains(
            '<small id="password-name-legend" class="form-text text-muted">' . $configLegend . '</small>',
            $html
        );
    }

    public function testSetPlaceholder()
    {
        $placeholder = 'test-custom-placeholder';
        $html = password()->name('name')->placeholder($placeholder)->toHtml();
        $this->assertContains('placeholder="' . $placeholder . '"', $html);
        $this->assertNotContains(
            'placeholder="validation.attributes.name"',
            $html
        );
    }

    public function testNoPlaceholder()
    {
        $html = password()->name('name')->toHtml();
        $this->assertContains(
            'placeholder="validation.attributes.name"',
            $html
        );
    }

    public function testSetValue()
    {
        $customValue = 'test-custom-value';
        $html = password()->name('name')->value($customValue)->toHtml();
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
        $html = password()->name('name')->value($customValue)->toHtml();
        $this->assertContains('value="' . $oldValue . '"', $html);
        $this->assertNotContains('value="' . $customValue . '"', $html);
    }

    public function testSetLabel()
    {
        $label = 'test-custom-label';
        $html = password()->name('name')->label($label)->toHtml();
        $this->assertContains('<label for="password-name">' . $label . '</label>', $html);
        $this->assertContains('aria-label="' . $label . '"', $html);
    }

    public function testNoLabel()
    {
        $html = password()->name('name')->toHtml();
        $this->assertContains(
            '<label for="password-name">validation.attributes.name</label>',
            $html
        );
        $this->assertContains(
            'aria-label="validation.attributes.name"',
            $html
        );
    }

    public function testHideLabel()
    {
        $html = password()->name('name')->hideLabel()->toHtml();
        $this->assertNotContains(
            '<label for="password-name">validation.attributes.name</label>',
            $html
        );
        $this->assertNotContains(
            'aria-label="validation.attributes.name"',
            $html
        );
    }

    public function testSuccess()
    {
        $messageBag = app(MessageBag::class)->add('other_name', null);
        $html = password()->name('name')->render(['errors' => $messageBag]);
        $this->assertContains('<div class="valid-feedback d-block">', $html);
        $this->assertContains(trans('bootstrap-components::bootstrap-components.notification.validation.success'),
            $html);
    }

    public function testNoSuccess()
    {
        $html = password()->name('name')->toHtml();
        $this->assertNotContains('<div class="valid-feedback d-block">', $html);
    }

    public function testError()
    {
        $errorMessage = 'This a test error message';
        $messageBag = app(MessageBag::class)->add('name', $errorMessage);
        $html = password()->name('name')->render(['errors' => $messageBag]);
        $this->assertContains('<div class="invalid-feedback d-block">', $html);
        $this->assertContains($errorMessage, $html);
    }

    public function testNoError()
    {
        $html = password()->name('name')->toHtml();
        $this->assertNotContains('<div class="invalid-feedback d-block">', $html);
    }

    public function testConfigContainerClass()
    {
        $configContainerCLass = 'test-config-class-container';
        config()->set('bootstrap-components.form.password.class.container', [$configContainerCLass]);
        $html = password()->name('name')->toHtml();
        $this->assertContains('class="password-name-container ' . $configContainerCLass . '"', $html);
    }

    public function testSetContainerClass()
    {
        $configContainerCLass = 'test-config-class-container';
        $customContainerCLass = 'test-custom-class-container';
        config()->set('bootstrap-components.form.password.class.container', [$configContainerCLass]);
        $html = password()->name('name')->containerClass([$customContainerCLass])->toHtml();
        $this->assertContains('class="password-name-container ' . $customContainerCLass . '"', $html);
        $this->assertNotContains('class="password-name-container ' . $configContainerCLass . '"', $html);
    }

    public function testConfigComponentClass()
    {
        $configComponentCLass = 'test-config-class-component';
        config()->set('bootstrap-components.form.password.class.component', [$configComponentCLass]);
        $html = password()->name('name')->toHtml();
        $this->assertContains('class="form-control password-name-component ' . $configComponentCLass . '"', $html);
    }

    public function testSetComponentClass()
    {
        $configComponentCLass = 'test-config-class-component';
        $customComponentCLass = 'test-custom-class-component';
        config()->set('bootstrap-components.form.password.class.component', [$customComponentCLass]);
        $html = password()->name('name')->componentClass([$customComponentCLass])->toHtml();
        $this->assertContains('class="form-control password-name-component ' . $customComponentCLass . '"', $html);
        $this->assertNotContains('class="form-control password-name-component ' . $configComponentCLass . '"', $html);
    }

    public function testConfigContainerHtmlAttributes()
    {
        $configContainerAttributes = 'test-config-attributes-container';
        config()->set('bootstrap-components.form.password.html_attributes.container', [$configContainerAttributes]);
        $html = password()->name('name')->toHtml();
        $this->assertContains($configContainerAttributes, $html);
    }

    public function testSetContainerHtmlAttributes()
    {
        $configContainerAttributes = 'test-config-attributes-container';
        $customContainerAttributes = 'test-custom-attributes-container';
        config()->set('bootstrap-components.form.password.html_attributes.container', [$configContainerAttributes]);
        $html = password()->name('name')->containerHtmlAttributes([$customContainerAttributes])->toHtml();
        $this->assertContains($customContainerAttributes, $html);
        $this->assertNotContains($configContainerAttributes, $html);
    }

    public function testConfigComponentHtmlAttributes()
    {
        $configComponentAttributes = 'test-config-attributes-component';
        config()->set('bootstrap-components.form.password.html_attributes.component', [$configComponentAttributes]);
        $html = password()->name('name')->toHtml();
        $this->assertContains($configComponentAttributes, $html);
    }

    public function testSetComponentHtmlAttributes()
    {
        $configComponentAttributes = 'test-config-attributes-component';
        $customComponentAttributes = 'test-custom-attributes-component';
        config()->set('bootstrap-components.form.password.html_attributes.component', [$configComponentAttributes]);
        $html = password()->name('name')->componentHtmlAttributes([$customComponentAttributes])->toHtml();
        $this->assertContains($customComponentAttributes, $html);
        $this->assertNotContains($configComponentAttributes, $html);
    }
}
