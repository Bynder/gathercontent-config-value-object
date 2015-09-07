<?php

namespace GatherContent\ConfigValueObject;

final class Validator
{
    public function validate($config)
    {
        $this->validateConfigNotEmpty($config);
        $this->validateTabFormat($config);
        $this->validateUniqueTabNames($config);
        $this->validateElementFormat($config);
        $this->validateUniqueElementNames($config);
        $this->validateUniqueOptionNames($config);
    }

    private function validateConfigNotEmpty($config)
    {
        Assertion::isArray($config, 'Config must be array');
        Assertion::notEmpty($config, 'Config must not be empty');
    }

    private function validateTabFormat($config)
    {
        foreach ($config as $tab) {

            Assertion::isObject($tab, 'Tab must be an object');
            Assertion::keyExists(get_object_vars($tab), 'label', 'Tab label attribute is required');
            Assertion::keyExists(get_object_vars($tab), 'name', 'Tab name attribute is required');
            Assertion::keyExists(get_object_vars($tab), 'hidden', 'Tab hidden attribute is required');
            Assertion::keyExists(get_object_vars($tab), 'elements', 'Tab elements attribute is required');
            Assertion::eq(count(get_object_vars($tab)), 4, 'Tab must not have additional attributes');
            Assertion::string($tab->label, 'Tab label attribute must be string');
            Assertion::string($tab->name, 'Tab name attribute must be string');
            Assertion::boolean($tab->hidden, 'Tab hidden attribute must be boolean');
            Assertion::isArray($tab->elements, 'Tab elements attribute must be array');
            Assertion::notBlank($tab->label, 'Tab label attribute must not be empty');
            Assertion::notBlank($tab->name, 'Tab name attribute must not be empty');
        }
    }

    private function validateUniqueTabNames($config)
    {
        $names = array();

        foreach ($config as $tab) {

            if (in_array($tab->name, $names)) {
                throw new ConfigValueException('Tab names must be unique');
            }

            $names[] = $tab->name;
        }
    }

    private function validateElementFormat($config)
    {
        foreach ($config as $tab) {

            if (count($tab->elements) > 0) {

                foreach ($tab->elements as $element) {

                    Assertion::isObject($element, 'Element must be an object');
                    Assertion::keyExists(get_object_vars($element), 'type', 'Element type attribute is required');
                    Assertion::keyExists(get_object_vars($element), 'name', 'Element name attribute is required');
                    Assertion::string($element->type, 'Element type attribute must be string');
                    Assertion::string($element->name, 'Element name attribute must be string');
                    Assertion::inArray($element->type, array('text', 'files', 'section', 'choice_radio', 'choice_checkbox'), 'Element must be of a supported type');
                    Assertion::notBlank($element->name, 'Element name attribute must not be empty');

                    switch ($element->type) {

                        case 'text':
                            $this->validateTextElement($element);
                            break;

                        case 'files':
                            $this->validateFilesElement($element);
                            break;

                        case 'section':
                            $this->validateSectionElement($element);
                            break;

                        case 'choice_radio':
                            $this->validateChoiceRadioElement($element);
                            $this->validateMaxOneOptionSelectedForChoiceRadioElement($element);
                            $this->validateOtherOptionValueEmptyIfOtherOptionNotSelected($element);
                            $this->validateOtherOptionNotTheOnlyOption($element);
                            break;

                        case 'choice_checkbox':
                            $this->validateChoiceCheckboxElement($element);
                            break;
                    }
                }
            }
        }
    }

    private function validateTextElement($element)
    {
        Assertion::keyExists(get_object_vars($element), 'required', 'Element required attribute is required');
        Assertion::keyExists(get_object_vars($element), 'label', 'Element label attribute is required');
        Assertion::keyExists(get_object_vars($element), 'value', 'Element value attribute is required');
        Assertion::keyExists(get_object_vars($element), 'microcopy', 'Element microcopy attribute is required');
        Assertion::keyExists(get_object_vars($element), 'limit_type', 'Element limit_type attribute is required');
        Assertion::keyExists(get_object_vars($element), 'limit', 'Element limit attribute is required');
        Assertion::keyExists(get_object_vars($element), 'plain_text', 'Element plain_text attribute is required');
        Assertion::eq(count(get_object_vars($element)), 9, 'Element must not have additional attributes');
        Assertion::boolean($element->required, 'Element required attribute must be boolean');
        Assertion::string($element->label, 'Element label attribute must be string');
        Assertion::string($element->value, 'Element value attribute must be string');
        Assertion::string($element->microcopy, 'Element microcopy attribute must be string');
        Assertion::string($element->limit_type, 'Element limit_type attribute must be string');
        Assertion::integer($element->limit, 'Element limit attribute must be integer');
        Assertion::boolean($element->plain_text, 'Element plain_text attribute must be boolean');
        Assertion::notBlank($element->label, 'Element label attribute must not be empty');
        Assertion::inArray($element->limit_type, array('words', 'chars'), 'Element limit_type attribute value must be either "words" or "chars"');
        Assertion::min($element->limit, 0, 'Element limit attribute must not be negative');
    }

    private function validateFilesElement($element)
    {
        Assertion::keyExists(get_object_vars($element), 'required', 'Element required attribute is required');
        Assertion::keyExists(get_object_vars($element), 'label', 'Element label attribute is required');
        Assertion::keyExists(get_object_vars($element), 'microcopy', 'Element microcopy attribute is required');
        Assertion::eq(count(get_object_vars($element)), 5, 'Element must not have additional attributes');
        Assertion::boolean($element->required, 'Element required attribute must be boolean');
        Assertion::string($element->label, 'Element label attribute must be string');
        Assertion::string($element->microcopy, 'Element microcopy attribute must be string');
        Assertion::notBlank($element->label, 'Element label attribute must not be empty');
    }

    private function validateSectionElement($element)
    {
        Assertion::keyExists(get_object_vars($element), 'title', 'Element title attribute is required');
        Assertion::keyExists(get_object_vars($element), 'subtitle', 'Element subtitle attribute is required');
        Assertion::eq(count(get_object_vars($element)), 4, 'Element must not have additional attributes');
        Assertion::string($element->title, 'Element title attribute must be string');
        Assertion::string($element->subtitle, 'Element subtitle attribute must be string');
        Assertion::notBlank($element->title, 'Element title attribute must not be empty');
    }

    private function validateChoiceRadioElement($element)
    {
        Assertion::keyExists(get_object_vars($element), 'required', 'Element required attribute is required');
        Assertion::keyExists(get_object_vars($element), 'label', 'Element label attribute is required');
        Assertion::keyExists(get_object_vars($element), 'microcopy', 'Element microcopy attribute is required');
        Assertion::keyExists(get_object_vars($element), 'other_option', 'Element other_option attribute is required');
        Assertion::keyExists(get_object_vars($element), 'options', 'Element options attribute is required');
        Assertion::eq(count(get_object_vars($element)), 7, 'Element must not have additional attributes');
        Assertion::boolean($element->required, 'Element required attribute must be boolean');
        Assertion::string($element->label, 'Element label attribute must be string');
        Assertion::string($element->microcopy, 'Element microcopy attribute must be string');
        Assertion::boolean($element->other_option, 'Element other_option attribute must be boolean');
        Assertion::isArray($element->options, 'Element options attribute must be array');
        Assertion::notBlank($element->label, 'Element label attribute must not be empty');
        Assertion::notEmpty($element->options, 'Element must have at least one option');

        foreach ($element->options as $option) {
            $this->validateOptionFormatForChoiceRadio($option, $element);
        }
    }

    private function validateMaxOneOptionSelectedForChoiceRadioElement($element)
    {
        $selectedCounter = 0;

        if (count($element->options) > 1) {

            foreach ($element->options as $option) {

                if ($option->selected) {
                    $selectedCounter++;
                }
            }

            if ($selectedCounter > 1) {
                throw new ConfigValueException('Element choice_radio must have at most one option selected');
            }
        }
    }

    private function validateOtherOptionValueEmptyIfOtherOptionNotSelected($element)
    {
        if ($element->other_option) {

            $lastOption = end($element->options);

            if ($lastOption->selected == false && strlen($lastOption->value) > 0) {
                throw new ConfigValueException('Other option value must be empty when other option not selected');
            }
        }
    }

    private function validateOtherOptionNotTheOnlyOption($element)
    {
        if ($element->other_option && count($element->options) == 1) {
            throw new ConfigValueException('Other option must not be the only option');
        }
    }

    private function validateChoiceCheckboxElement($element)
    {
        Assertion::keyExists(get_object_vars($element), 'required', 'Element required attribute is required');
        Assertion::keyExists(get_object_vars($element), 'label', 'Element label attribute is required');
        Assertion::keyExists(get_object_vars($element), 'microcopy', 'Element microcopy attribute is required');
        Assertion::keyExists(get_object_vars($element), 'options', 'Element options attribute is required');
        Assertion::eq(count(get_object_vars($element)), 6, 'Element must not have additional attributes');
        Assertion::boolean($element->required, 'Element required attribute must be boolean');
        Assertion::string($element->label, 'Element label attribute must be string');
        Assertion::string($element->microcopy, 'Element microcopy attribute must be string');
        Assertion::isArray($element->options, 'Element options attribute must be array');
        Assertion::notBlank($element->label, 'Element label attribute must not be empty');
        Assertion::notEmpty($element->options, 'Element must have at least one option');

        foreach ($element->options as $option) {
            $this->validateOptionFormatForChoiceCheckbox($option);
        }
    }

    private function validateUniqueElementNames($config)
    {
        $names = array();

        foreach ($config as $tab) {

            if (count($tab->elements) > 0) {

                foreach ($tab->elements as $element) {

                    if (in_array($element->name, $names)) {
                        throw new ConfigValueException('Element names must be unique');
                    }

                    $names[] = $element->name;
                }
            }
        }
    }

    private function validateOptionFormatForChoiceRadio($option, $element)
    {
        Assertion::isObject($option, 'Option must be an object');
        Assertion::keyExists(get_object_vars($option), 'name', 'Option name attribute is required');
        Assertion::keyExists(get_object_vars($option), 'label', 'Option label attribute is required');
        Assertion::keyExists(get_object_vars($option), 'selected', 'Option selected attribute is required');
        Assertion::string($option->name, 'Option name attribute must be string');
        Assertion::string($option->label, 'Option label attribute must be string');
        Assertion::boolean($option->selected, 'Option selected attribute must be boolean');
        Assertion::notBlank($option->name, 'Option name attribute must not be empty');
        Assertion::notBlank($option->label, 'Option label attribute must not be empty');

        if ($element->other_option && json_encode($option) == json_encode(end($element->options))) {

            Assertion::keyExists(get_object_vars($option), 'value', 'Option value attribute is required');
            Assertion::string($option->value, 'Option value attribute must be string');
            Assertion::eq(count(get_object_vars($option)), 4, 'Option must not have additional attributes');

        } else {

            Assertion::eq(count(get_object_vars($option)), 3, 'Option must not have additional attributes');
        }
    }

    private function validateOptionFormatForChoiceCheckbox($option)
    {
        Assertion::isObject($option, 'Option must be an object');
        Assertion::keyExists(get_object_vars($option), 'name', 'Option name attribute is required');
        Assertion::keyExists(get_object_vars($option), 'label', 'Option label attribute is required');
        Assertion::keyExists(get_object_vars($option), 'selected', 'Option selected attribute is required');
        Assertion::string($option->name, 'Option name attribute must be string');
        Assertion::string($option->label, 'Option label attribute must be string');
        Assertion::boolean($option->selected, 'Option selected attribute must be boolean');
        Assertion::notBlank($option->name, 'Option name attribute must not be empty');
        Assertion::notBlank($option->label, 'Option label attribute must not be empty');
        Assertion::eq(count(get_object_vars($option)), 3, 'Option must not have additional attributes');
    }

    private function validateUniqueOptionNames($config)
    {
        $names = array();

        foreach ($config as $tab) {

            if (count($tab->elements) > 0) {

                foreach ($tab->elements as $element) {

                    if (in_array($element->type, array('choice_radio', 'choice_checkbox'))) {

                        foreach ($element->options as $option) {

                            if (in_array($option->name, $names)) {
                                throw new ConfigValueException('Option names must be unique');
                            }

                            $names[] = $option->name;
                        }
                    }
                }
            }
        }
    }
}
