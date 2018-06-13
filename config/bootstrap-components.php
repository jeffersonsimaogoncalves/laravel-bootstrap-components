<?php

return [
    // form components *************************************************************************************************
    'form'   => [
        'text'     => [
            'view'            => 'bootstrap-components.form.input',
            'icon'            => '<i class="fas fa-font"></i>',
            'legend'          => null,
            'class'           => [
                'container' => ['form-group'],
                'component' => [],
            ],
            'html_attributes' => [
                'container' => [],
                'component' => [],
            ],
        ],
        'tel'      => [
            'view'            => 'bootstrap-components.form.input',
            'icon'            => '<i class="fas fa-phone"></i>',
            'legend'          => null,
            'class'           => [
                'container' => ['form-group'],
                'component' => [],
            ],
            'html_attributes' => [
                'container' => [],
                'component' => [],
            ],
        ],
        'email'    => [
            'view'            => 'bootstrap-components.form.input',
            'icon'            => '<i class="fas fa-at"></i>',
            'legend'          => null,
            'class'           => [
                'container' => ['form-group'],
                'component' => [],
            ],
            'html_attributes' => [
                'container' => [],
                'component' => [],
            ],
        ],
        'password' => [
            'view'            => 'bootstrap-components.form.input',
            'icon'            => '<i class="fas fa-user-secret"></i>',
            'legend'          => null,
            'class'           => [
                'container' => ['form-group'],
                'component' => [],
            ],
            'html_attributes' => [
                'container' => [],
                'component' => [],
            ],
        ],
        'file'     => [
            'view'            => 'bootstrap-components.form.file',
            'icon'            => '<i class="fas fa-upload"></i>',
            'legend'          => null,
            'class'           => [
                'container' => ['form-group'],
                'component' => [],
            ],
            'html_attributes' => [
                'container' => [],
                'component' => [],
            ],
        ],
        'textarea' => [
            'view'            => 'bootstrap-components.form.textarea',
            'icon'            => '<i class="fas fa-comment"></i>',
            'legend'          => null,
            'class'           => [
                'container' => ['form-group'],
                'component' => [],
            ],
            'html_attributes' => [
                'container' => [],
                'component' => [],
            ],
        ],
        'checkbox'   => [
            'view'            => 'bootstrap-components.form.checkbox',
            'legend'          => null,
            'class'           => [
                'container' => ['form-group'],
                'component' => [],
            ],
            'html_attributes' => [
                'container' => [],
                'component' => [],
            ],
        ],
        'toggle'   => [
            'view'            => 'bootstrap-components.form.toggle',
            'legend'          => null,
            'class'           => [
                'container' => ['form-group'],
                'component' => [],
            ],
            'html_attributes' => [
                'container' => [],
                'component' => [],
            ],
        ],
    ],
    // buttons components **********************************************************************************************
    'button' => [
        'validate' => [
            'view'            => 'bootstrap-components.buttons.button',
            'icon'            => '<i class="fas fa-fw fa-check"></i>',
            'label'           => 'bootstrap-components.label.validate',
            'class'           => [
                'container' => ['form-group'],
                'component' => ['btn', 'btn-primary'],
            ],
            'html_attributes' => [
                'container' => [],
                'component' => [],
            ],
        ],
        'create'   => [
            'view'            => 'bootstrap-components.buttons.button',
            'icon'            => '<i class="fas fa-fw fa-plus-circle"></i>',
            'label'           => 'bootstrap-components.label.create',
            'class'           => [
                'container' => ['form-group'],
                'component' => ['btn', 'btn-primary'],
            ],
            'html_attributes' => [
                'container' => [],
                'component' => [],
            ],
        ],
        'update'   => [
            'view'            => 'bootstrap-components.buttons.button',
            'icon'            => '<i class="fas fa-fw fa-save"></i>',
            'label'           => 'bootstrap-components.label.update',
            'class'           => [
                'container' => ['form-group'],
                'component' => ['btn', 'btn-primary'],
            ],
            'html_attributes' => [
                'container' => [],
                'component' => [],
            ],
        ],
        'back'     => [
            'view'            => 'bootstrap-components.buttons.button',
            'icon'            => '<i class="fas fa-fw fa-undo"></i>',
            'label'           => 'bootstrap-components.label.back',
            'class'           => [
                'container' => ['form-group'],
                'component' => ['btn', 'btn-light'],
            ],
            'html_attributes' => [
                'container' => [],
                'component' => [],
            ],
        ],
        'cancel'   => [
            'view'            => 'bootstrap-components.buttons.button',
            'icon'            => '<i class="fas fa-fw fa-ban"></i>',
            'label'           => 'bootstrap-components.label.cancel',
            'class'           => [
                'container' => ['form-group'],
                'component' => ['btn', 'btn-danger'],
            ],
            'html_attributes' => [
                'container' => [],
                'component' => [],
            ],
        ],
    ],
    // media components ************************************************************************************************
    'media'  => [

        'audio' => [
            'view'            => 'bootstrap-components.media.audio',
            'class'           => [
                'container' => [],
                'component' => [],
            ],
            'html_attributes' => [
                'container' => [],
                'component' => ['controls', 'preload' => true],
            ],
        ],
        'image' => [
            'view'            => 'bootstrap-components.media.image',
            'class'           => [
                'container' => [],
                'link'      => [],
                'component' => [],
            ],
            'html_attributes' => [
                'container' => [],
                'link'      => [],
                'component' => [],
            ],
        ],
        'video' => [
            'view'            => 'bootstrap-components.media.video',
            'poster'          => null,
            'class'           => [
                'container' => [],
                'component' => [],
            ],
            'html_attributes' => [
                'container' => [],
                'component' => ['controls', 'preload' => true],
            ],
        ],
    ],
];
