<?php

use GatherContent\ConfigValueObject\Config;

class ConfigTest extends PHPUnit_Framework_TestCase
{
    private $fullConfig;

    public function setUp()
    {
        parent::setUp();

        $this->fullConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'text',
                        'name' => 'el1',
                        'required' => false,
                        'label' => 'Label',
                        'value' => '<p>How goes it?</p>',
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'words',
                        'limit' => 50,
                        'plain_text' => false,
                    ],
                    (object)[
                        'type' => 'text',
                        'name' => 'el2',
                        'required' => false,
                        'label' => 'Label',
                        'value' => 'How goes it?',
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'chars',
                        'limit' => 500,
                        'plain_text' => true,
                    ],
                    (object)[
                        'type' => 'files',
                        'name' => 'el3',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                    ],
                    (object)[
                        'type' => 'section',
                        'name' => 'el4',
                        'title' => 'Title',
                        'subtitle' => '<p>How goes it?</p>',
                    ],
                ],
            ],
            (object)[
                'label' => 'Meta',
                'name' => 'tab2',
                'hidden' => true,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el5',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => false,
                        'options' => [
                            (object)[
                                'name' => 'op1',
                                'label' => 'First choice',
                                'selected' => false,
                            ],
                            (object)[
                                'name' => 'op2',
                                'label' => 'Second choice',
                                'selected' => false,
                            ],
                        ],
                    ],
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el6',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => true,
                        'options' => [
                            (object)[
                                'name' => 'op3',
                                'label' => 'First choice',
                                'selected' => false,
                            ],
                            (object)[
                                'name' => 'op4',
                                'label' => 'Second choice',
                                'selected' => true,
                            ],
                            (object)[
                                'name' => 'op5',
                                'label' => 'Other',
                                'selected' => false,
                                'value' => '',
                            ],
                        ],
                    ],
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el7',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => true,
                        'options' => [
                            (object)[
                                'name' => 'op6',
                                'label' => 'First choice',
                                'selected' => false,
                            ],
                            (object)[
                                'name' => 'op7',
                                'label' => 'Second choice',
                                'selected' => false,
                            ],
                            (object)[
                                'name' => 'op8',
                                'label' => 'Other',
                                'selected' => true,
                                'value' => 'How goes it?',
                            ],
                        ],
                    ],
                    (object)[
                        'type' => 'choice_checkbox',
                        'name' => 'el8',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'options' => [
                            (object)[
                                'name' => 'op9',
                                'label' => 'First choice',
                                'selected' => false,
                            ],
                            (object)[
                                'name' => 'op10',
                                'label' => 'Second choice',
                                'selected' => false,
                            ],
                        ],
                    ],
                    (object)[
                        'type' => 'choice_checkbox',
                        'name' => 'el9',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'options' => [
                            (object)[
                                'name' => 'op11',
                                'label' => 'First choice',
                                'selected' => true,
                            ],
                            (object)[
                                'name' => 'op12',
                                'label' => 'Second choice',
                                'selected' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function testFullConfig()
    {
        $config = new Config($this->fullConfig);
        $result = $config->toArray();

        $this->assertEquals($this->fullConfig, $result);
    }

    public function testCastingToString()
    {
        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [],
            ],
        ];

        $expected = '[{"label":"Content","name":"tab1","hidden":false,"elements":[]}]';

        $config = new Config($originalConfig);
        $result = (string)$config;

        $this->assertEquals($expected, $result);
    }

    public function testEqual()
    {
        $config1 = new Config($this->fullConfig);
        $config2 = new Config($this->fullConfig);

        $result = $config1->equals($config2);

        $this->assertTrue($result);
    }

    public function testNotEqual()
    {
        $originalConfig1 = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [],
            ],
        ];

        $originalConfig2 = [
            (object)[
                'label' => 'Meta',
                'name' => 'tab2',
                'hidden' => false,
                'elements' => [],
            ],
        ];

        $config1 = new Config($originalConfig1);
        $config2 = new Config($originalConfig2);

        $result = $config1->equals($config2);

        $this->assertFalse($result);
    }

    public function testCreatingFromJson()
    {
        $expected = $json = '[{"label":"Content","name":"tab1","hidden":false,"elements":[]}]';

        $config = Config::fromJson($json);
        $result = (string)$config;

        $this->assertEquals($expected, $result);
    }

    public function testEmptyConfig()
    {
        $this->setExpectedException('DomainException');

        $json = '[]';

        $config = Config::fromJson($json);
    }

    public function testRandomArray()
    {
        $this->setExpectedException('DomainException');

        $json = '["a","s","d","f"]';

        $config = Config::fromJson($json);
    }

    public function testString()
    {
        $this->setExpectedException('DomainException');

        $string = 'asdf';

        $config = new Config($string);
    }

    public function testMissingLabel()
    {
        $this->setExpectedException('DomainException');

        unset($this->fullConfig[0]->label);

        $config = new Config($this->fullConfig);
    }

    public function testMissingName()
    {
        $this->setExpectedException('DomainException');

        unset($this->fullConfig[0]->name);

        $config = new Config($this->fullConfig);
    }

    public function testMissingHidden()
    {
        $this->setExpectedException('DomainException');

        unset($this->fullConfig[0]->hidden);

        $config = new Config($this->fullConfig);
    }

    public function testMissingElements()
    {
        $this->setExpectedException('DomainException');

        unset($this->fullConfig[0]->elements);

        $config = new Config($this->fullConfig);
    }

    public function testAdditionalAttribute()
    {
        $this->setExpectedException('DomainException');

        $this->fullConfig[0]->this = 'shouldn\'t be here';

        $config = new Config($this->fullConfig);
    }

    public function testInvalidLabel()
    {
        $this->setExpectedException('DomainException');

        $this->fullConfig[0]->label = true;

        $config = new Config($this->fullConfig);
    }

    public function testInvalidName()
    {
        $this->setExpectedException('DomainException');

        $this->fullConfig[0]->name = false;

        $config = new Config($this->fullConfig);
    }

    public function testInvalidHidden()
    {
        $this->setExpectedException('DomainException');

        $this->fullConfig[0]->hidden = 'false';

        $config = new Config($this->fullConfig);
    }

    public function testInvalidElements()
    {
        $this->setExpectedException('DomainException');

        $this->fullConfig[0]->elements = null;

        $config = new Config($this->fullConfig);
    }

    public function testEmptyLabel()
    {
        $this->setExpectedException('DomainException');

        $this->fullConfig[0]->label = '';

        $config = new Config($this->fullConfig);
    }

    public function testEmptyName()
    {
        $this->setExpectedException('DomainException');

        $this->fullConfig[0]->name = '';

        $config = new Config($this->fullConfig);
    }

    public function testNonUniqueTabNames()
    {
        $this->setExpectedException('DomainException');

        $this->fullConfig[0]->name = 'tab1';
        $this->fullConfig[1]->name = 'tab1';

        $config = new Config($this->fullConfig);
    }

    public function testRandomElements()
    {
        $this->setExpectedException('DomainException');

        $this->fullConfig[0]->elements = ['a', 's', 'd', 'f'];

        $config = new Config($this->fullConfig);
    }

    public function testMissingElementType()
    {
        $this->setExpectedException('DomainException');

        unset($this->fullConfig[0]->elements[0]->type);

        $config = new Config($this->fullConfig);
    }

    public function testMissingElementName()
    {
        $this->setExpectedException('DomainException');

        unset($this->fullConfig[0]->elements[0]->name);

        $config = new Config($this->fullConfig);
    }

    public function testInvalidElementType()
    {
        $this->setExpectedException('DomainException');

        $this->fullConfig[0]->elements[0]->type = 'asdf';

        $config = new Config($this->fullConfig);
    }

    public function testInvalidElementName()
    {
        $this->setExpectedException('DomainException');

        $this->fullConfig[0]->elements[0]->name = 12345;

        $config = new Config($this->fullConfig);
    }

    public function testMissingTextRequired()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->required);

        $config = new Config($this->fullConfig);
    }

    public function testMissingTextLabel()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->label);

        $config = new Config($this->fullConfig);
    }

    public function testMissingTextValue()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->value);

        $config = new Config($this->fullConfig);
    }

    public function testMissingTextMicrocopy()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->microcopy);

        $config = new Config($this->fullConfig);
    }

    public function testMissingTextLimitType()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->limit_type);

        $config = new Config($this->fullConfig);
    }

    public function testMissingTextLimit()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->limit);

        $config = new Config($this->fullConfig);
    }

    public function testMissingTextPlainText()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->plain_text);

        $config = new Config($this->fullConfig);
    }

    public function testAdditionalTextAttribute()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->this = 'shouldn\'t be here';

        $config = new Config($this->fullConfig);
    }

    public function testInvalidTextRequired()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->required = 'false';

        $config = new Config($this->fullConfig);
    }

    public function testInvalidTextLabel()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->label = false;

        $config = new Config($this->fullConfig);
    }

    public function testInvalidTextValue()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->value = ['test'];

        $config = new Config($this->fullConfig);
    }

    public function testInvalidTextMicrocopy()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->microcopy = false;

        $config = new Config($this->fullConfig);
    }

    public function testInvalidTextLimitType()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->limit_type = 'characters';

        $config = new Config($this->fullConfig);
    }

    public function testInvalidTextLimit()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->limit = -50;

        $config = new Config($this->fullConfig);
    }

    public function testInvalidTextPlainText()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->plain_text = 'false';

        $config = new Config($this->fullConfig);
    }

    public function testMissingFilesRequired()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        unset($this->fullConfig[0]->elements[2]->required);

        $config = new Config($this->fullConfig);
    }

    public function testMissingFilesLabel()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        unset($this->fullConfig[0]->elements[2]->label);

        $config = new Config($this->fullConfig);
    }

    public function testMissingFilesMicrocopy()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        unset($this->fullConfig[0]->elements[2]->microcopy);

        $config = new Config($this->fullConfig);
    }

    public function testAdditionalFilesAttribute()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        $this->fullConfig[0]->elements[2]->this = 'shouldn\'t be here';

        $config = new Config($this->fullConfig);
    }

    public function testInvalidFilesRequired()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        $this->fullConfig[0]->elements[2]->required = 'false';

        $config = new Config($this->fullConfig);
    }

    public function testInvalidFilesLabel()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        $this->fullConfig[0]->elements[2]->label = false;

        $config = new Config($this->fullConfig);
    }

    public function testInvalidFilesMicrocopy()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        $this->fullConfig[0]->elements[2]->microcopy = false;

        $config = new Config($this->fullConfig);
    }

    public function testMissingSectionTitle()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        unset($this->fullConfig[0]->elements[3]->title);

        $config = new Config($this->fullConfig);
    }

    public function testMissingSectionSubtitle()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        unset($this->fullConfig[0]->elements[3]->subtitle);

        $config = new Config($this->fullConfig);
    }

    public function testAdditionalSectionAttribute()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        $this->fullConfig[0]->elements[3]->this = 'shouldn\'t be here';

        $config = new Config($this->fullConfig);
    }

    public function testInvalidSectionTitle()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        $this->fullConfig[0]->elements[3]->title = null;

        $config = new Config($this->fullConfig);
    }

    public function testInvalidSectionSubtitle()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        $this->fullConfig[0]->elements[3]->subtitle = null;

        $config = new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioRequired()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->required);

        $config = new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioLabel()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->label);

        $config = new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioMicrocopy()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->microcopy);

        $config = new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioOtherOption()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->other_option);

        $config = new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioOptions()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->options);

        $config = new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioOptionName()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->options[0]->name);

        $config = new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioOptionLabel()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->options[0]->label);

        $config = new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioOptionSelected()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->options[0]->selected);

        $config = new Config($this->fullConfig);
    }

    public function testAdditionalChoiceRadioAttribute()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->this = 'shouldn\'t be here';

        $config = new Config($this->fullConfig);
    }

    public function testAdditionalChoiceRadioOptionAttribute()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0]->this = 'shouldn\'t be here';

        $config = new Config($this->fullConfig);
    }

    public function testAdditionalChoiceRadioOtherOptionAttribute()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);
        $this->assertTrue($this->fullConfig[1]->elements[1]->other_option);

        $this->fullConfig[1]->elements[1]->options[2]->this = 'shouldn\'t be here';

        $config = new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioRequired()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->required = 'false';

        $config = new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioLabel()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->label = false;

        $config = new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioMicrocopy()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->microcopy = false;

        $config = new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOtherOption()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->other_option = 'false';

        $config = new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOptions()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options = 'none';

        $config = new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOptionName()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0]->name = 1;

        $config = new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOptionLabel()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0]->label = false;

        $config = new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOptionSelected()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0]->selected = 'false';

        $config = new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOptionValues()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);
        $this->assertTrue($this->fullConfig[1]->elements[1]->other_option);

        $this->fullConfig[1]->elements[1]->options[2]->value = false;

        $config = new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxRequired()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->required);

        $config = new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxLabel()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->label);

        $config = new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxMicrocopy()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->microcopy);

        $config = new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxOptions()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->options);

        $config = new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxOptionName()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->options[0]->name);

        $config = new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxOptionLabel()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->options[0]->label);

        $config = new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxOptionSelected()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->options[0]->selected);

        $config = new Config($this->fullConfig);
    }

    public function testAdditionalChoiceCheckboxAttribute()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->this = 'shouldn\'t be here';

        $config = new Config($this->fullConfig);
    }

    public function testAdditionalChoiceCheckboxOptionAttribute()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->this = 'shouldn\'t be here';

        $config = new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxRequired()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->required = 'false';

        $config = new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxLabel()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->label = false;

        $config = new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxMicrocopy()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->microcopy = false;

        $config = new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxOptions()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options = 'asdf';

        $config = new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxOptionName()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->name = 6;

        $config = new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxOptionLabel()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->label = false;

        $config = new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxOptionSelected()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->selected = 'false';

        $config = new Config($this->fullConfig);
    }

    public function testNonUniqueElementNames()
    {
        $this->setExpectedException('DomainException');

        $this->fullConfig[0]->elements[0]->name = 'el12345';
        $this->fullConfig[0]->elements[1]->name = 'el12345';

        $config = new Config($this->fullConfig);
    }

    public function testNonUniqueOptionNames()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->name = 'op6';
        $this->fullConfig[1]->elements[3]->options[1]->name = 'op6';

        $config = new Config($this->fullConfig);
    }

    public function testNoOptionsForChoiceRadio()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options = [];

        $config = new Config($this->fullConfig);
    }

    public function testNoOptionsForChoiceCheckbox()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options = [];

        $config = new Config($this->fullConfig);
    }

    public function testNonObjectOptionForChoiceRadio()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0] = (array)$this->fullConfig[1]->elements[0]->options[0];

        $config = new Config($this->fullConfig);
    }

    public function testNonObjectOptionForChoiceCheckbox()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0] = (array)$this->fullConfig[1]->elements[3]->options[0];

        $config = new Config($this->fullConfig);
    }

    public function testMultipleOptionsSelectedForChoiceRadio()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0]->selected = true;
        $this->fullConfig[1]->elements[0]->options[1]->selected = true;

        $config = new Config($this->fullConfig);
    }

    public function testMissingOtherOptionValueForChoiceRadio()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);

        unset($this->fullConfig[1]->elements[1]->options[2]->value);

        $config = new Config($this->fullConfig);
    }

    public function testUnnecessaryOptionValueForChoiceRadio()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);
        $this->assertFalse($this->fullConfig[1]->elements[0]->other_option);

        $this->fullConfig[1]->elements[0]->options[1]->value = '';

        $config = new Config($this->fullConfig);
    }

    public function testOtherOptionValueOnOtherThanLastOptionForChoiceRadio()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);
        $this->assertTrue($this->fullConfig[1]->elements[1]->other_option);

        $this->fullConfig[1]->elements[1]->options[0]->value = '';

        $config = new Config($this->fullConfig);
    }

    public function testOtherOptionValueEmptyIfOtherOptionNotSelectedForChoiceRadio()
    {
        $this->setExpectedException('DomainException');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);
        $this->assertEquals(3, count($this->fullConfig[1]->elements[1]->options));
        $this->assertTrue($this->fullConfig[1]->elements[1]->other_option);
        $this->assertFalse($this->fullConfig[1]->elements[1]->options[2]->selected);

        $this->fullConfig[1]->elements[1]->options[2]->value = 'this value should be empty';

        $config = new Config($this->fullConfig);
    }

}
