<?php

namespace Okipa\LaravelBootstrapComponents\Form;

use InvalidArgumentException;

class Select extends Input
{
    /**
     * The component config key.
     *
     * @property string $view
     */
    protected $configKey = 'form.select';
    /**
     * The input type.
     *
     * @property string $type
     */
    protected $type = 'select';
    /**
     * The select options list.
     *
     * @property iterable $options
     */
    protected $options;
    /**
     * The select options value field.
     *
     * @property string $optionValueField
     */
    protected $optionValueField;
    /**
     * The select options label field.
     *
     * @property string $optionLabelField
     */
    protected $optionLabelField;
    /**
     * The selected options value field.
     *
     * @property string $optionSelectedValueField
     */
    protected $selectedFieldToCompare;
    /**
     * The selected options value field.
     *
     * @property string $optionSelectedValueField
     */
    protected $selectedValueToCompare;

    /**
     * @param iterable $optionsList
     * @param string   $optionValueField
     * @param string   $optionLabelField
     *
     * @return \Okipa\LaravelBootstrapComponents\Form\Select
     */
    public function options(iterable $optionsList, string $optionValueField, string $optionLabelField): Select
    {
        $this->options = json_decode(json_encode($optionsList), true);
        $this->optionValueField = $optionValueField;
        $this->optionLabelField = $optionLabelField;

        return $this;
    }

    public function selected(string $fieldToCompare, $valueToCompare)
    {
        $this->selectedFieldToCompare = $fieldToCompare;
        $this->selectedValueToCompare = $valueToCompare;

        return $this;
    }

    /**
     * Set the input values.
     *
     * @return array
     */
    protected function values(): array
    {
        $this->setOptionsSelectedStatus();

        return array_merge(parent::values(), [
            'options'          => $this->options ? $this->options : [],
            'optionValueField' => $this->optionValueField,
            'optionLabelField' => $this->optionLabelField,
        ]);
    }

    /**
     * Set selected options statuses.
     *
     * @return void
     */
    protected function setOptionsSelectedStatus(): void
    {
        if ($this->options) {
            array_walk($this->options, function(&$option) {
                if (
                    isset($this->selectedFieldToCompare) && isset($this->selectedValueToCompare)
                    && $option[$this->selectedFieldToCompare] === $this->selectedValueToCompare
                ) {
                    $option['selected'] = true;
                } elseif (
                    $this->model
                    && $option[$this->optionValueField] === $this->model->{$this->optionValueField}
                ) {
                    $option['selected'] = true;
                } else {
                    $option['selected'] = false;
                }
            });
        }
    }

    /**
     * Check the component values validity
     *
     * @throws \Exception
     * @return void
     */
    protected function checkValuesValidity(): void
    {
        parent::checkValuesValidity();

        if ($this->options) {
            foreach ($this->options as $option) {
                if (empty($option[$this->optionValueField])) {
                    throw new InvalidArgumentException(
                        get_class($this) . ' : Invalid options() second $optionValueField argument. « '
                        . $this->optionValueField . ' »  does not exist the given first $optionsList argument.'
                    );
                }
                if (empty($option[$this->optionLabelField])) {
                    throw new InvalidArgumentException(
                        get_class($this) . ' : Invalid options() third $optionLabelField argument. « '
                        . $this->optionLabelField . ' »  does not exist the given first $optionsList argument.');
                }
                if ($this->selectedFieldToCompare && empty($option[$this->selectedFieldToCompare])) {
                    throw new InvalidArgumentException(
                        get_class($this) . ' : Invalid selected() first $fieldToCompare argument. « '
                        . $this->selectedFieldToCompare . ' »  does not exist the given first options() $optionsList argument.'
                    );
                }
            }
        }
    }
}
