<?php

use GatherContent\ConfigValueObject\Config;
use GatherContent\ConfigValueObject\ConfigValueException;

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

    public function testEqualsIsCaseSensitive()
    {
        $config1 = new Config([
            (object) [
                'label' => 'Content',
                'name' => 'tab',
                'hidden' => false,
                'elements' => [],
            ]
        ]);

        $config2 = new Config([
            (object) [
                'label' => 'content',
                'name' => 'tab',
                'hidden' => false,
                'elements' => [],
            ]
        ]);

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
        $this->setExpectedException(ConfigValueException::class, 'Config must not be empty');

        $json = '[]';

        Config::fromJson($json);
    }

    public function testRandomArray()
    {
        $this->setExpectedException(ConfigValueException::class, 'Tab must be an object');

        $json = '["a","s","d","f"]';

        Config::fromJson($json);
    }

    public function testString()
    {
        $this->setExpectedException(ConfigValueException::class, 'Config must be array');

        $string = 'asdf';

        new Config($string);
    }

    public function testMissingLabel()
    {
        $this->setExpectedException(ConfigValueException::class, 'Tab label attribute is required');

        unset($this->fullConfig[0]->label);

        new Config($this->fullConfig);
    }

    public function testMissingName()
    {
        $this->setExpectedException(ConfigValueException::class, 'Tab name attribute is required');

        unset($this->fullConfig[0]->name);

        new Config($this->fullConfig);
    }

    public function testMissingHidden()
    {
        $this->setExpectedException(ConfigValueException::class, 'Tab hidden attribute is required');

        unset($this->fullConfig[0]->hidden);

        new Config($this->fullConfig);
    }

    public function testMissingElements()
    {
        $this->setExpectedException(ConfigValueException::class, 'Tab elements attribute is required');

        unset($this->fullConfig[0]->elements);

        new Config($this->fullConfig);
    }

    public function testAdditionalAttribute()
    {
        $this->setExpectedException(ConfigValueException::class, 'Tab must not have additional attributes');

        $this->fullConfig[0]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testInvalidLabel()
    {
        $this->setExpectedException(ConfigValueException::class, 'Tab label attribute must be string');

        $this->fullConfig[0]->label = true;

        new Config($this->fullConfig);
    }

    public function testInvalidName()
    {
        $this->setExpectedException(ConfigValueException::class, 'Tab name attribute must be string');

        $this->fullConfig[0]->name = false;

        new Config($this->fullConfig);
    }

    public function testInvalidHidden()
    {
        $this->setExpectedException(ConfigValueException::class, 'Tab hidden attribute must be boolean');

        $this->fullConfig[0]->hidden = 'false';

        new Config($this->fullConfig);
    }

    public function testInvalidElements()
    {
        $this->setExpectedException(ConfigValueException::class, 'Tab elements attribute must be array');

        $this->fullConfig[0]->elements = 'none';

        new Config($this->fullConfig);
    }

    public function testEmptyLabel()
    {
        $this->setExpectedException(ConfigValueException::class, 'Tab label attribute must not be empty');

        $this->fullConfig[0]->label = '';

        new Config($this->fullConfig);
    }

    public function testEmptyName()
    {
        $this->setExpectedException(ConfigValueException::class, 'Tab name attribute must not be empty');

        $this->fullConfig[0]->name = '';

        new Config($this->fullConfig);
    }

    public function testNonUniqueTabNames()
    {
        $this->setExpectedException(ConfigValueException::class, 'Tab names must be unique');

        $this->fullConfig[0]->name = 'tab1';
        $this->fullConfig[1]->name = 'tab1';

        new Config($this->fullConfig);
    }

    public function testRandomElements()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element must be an object');

        $this->fullConfig[0]->elements = ['a', 's', 'd', 'f'];

        new Config($this->fullConfig);
    }

    public function testMissingElementType()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element type attribute is required');

        unset($this->fullConfig[0]->elements[0]->type);

        new Config($this->fullConfig);
    }

    public function testMissingElementName()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element name attribute is required');

        unset($this->fullConfig[0]->elements[0]->name);

        new Config($this->fullConfig);
    }

    public function testInvalidElementType1()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element type attribute must be string');

        $this->fullConfig[0]->elements[0]->type = true;

        new Config($this->fullConfig);
    }

    public function testInvalidElementType2()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element must be of a supported type');

        $this->fullConfig[0]->elements[0]->type = 'asdf';

        new Config($this->fullConfig);
    }

    public function testInvalidElementName()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element name attribute must be string');

        $this->fullConfig[0]->elements[0]->name = 12345;

        new Config($this->fullConfig);
    }

    public function testEmptyElementName()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element name attribute must not be empty');

        $this->fullConfig[0]->elements[0]->name = '';

        new Config($this->fullConfig);
    }

    public function testMissingTextRequired()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element required attribute is required');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->required);

        new Config($this->fullConfig);
    }

    public function testMissingTextLabel()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element label attribute is required');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->label);

        new Config($this->fullConfig);
    }

    public function testMissingTextValue()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element value attribute is required');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->value);

        new Config($this->fullConfig);
    }

    public function testMissingTextMicrocopy()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element microcopy attribute is required');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->microcopy);

        new Config($this->fullConfig);
    }

    public function testMissingTextLimitType()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element limit_type attribute is required');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->limit_type);

        new Config($this->fullConfig);
    }

    public function testMissingTextLimit()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element limit attribute is required');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->limit);

        new Config($this->fullConfig);
    }

    public function testMissingTextPlainText()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element plain_text attribute is required');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->plain_text);

        new Config($this->fullConfig);
    }

    public function testAdditionalTextAttribute()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element must not have additional attributes');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testInvalidTextRequired()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element required attribute must be boolean');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->required = 'false';

        new Config($this->fullConfig);
    }

    public function testInvalidTextLabel()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element label attribute must be string');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->label = false;

        new Config($this->fullConfig);
    }

    public function testInvalidTextValue()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element value attribute must be string');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->value = ['test'];

        new Config($this->fullConfig);
    }

    public function testInvalidTextMicrocopy()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element microcopy attribute must be string');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->microcopy = false;

        new Config($this->fullConfig);
    }

    public function testInvalidTextLimitType()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element must be of a supported type');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->limit_type = 'characters';

        new Config($this->fullConfig);
    }

    public function testInvalidTextLimit1()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element limit attribute must be integer');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->limit = '0';

        new Config($this->fullConfig);
    }

    public function testInvalidTextLimit2()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element limit attribute must not be negative');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->limit = -50;

        new Config($this->fullConfig);
    }

    public function testInvalidTextPlainText()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element plain_text attribute must be boolean');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->plain_text = 'false';

        new Config($this->fullConfig);
    }

    public function testMissingFilesRequired()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element required attribute is required');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        unset($this->fullConfig[0]->elements[2]->required);

        new Config($this->fullConfig);
    }

    public function testMissingFilesLabel()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element label attribute is required');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        unset($this->fullConfig[0]->elements[2]->label);

        new Config($this->fullConfig);
    }

    public function testMissingFilesMicrocopy()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element microcopy attribute is required');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        unset($this->fullConfig[0]->elements[2]->microcopy);

        new Config($this->fullConfig);
    }

    public function testAdditionalFilesAttribute()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element must not have additional attributes');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        $this->fullConfig[0]->elements[2]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testInvalidFilesRequired()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element required attribute must be boolean');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        $this->fullConfig[0]->elements[2]->required = 'false';

        new Config($this->fullConfig);
    }

    public function testInvalidFilesLabel()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element label attribute must be string');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        $this->fullConfig[0]->elements[2]->label = false;

        new Config($this->fullConfig);
    }

    public function testInvalidFilesMicrocopy()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element microcopy attribute must be string');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        $this->fullConfig[0]->elements[2]->microcopy = false;

        new Config($this->fullConfig);
    }

    public function testMissingSectionTitle()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element title attribute is required');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        unset($this->fullConfig[0]->elements[3]->title);

        new Config($this->fullConfig);
    }

    public function testMissingSectionSubtitle()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element subtitle attribute is required');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        unset($this->fullConfig[0]->elements[3]->subtitle);

        new Config($this->fullConfig);
    }

    public function testAdditionalSectionAttribute()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element must not have additional attributes');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        $this->fullConfig[0]->elements[3]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testInvalidSectionTitle()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element title attribute must be string');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        $this->fullConfig[0]->elements[3]->title = null;

        new Config($this->fullConfig);
    }

    public function testInvalidSectionSubtitle()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element subtitle attribute must be string');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        $this->fullConfig[0]->elements[3]->subtitle = null;

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioRequired()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element required attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->required);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioLabel()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element label attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->label);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioMicrocopy()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element microcopy attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->microcopy);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioOtherOption()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element other_option attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->other_option);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioOptions()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element options attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->options);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioOptionName()
    {
        $this->setExpectedException(ConfigValueException::class, 'Option name attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->options[0]->name);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioOptionLabel()
    {
        $this->setExpectedException(ConfigValueException::class, 'Option label attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->options[0]->label);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioOptionSelected()
    {
        $this->setExpectedException(ConfigValueException::class, 'Option selected attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->options[0]->selected);

        new Config($this->fullConfig);
    }

    public function testAdditionalChoiceRadioAttribute()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element must not have additional attributes');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testAdditionalChoiceRadioOptionAttribute()
    {
        $this->setExpectedException(ConfigValueException::class, 'Option value attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testAdditionalChoiceRadioOtherOptionAttribute()
    {
        $this->setExpectedException(ConfigValueException::class, 'Option must not have additional attributes');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);
        $this->assertTrue($this->fullConfig[1]->elements[1]->other_option);

        $this->fullConfig[1]->elements[1]->options[2]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioRequired()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element required attribute must be boolean');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->required = 'false';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioLabel()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element label attribute must be string');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->label = false;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioMicrocopy()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element microcopy attribute must be string');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->microcopy = false;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOtherOption()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element other_option attribute must be boolean');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->other_option = 'false';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOptions()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element options attribute must be array');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options = 'none';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOptionName()
    {
        $this->setExpectedException(ConfigValueException::class, 'Option name attribute must be string');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0]->name = 1;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOptionLabel()
    {
        $this->setExpectedException(ConfigValueException::class, 'Option label attribute must be string');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0]->label = false;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOptionSelected()
    {
        $this->setExpectedException(ConfigValueException::class, 'Option selected attribute must be boolean');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0]->selected = 'false';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOptionValues()
    {
        $this->setExpectedException(ConfigValueException::class, 'Option value attribute must be string');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);
        $this->assertTrue($this->fullConfig[1]->elements[1]->other_option);

        $this->fullConfig[1]->elements[1]->options[2]->value = false;

        new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxRequired()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element required attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->required);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxLabel()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element label attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->label);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxMicrocopy()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element microcopy attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->microcopy);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxOptions()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element options attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->options);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxOptionName()
    {
        $this->setExpectedException(ConfigValueException::class, 'Option name attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->options[0]->name);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxOptionLabel()
    {
        $this->setExpectedException(ConfigValueException::class, 'Option label attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->options[0]->label);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxOptionSelected()
    {
        $this->setExpectedException(ConfigValueException::class, 'Option selected attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->options[0]->selected);

        new Config($this->fullConfig);
    }

    public function testAdditionalChoiceCheckboxAttribute()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element must not have additional attributes');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testAdditionalChoiceCheckboxOptionAttribute()
    {
        $this->setExpectedException(ConfigValueException::class, 'Option value attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxRequired()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element required attribute must be boolean');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->required = 'false';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxLabel()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element label attribute must be string');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->label = false;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxMicrocopy()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element microcopy attribute must be string');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->microcopy = false;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxOptions()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element options attribute must be array');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options = 'asdf';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxOptionName()
    {
        $this->setExpectedException(ConfigValueException::class, 'Option name attribute must be string');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->name = 6;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxOptionLabel()
    {
        $this->setExpectedException(ConfigValueException::class, 'Option label attribute must be string');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->label = false;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxOptionSelected()
    {
        $this->setExpectedException(ConfigValueException::class, 'Option selected attribute must be boolean');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->selected = 'false';

        new Config($this->fullConfig);
    }

    public function testNonUniqueElementNames()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element names must be unique');

        $this->fullConfig[0]->elements[0]->name = 'el12345';
        $this->fullConfig[0]->elements[1]->name = 'el12345';

        new Config($this->fullConfig);
    }

    public function testNonUniqueOptionNames()
    {
        $this->setExpectedException(ConfigValueException::class, 'Option names must be unique');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->name = 'op6';
        $this->fullConfig[1]->elements[3]->options[1]->name = 'op6';

        new Config($this->fullConfig);
    }

    public function testNoOptionsForChoiceRadio()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element must have at least one option');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options = [];

        new Config($this->fullConfig);
    }

    public function testNoOptionsForChoiceCheckbox()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element must have at least one option');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options = [];

        new Config($this->fullConfig);
    }

    public function testNonObjectOptionForChoiceRadio()
    {
        $this->setExpectedException(ConfigValueException::class, 'Option must be an object');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0] = (array)$this->fullConfig[1]->elements[0]->options[0];

        new Config($this->fullConfig);
    }

    public function testNonObjectOptionForChoiceCheckbox()
    {
        $this->setExpectedException(ConfigValueException::class, 'Option must be an object');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0] = (array)$this->fullConfig[1]->elements[3]->options[0];

        new Config($this->fullConfig);
    }

    public function testMultipleOptionsSelectedForChoiceRadio()
    {
        $this->setExpectedException(ConfigValueException::class, 'Element checkbox_radio must have at most one option selected');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0]->selected = true;
        $this->fullConfig[1]->elements[0]->options[1]->selected = true;

        new Config($this->fullConfig);
    }

    public function testMissingOtherOptionValueForChoiceRadio()
    {
        $this->setExpectedException(ConfigValueException::class, 'Other option value is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);

        unset($this->fullConfig[1]->elements[1]->options[2]->value);

        new Config($this->fullConfig);
    }

    public function testUnnecessaryOptionValueForChoiceRadio()
    {
        $this->setExpectedException(ConfigValueException::class, 'Option value must not be present for regular option');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);
        $this->assertFalse($this->fullConfig[1]->elements[0]->other_option);

        $this->fullConfig[1]->elements[0]->options[1]->value = '';

        new Config($this->fullConfig);
    }

    public function testOtherOptionValueOnOtherThanLastOptionForChoiceRadio()
    {
        $this->setExpectedException(ConfigValueException::class, 'Option value must not be present for regular option');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);
        $this->assertTrue($this->fullConfig[1]->elements[1]->other_option);

        $this->fullConfig[1]->elements[1]->options[0]->value = '';

        new Config($this->fullConfig);
    }

    public function testOtherOptionValueEmptyIfOtherOptionNotSelectedForChoiceRadio()
    {
        $this->setExpectedException(ConfigValueException::class, 'Other option value must be empty when other option not selected');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);
        $this->assertEquals(3, count($this->fullConfig[1]->elements[1]->options));
        $this->assertTrue($this->fullConfig[1]->elements[1]->other_option);
        $this->assertFalse($this->fullConfig[1]->elements[1]->options[2]->selected);

        $this->fullConfig[1]->elements[1]->options[2]->value = 'this value should be empty';

        new Config($this->fullConfig);
    }

}
