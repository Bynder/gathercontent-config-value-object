<?php

namespace GatherContent\ConfigValueObject;

class Config
{
    private $config;

    public function __construct($config)
    {
        $this->validate($config);

        $this->config = $config;
    }

    public static function fromJson($json)
    {
        $config = json_decode($json);

        return new Config($config);
    }

    public function __toString()
    {
        return json_encode($this->config);
    }

    public function toArray()
    {
        return $this->config;
    }

    public function equals(Config $config)
    {
        return strtolower((string) $this) === strtolower((string) $config);
    }

    private function validate($config)
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
        if (!is_array($config)) {
            throw new \DomainException('Config must be array');
        }

        if (count($config) == 0) {
            throw new \DomainException('Config must not be empty');
        }
    }

    private function validateTabFormat($config)
    {
        foreach ($config as $tab) {

            if (!is_object($tab)) {
                throw new \DomainException('Tab must be an object');
            }

            if (!isset($tab->label)) {
                throw new \DomainException('Tab label attribute is required');
            }

            if (!isset($tab->name)) {
                throw new \DomainException('Tab name attribute is required');
            }

            if (!isset($tab->hidden)) {
                throw new \DomainException('Tab hidden attribute is required');
            }

            if (!isset($tab->elements)) {
                throw new \DomainException('Tab elements attribute is required');
            }

            if (count(get_object_vars($tab)) != 4) {
                throw new \DomainException('Tab must not have additional attributes');
            }

            if (!is_string($tab->label)) {
                throw new \DomainException('Tab label attribute must be string');
            }

            if (!is_string($tab->name)) {
                throw new \DomainException('Tab name attribute must be string');
            }

            if (!is_bool($tab->hidden)) {
                throw new \DomainException('Tab hidden attribute must be boolean');
            }

            if (!is_array($tab->elements)) {
                throw new \DomainException('Tab elements attribute must be array');
            }

            if ($tab->label == '') {
                throw new \DomainException('Tab label attribute must not be empty');
            }

            if ($tab->name == '') {
                throw new \DomainException('Tab name attribute must not be empty');
            }
        }
    }

    private function validateUniqueTabNames($config)
    {
        $names = [];

        foreach ($config as $tab) {

            if (in_array($tab->name, $names)) {
                throw new \DomainException('Tab names must be unique');
            }

            $names[] = $tab->name;
        }
    }

    private function validateElementFormat($config)
    {
        foreach ($config as $tab) {

            if (count($tab->elements) > 0) {

                foreach ($tab->elements as $element) {

                    if (!is_object($element)) {
                        throw new \DomainException('Element must be an object');
                    }

                    if (!isset($element->type)) {
                        throw new \DomainException('Element type attribute is required');
                    }

                    if (!isset($element->name)) {
                        throw new \DomainException('Element name attribute is required');
                    }

                    if (!is_string($element->type)) {
                        throw new \DomainException('Element type attribute must be string');
                    }

                    if (!is_string($element->name)) {
                        throw new \DomainException('Element name attribute must be string');
                    }

                    if (!in_array($element->type, ['text', 'files', 'section', 'choice_radio', 'choice_checkbox'])) {
                        throw new \DomainException('Element must be of a supported type');
                    }

                    if ($element->name == '') {
                        throw new \DomainException('Element name attribute must not be empty');
                    }

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
                            $this->validateOtherOptionValuePresentForChoiceRadioElement($element);
                            $this->validateRegularOptionValueNotPresentForChoiceRadioElement($element);
                            $this->validateOtherOptionValuePresentOnlyOnTheLastOptionForChoiceRadioElement($element);
                            $this->validateOtherOptionValueEmptyIfOtherOptionNotSelected($element);
                            break;

                        case 'choice_checkbox':
                            $this->validateChoiceCheckboxElement($element);
                            break;

                        default:
                            throw new \DomainException('Element must be of a supported type');
                            break;
                    }
                }
            }
        }
    }

    private function validateTextElement($element)
    {
        if (!isset($element->required)) {
            throw new \DomainException('Element required attribute is required');
        }

        if (!isset($element->label)) {
            throw new \DomainException('Element label attribute is required');
        }

        if (!isset($element->value)) {
            throw new \DomainException('Element value attribute is required');
        }

        if (!isset($element->microcopy)) {
            throw new \DomainException('Element microcopy attribute is required');
        }

        if (!isset($element->limit_type)) {
            throw new \DomainException('Element limit_type attribute is required');
        }

        if (!isset($element->limit)) {
            throw new \DomainException('Element limit attribute is required');
        }

        if (!isset($element->plain_text)) {
            throw new \DomainException('Element plain_text attribute is required');
        }

        if (count(get_object_vars($element)) != 9) {
            throw new \DomainException('Element must not have additional attributes');
        }

        if (!is_bool($element->required)) {
            throw new \DomainException('Element required attribute must be boolean');
        }

        if (!is_string($element->label)) {
            throw new \DomainException('Element label attribute must be string');
        }

        if (!is_string($element->value)) {
            throw new \DomainException('Element value attribute must be string');
        }

        if (!is_string($element->microcopy)) {
            throw new \DomainException('Element microcopy attribute must be string');
        }

        if (!is_string($element->limit_type)) {
            throw new \DomainException('Element limit_type attribute must be string');
        }

        if (!is_int($element->limit)) {
            throw new \DomainException('Element limit attribute must be string');
        }

        if (!is_bool($element->plain_text)) {
            throw new \DomainException('Element plain_text attribute must be boolean');
        }

        if (!in_array($element->limit_type, ['words', 'chars'])) {
            throw new \DomainException('Element limit_type attribute must be either "words" or "chars"');
        }

        if ($element->limit < 0) {
            throw new \DomainException('Element limit attribute must not be negative');
        }
    }

    private function validateFilesElement($element)
    {
        if (!isset($element->required)) {
            throw new \DomainException('Element required attribute is required');
        }

        if (!isset($element->label)) {
            throw new \DomainException('Element label attribute is required');
        }

        if (!isset($element->microcopy)) {
            throw new \DomainException('Element microcopy attribute is required');
        }

        if (count(get_object_vars($element)) != 5) {
            throw new \DomainException('Element must not have additional attributes');
        }

        if (!is_bool($element->required)) {
            throw new \DomainException('Element required attribute must be boolean');
        }

        if (!is_string($element->label)) {
            throw new \DomainException('Element label attribute must be string');
        }

        if (!is_string($element->microcopy)) {
            throw new \DomainException('Element microcopy attribute must be string');
        }
    }

    private function validateSectionElement($element)
    {
        if (!isset($element->title)) {
            throw new \DomainException('Element title attribute is required');
        }

        if (!isset($element->subtitle)) {
            throw new \DomainException('Element subtitle attribute is required');
        }

        if (count(get_object_vars($element)) != 4) {
            throw new \DomainException('Element must not have additional attributes');
        }

        if (!is_string($element->title)) {
            throw new \DomainException('Element title attribute must be string');
        }

        if (!is_string($element->subtitle)) {
            throw new \DomainException('Element subtitle attribute must be string');
        }
    }

    private function validateChoiceRadioElement($element)
    {
        if (!isset($element->required)) {
            throw new \DomainException('Element required attribute is required');
        }

        if (!isset($element->label)) {
            throw new \DomainException('Element label attribute is required');
        }

        if (!isset($element->microcopy)) {
            throw new \DomainException('Element microcopy attribute is required');
        }

        if (!isset($element->other_option)) {
            throw new \DomainException('Element other_option attribute is required');
        }

        if (!isset($element->options)) {
            throw new \DomainException('Element options attribute is required');
        }

        if (count(get_object_vars($element)) != 7) {
            throw new \DomainException('Element must not have additional attributes');
        }

        if (!is_bool($element->required)) {
            throw new \DomainException('Element required attribute must be boolean');
        }

        if (!is_string($element->label)) {
            throw new \DomainException('Element label attribute must be string');
        }

        if (!is_string($element->microcopy)) {
            throw new \DomainException('Element microcopy attribute must be string');
        }

        if (!is_bool($element->other_option)) {
            throw new \DomainException('Element other_option attribute must be boolean');
        }

        if (!is_array($element->options)) {
            throw new \DomainException('Element options attribute must be array');
        }

        if (count($element->options) == 0) {
            throw new \DomainException('Element must have at least one option');
        }

        foreach ($element->options as $option) {
            $this->validateOptionFormat($option);
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
                throw new \DomainException('Element checkbox_radio must have at most one option selected');
            }
        }
    }

    private function validateOtherOptionValuePresentForChoiceRadioElement($element)
    {
        if ($element->other_option) {

            $lastOption = end($element->options);

            if (!isset($lastOption->value)) {
                throw new \DomainException('Other option value is required');
            }
        }
    }

    private function validateRegularOptionValueNotPresentForChoiceRadioElement($element)
    {
        if (!$element->other_option) {

            $lastOption = end($element->options);

            if (isset($lastOption->value)) {
                throw new \DomainException('Option value must not be present for regular option');
            }
        }
    }

    private function validateOtherOptionValuePresentOnlyOnTheLastOptionForChoiceRadioElement($element)
    {
        $options = array_slice($element->options, 0, -1);

        if (count($options) > 0) {

            foreach ($options as $option) {

                if (isset($option->value)) {

                    throw new \DomainException('Option value must not be present for regular option');
                }
            }
        }
    }

    private function validateOtherOptionValueEmptyIfOtherOptionNotSelected($element)
    {
        if ($element->other_option) {

            $lastOption = end($element->options);

            if ($lastOption->selected == false && strlen($lastOption->value) > 0) {
                throw new \DomainException('Other option value must be empty when other option not selected');
            }
        }
    }

    private function validateChoiceCheckboxElement($element)
    {
        if (!isset($element->required)) {
            throw new \DomainException('Element required attribute is required');
        }

        if (!isset($element->label)) {
            throw new \DomainException('Element label attribute is required');
        }

        if (!isset($element->microcopy)) {
            throw new \DomainException('Element microcopy attribute is required');
        }

        if (!isset($element->options)) {
            throw new \DomainException('Element options attribute is required');
        }

        if (count(get_object_vars($element)) != 6) {
            throw new \DomainException('Element must not have additional attributes');
        }

        if (!is_bool($element->required)) {
            throw new \DomainException('Element required attribute must be boolean');
        }

        if (!is_string($element->label)) {
            throw new \DomainException('Element label attribute must be string');
        }

        if (!is_string($element->microcopy)) {
            throw new \DomainException('Element microcopy attribute must be string');
        }

        if (!is_array($element->options)) {
            throw new \DomainException('Element options attribute must be array');
        }

        if (count($element->options) == 0) {
            throw new \DomainException('Element must have at least one option');
        }

        foreach ($element->options as $option) {
            $this->validateOptionFormat($option);
        }
    }

    private function validateUniqueElementNames($config)
    {
        $names = [];

        foreach ($config as $tab) {

            if (count($tab->elements) > 0) {

                foreach ($tab->elements as $element) {

                    if (in_array($element->name, $names)) {
                        throw new \DomainException('Element names must be unique');
                    }

                    $names[] = $element->name;
                }
            }
        }
    }

    private function validateOptionFormat($option)
    {
        if (!is_object($option)) {
            throw new \DomainException('Option must be an object');
        }

        if (!isset($option->name)) {
            throw new \DomainException('Option name attribute is required');
        }

        if (!isset($option->label)) {
            throw new \DomainException('Option label attribute is required');
        }

        if (!isset($option->selected)) {
            throw new \DomainException('Option selected attribute is required');
        }

        if (!is_string($option->name)) {
            throw new \DomainException('Option name attribute must be string');
        }

        if (!is_string($option->label)) {
            throw new \DomainException('Option label attribute must be string');
        }

        if (!is_bool($option->selected)) {
            throw new \DomainException('Option selected attribute must be boolean');
        }

        if ($option->name == '') {
            throw new \DomainException('Option name attribute must not be empty');
        }

        if (count(get_object_vars($option)) == 4) {

            if (!isset($option->value)) {
                throw new \DomainException('Option value attribute is required');
            }

            if (!is_string($option->value)) {
                throw new \DomainException('Option value attribute must be string');
            }
        }
        else {
            if (count(get_object_vars($option)) != 3) {
                throw new \DomainException('Option must not have additional attributes');
            }
        }
    }

    private function validateUniqueOptionNames($config)
    {
        $names = [];

        foreach ($config as $tab) {

            if (count($tab->elements) > 0) {

                foreach ($tab->elements as $element) {

                    if (in_array($element->type, ['choice_radio', 'choice_checkbox'])) {

                        foreach ($element->options as $option) {

                            if (in_array($option->name, $names)) {
                                throw new \DomainException('Option names must be unique');
                            }

                            $names[] = $option->name;
                        }
                    }
                }
            }
        }
    }

}
