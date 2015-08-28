<?php

use GatherContent\ConfigValueObject\Config;
use GatherContent\ConfigValueObject\ConfigValueException;

class ConfigTest extends PHPUnit_Framework_TestCase
{
    private $fullConfig;

    public function setUp()
    {
        parent::setUp();

        $this->fullConfig = array(
            (object)array(
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => array(
                    (object)array(
                        'type' => 'text',
                        'name' => 'el1',
                        'required' => false,
                        'label' => 'Label',
                        'value' => '<p>How goes it?</p>',
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'words',
                        'limit' => 50,
                        'plain_text' => false,
                    ),
                    (object)array(
                        'type' => 'text',
                        'name' => 'el2',
                        'required' => false,
                        'label' => 'Label',
                        'value' => 'How goes it?',
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'chars',
                        'limit' => 500,
                        'plain_text' => true,
                    ),
                    (object)array(
                        'type' => 'files',
                        'name' => 'el3',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                    ),
                    (object)array(
                        'type' => 'section',
                        'name' => 'el4',
                        'title' => 'Title',
                        'subtitle' => '<p>How goes it?</p>',
                    ),
                ),
            ),
            (object)array(
                'label' => 'Meta',
                'name' => 'tab2',
                'hidden' => true,
                'elements' => array(
                    (object)array(
                        'type' => 'choice_radio',
                        'name' => 'el5',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => false,
                        'options' => array(
                            (object)array(
                                'name' => 'op1',
                                'label' => 'First choice',
                                'selected' => false,
                            ),
                            (object)array(
                                'name' => 'op2',
                                'label' => 'Second choice',
                                'selected' => false,
                            ),
                        ),
                    ),
                    (object)array(
                        'type' => 'choice_radio',
                        'name' => 'el6',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => true,
                        'options' => array(
                            (object)array(
                                'name' => 'op3',
                                'label' => 'First choice',
                                'selected' => false,
                            ),
                            (object)array(
                                'name' => 'op4',
                                'label' => 'Second choice',
                                'selected' => true,
                            ),
                            (object)array(
                                'name' => 'op5',
                                'label' => 'Other',
                                'selected' => false,
                                'value' => '',
                            ),
                        ),
                    ),
                    (object)array(
                        'type' => 'choice_radio',
                        'name' => 'el7',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => true,
                        'options' => array(
                            (object)array(
                                'name' => 'op6',
                                'label' => 'First choice',
                                'selected' => false,
                            ),
                            (object)array(
                                'name' => 'op7',
                                'label' => 'Second choice',
                                'selected' => false,
                            ),
                            (object)array(
                                'name' => 'op8',
                                'label' => 'Other',
                                'selected' => true,
                                'value' => 'How goes it?',
                            ),
                        ),
                    ),
                    (object)array(
                        'type' => 'choice_checkbox',
                        'name' => 'el8',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'options' => array(
                            (object)array(
                                'name' => 'op9',
                                'label' => 'First choice',
                                'selected' => false,
                            ),
                            (object)array(
                                'name' => 'op10',
                                'label' => 'Second choice',
                                'selected' => false,
                            ),
                        ),
                    ),
                    (object)array(
                        'type' => 'choice_checkbox',
                        'name' => 'el9',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'options' => array(
                            (object)array(
                                'name' => 'op11',
                                'label' => 'First choice',
                                'selected' => true,
                            ),
                            (object)array(
                                'name' => 'op12',
                                'label' => 'Second choice',
                                'selected' => true,
                            ),
                        ),
                    ),
                ),
            ),
        );
    }

    public function testFullConfig()
    {
        $config = new Config($this->fullConfig);
        $result = $config->toArray();

        $this->assertEquals($this->fullConfig, $result);
    }

    public function testCastingToString()
    {
        $originalConfig = array(
            (object)array(
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => array(),
            ),
        );

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
        $originalConfig1 = array(
            (object)array(
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => array(),
            ),
        );

        $originalConfig2 = array(
            (object)array(
                'label' => 'Meta',
                'name' => 'tab2',
                'hidden' => false,
                'elements' => array(),
            ),
        );

        $config1 = new Config($originalConfig1);
        $config2 = new Config($originalConfig2);

        $result = $config1->equals($config2);

        $this->assertFalse($result);
    }

    public function testEqualsIsCaseSensitive()
    {
        $config1 = new Config(array(
            (object)array(
                'label' => 'Content',
                'name' => 'tab',
                'hidden' => false,
                'elements' => array(),
            )
        ));

        $config2 = new Config(array(
            (object)array(
                'label' => 'content',
                'name' => 'tab',
                'hidden' => false,
                'elements' => array(),
            )
        ));

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
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Config must not be empty');

        $json = '[]';

        Config::fromJson($json);
    }

    public function testRandomArray()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Tab must be an object');

        $json = '["a","s","d","f"]';

        Config::fromJson($json);
    }

    public function testString()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Config must be array');

        $string = 'asdf';

        new Config($string);
    }

    public function testMissingLabel()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Tab label attribute is required');

        unset($this->fullConfig[0]->label);

        new Config($this->fullConfig);
    }

    public function testMissingName()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Tab name attribute is required');

        unset($this->fullConfig[0]->name);

        new Config($this->fullConfig);
    }

    public function testMissingHidden()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Tab hidden attribute is required');

        unset($this->fullConfig[0]->hidden);

        new Config($this->fullConfig);
    }

    public function testMissingElements()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Tab elements attribute is required');

        unset($this->fullConfig[0]->elements);

        new Config($this->fullConfig);
    }

    public function testAdditionalAttribute()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Tab must not have additional attributes');

        $this->fullConfig[0]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testInvalidLabel()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Tab label attribute must be string');

        $this->fullConfig[0]->label = true;

        new Config($this->fullConfig);
    }

    public function testInvalidName()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Tab name attribute must be string');

        $this->fullConfig[0]->name = false;

        new Config($this->fullConfig);
    }

    public function testInvalidHidden()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Tab hidden attribute must be boolean');

        $this->fullConfig[0]->hidden = 'false';

        new Config($this->fullConfig);
    }

    public function testInvalidElements()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Tab elements attribute must be array');

        $this->fullConfig[0]->elements = 'none';

        new Config($this->fullConfig);
    }

    public function testEmptyLabel()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Tab label attribute must not be empty');

        $this->fullConfig[0]->label = '';

        new Config($this->fullConfig);
    }

    public function testEmptyName()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Tab name attribute must not be empty');

        $this->fullConfig[0]->name = '';

        new Config($this->fullConfig);
    }

    public function testNonUniqueTabNames()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Tab names must be unique');

        $this->fullConfig[0]->name = 'tab1';
        $this->fullConfig[1]->name = 'tab1';

        new Config($this->fullConfig);
    }

    public function testRandomElements()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element must be an object');

        $this->fullConfig[0]->elements = array('a', 's', 'd', 'f');

        new Config($this->fullConfig);
    }

    public function testMissingElementType()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element type attribute is required');

        unset($this->fullConfig[0]->elements[0]->type);

        new Config($this->fullConfig);
    }

    public function testMissingElementName()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element name attribute is required');

        unset($this->fullConfig[0]->elements[0]->name);

        new Config($this->fullConfig);
    }

    public function testInvalidElementType1()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element type attribute must be string');

        $this->fullConfig[0]->elements[0]->type = true;

        new Config($this->fullConfig);
    }

    public function testInvalidElementType2()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element must be of a supported type');

        $this->fullConfig[0]->elements[0]->type = 'asdf';

        new Config($this->fullConfig);
    }

    public function testInvalidElementName()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element name attribute must be string');

        $this->fullConfig[0]->elements[0]->name = 12345;

        new Config($this->fullConfig);
    }

    public function testEmptyElementName()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element name attribute must not be empty');

        $this->fullConfig[0]->elements[0]->name = '';

        new Config($this->fullConfig);
    }

    public function testMissingTextRequired()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element required attribute is required');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->required);

        new Config($this->fullConfig);
    }

    public function testMissingTextLabel()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element label attribute is required');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->label);

        new Config($this->fullConfig);
    }

    public function testMissingTextValue()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element value attribute is required');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->value);

        new Config($this->fullConfig);
    }

    public function testMissingTextMicrocopy()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element microcopy attribute is required');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->microcopy);

        new Config($this->fullConfig);
    }

    public function testMissingTextLimitType()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element limit_type attribute is required');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->limit_type);

        new Config($this->fullConfig);
    }

    public function testMissingTextLimit()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element limit attribute is required');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->limit);

        new Config($this->fullConfig);
    }

    public function testMissingTextPlainText()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element plain_text attribute is required');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        unset($this->fullConfig[0]->elements[0]->plain_text);

        new Config($this->fullConfig);
    }

    public function testAdditionalTextAttribute()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element must not have additional attributes');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testInvalidTextRequired()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element required attribute must be boolean');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->required = 'false';

        new Config($this->fullConfig);
    }

    public function testInvalidTextLabel()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element label attribute must be string');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->label = false;

        new Config($this->fullConfig);
    }

    public function testInvalidTextValue()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element value attribute must be string');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->value = array('test');

        new Config($this->fullConfig);
    }

    public function testInvalidTextMicrocopy()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element microcopy attribute must be string');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->microcopy = false;

        new Config($this->fullConfig);
    }

    public function testInvalidTextLimitType()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element must be of a supported type');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->limit_type = 'characters';

        new Config($this->fullConfig);
    }

    public function testInvalidTextLimit1()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element limit attribute must be integer');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->limit = '0';

        new Config($this->fullConfig);
    }

    public function testInvalidTextLimit2()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element limit attribute must not be negative');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->limit = -50;

        new Config($this->fullConfig);
    }

    public function testInvalidTextLimit3()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element limit attribute must be integer');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->limit = false;

        new Config($this->fullConfig);
    }

    public function testInvalidTextLimit4()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element limit attribute must be integer');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->limit = 'three';

        new Config($this->fullConfig);
    }

    public function testInvalidTextPlainText()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element plain_text attribute must be boolean');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->plain_text = 'false';

        new Config($this->fullConfig);
    }

    public function testEmptyTextLabel()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element label attribute must not be empty');

        $this->assertEquals('text', $this->fullConfig[0]->elements[0]->type);

        $this->fullConfig[0]->elements[0]->label = '';

        new Config($this->fullConfig);
    }

    public function testMissingFilesRequired()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element required attribute is required');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        unset($this->fullConfig[0]->elements[2]->required);

        new Config($this->fullConfig);
    }

    public function testMissingFilesLabel()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element label attribute is required');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        unset($this->fullConfig[0]->elements[2]->label);

        new Config($this->fullConfig);
    }

    public function testMissingFilesMicrocopy()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element microcopy attribute is required');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        unset($this->fullConfig[0]->elements[2]->microcopy);

        new Config($this->fullConfig);
    }

    public function testAdditionalFilesAttribute()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element must not have additional attributes');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        $this->fullConfig[0]->elements[2]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testInvalidFilesRequired()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element required attribute must be boolean');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        $this->fullConfig[0]->elements[2]->required = 'false';

        new Config($this->fullConfig);
    }

    public function testInvalidFilesLabel()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element label attribute must be string');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        $this->fullConfig[0]->elements[2]->label = false;

        new Config($this->fullConfig);
    }

    public function testInvalidFilesMicrocopy()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element microcopy attribute must be string');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        $this->fullConfig[0]->elements[2]->microcopy = false;

        new Config($this->fullConfig);
    }

    public function testEmptyFilesLabel()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element label attribute must not be empty');

        $this->assertEquals('files', $this->fullConfig[0]->elements[2]->type);

        $this->fullConfig[0]->elements[2]->label = '';

        new Config($this->fullConfig);
    }

    public function testMissingSectionTitle()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element title attribute is required');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        unset($this->fullConfig[0]->elements[3]->title);

        new Config($this->fullConfig);
    }

    public function testMissingSectionSubtitle()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element subtitle attribute is required');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        unset($this->fullConfig[0]->elements[3]->subtitle);

        new Config($this->fullConfig);
    }

    public function testAdditionalSectionAttribute()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element must not have additional attributes');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        $this->fullConfig[0]->elements[3]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testInvalidSectionTitle()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element title attribute must be string');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        $this->fullConfig[0]->elements[3]->title = null;

        new Config($this->fullConfig);
    }

    public function testInvalidSectionSubtitle()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element subtitle attribute must be string');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        $this->fullConfig[0]->elements[3]->subtitle = null;

        new Config($this->fullConfig);
    }

    public function testEmptySectionTitle()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element title attribute must not be empty');

        $this->assertEquals('section', $this->fullConfig[0]->elements[3]->type);

        $this->fullConfig[0]->elements[3]->title = '';

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioRequired()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element required attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->required);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioLabel()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element label attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->label);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioMicrocopy()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element microcopy attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->microcopy);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioOtherOption()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element other_option attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->other_option);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioOptions()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element options attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->options);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioOptionName()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option name attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->options[0]->name);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioOptionLabel()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option label attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->options[0]->label);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceRadioOptionSelected()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option selected attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        unset($this->fullConfig[1]->elements[0]->options[0]->selected);

        new Config($this->fullConfig);
    }

    public function testAdditionalChoiceRadioAttribute()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element must not have additional attributes');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testAdditionalChoiceRadioOptionAttribute()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option must not have additional attributes');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testAdditionalChoiceRadioOtherOptionAttribute()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option must not have additional attributes');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);
        $this->assertTrue($this->fullConfig[1]->elements[1]->other_option);

        $this->fullConfig[1]->elements[1]->options[2]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioRequired()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element required attribute must be boolean');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->required = 'false';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioLabel()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element label attribute must be string');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->label = false;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioMicrocopy()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element microcopy attribute must be string');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->microcopy = false;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOtherOption()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element other_option attribute must be boolean');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->other_option = 'false';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOptions()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element options attribute must be array');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options = 'none';

        new Config($this->fullConfig);
    }

    public function testEmptyChoiceRadioLabel()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element label attribute must not be empty');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->label = '';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOptionName()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option name attribute must be string');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0]->name = 1;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOptionLabel()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option label attribute must be string');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0]->label = false;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOptionSelected()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option selected attribute must be boolean');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0]->selected = 'false';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceRadioOptionValues()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option value attribute must be string');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);
        $this->assertTrue($this->fullConfig[1]->elements[1]->other_option);

        $this->fullConfig[1]->elements[1]->options[2]->value = false;

        new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxRequired()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element required attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->required);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxLabel()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element label attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->label);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxMicrocopy()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element microcopy attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->microcopy);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxOptions()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element options attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->options);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxOptionName()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option name attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->options[0]->name);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxOptionLabel()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option label attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->options[0]->label);

        new Config($this->fullConfig);
    }

    public function testMissingChoiceCheckboxOptionSelected()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option selected attribute is required');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        unset($this->fullConfig[1]->elements[3]->options[0]->selected);

        new Config($this->fullConfig);
    }

    public function testAdditionalChoiceCheckboxAttribute()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element must not have additional attributes');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testAdditionalChoiceCheckboxOptionAttribute()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option must not have additional attributes');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->this = 'shouldn\'t be here';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxRequired()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element required attribute must be boolean');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->required = 'false';

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxLabel()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element label attribute must be string');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->label = false;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxMicrocopy()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element microcopy attribute must be string');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->microcopy = false;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxOptions()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element options attribute must be array');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options = 'asdf';

        new Config($this->fullConfig);
    }

    public function testEmptyChoiceCheckboxLabel()
        {
            $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element label attribute must not be empty');

            $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

            $this->fullConfig[1]->elements[3]->label = '';

            new Config($this->fullConfig);
        }

    public function testInvalidChoiceCheckboxOptionName()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option name attribute must be string');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->name = 6;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxOptionLabel()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option label attribute must be string');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->label = false;

        new Config($this->fullConfig);
    }

    public function testInvalidChoiceCheckboxOptionSelected()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option selected attribute must be boolean');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->selected = 'false';

        new Config($this->fullConfig);
    }

    public function testEmptyChoiceCheckboxOptionLabel()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option label attribute must not be empty');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->label = '';

        new Config($this->fullConfig);
    }

    public function testNonUniqueElementNames()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element names must be unique');

        $this->fullConfig[0]->elements[0]->name = 'el12345';
        $this->fullConfig[0]->elements[1]->name = 'el12345';

        new Config($this->fullConfig);
    }

    public function testNonUniqueOptionNames()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option names must be unique');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0]->name = 'op6';
        $this->fullConfig[1]->elements[3]->options[1]->name = 'op6';

        new Config($this->fullConfig);
    }

    public function testItemWideNonUniqueOptionNames()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option names must be unique');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[0]->options[0]->name = 'op12345';
        $this->fullConfig[1]->elements[1]->options[1]->name = 'op12345';

        new Config($this->fullConfig);
    }

    public function testNoOptionsForChoiceRadio()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element must have at least one option');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options = array();

        new Config($this->fullConfig);
    }

    public function testNoOptionsForChoiceCheckbox()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element must have at least one option');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options = array();

        new Config($this->fullConfig);
    }

    public function testNonObjectOptionForChoiceRadio()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option must be an object');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0] = (array)$this->fullConfig[1]->elements[0]->options[0];

        new Config($this->fullConfig);
    }

    public function testNonObjectOptionForChoiceCheckbox()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option must be an object');

        $this->assertEquals('choice_checkbox', $this->fullConfig[1]->elements[3]->type);

        $this->fullConfig[1]->elements[3]->options[0] = (array)$this->fullConfig[1]->elements[3]->options[0];

        new Config($this->fullConfig);
    }

    public function testMultipleOptionsSelectedForChoiceRadio()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Element choice_radio must have at most one option selected');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);

        $this->fullConfig[1]->elements[0]->options[0]->selected = true;
        $this->fullConfig[1]->elements[0]->options[1]->selected = true;

        new Config($this->fullConfig);
    }

    public function testMissingOtherOptionValueForChoiceRadio()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option value attribute is required');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);

        unset($this->fullConfig[1]->elements[1]->options[2]->value);

        new Config($this->fullConfig);
    }

    public function testUnnecessaryOptionValueForChoiceRadio()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option must not have additional attributes');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);
        $this->assertFalse($this->fullConfig[1]->elements[0]->other_option);

        $this->fullConfig[1]->elements[0]->options[1]->value = '';

        new Config($this->fullConfig);
    }

    public function testOtherOptionValueOnOtherThanLastOptionForChoiceRadio()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option must not have additional attributes');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);
        $this->assertTrue($this->fullConfig[1]->elements[1]->other_option);

        $this->fullConfig[1]->elements[1]->options[0]->value = '';

        new Config($this->fullConfig);
    }

    public function testEmptyOptionLabelForChoiceRadio()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option label attribute must not be empty');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[0]->type);
        $this->assertFalse($this->fullConfig[1]->elements[0]->other_option);

        $this->fullConfig[1]->elements[0]->options[1]->label = '';

        new Config($this->fullConfig);
    }

    public function testEmptyOtherOptionLabelForChoiceRadio()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Option label attribute must not be empty');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);
        $this->assertTrue($this->fullConfig[1]->elements[1]->other_option);
        $this->assertObjectHasAttribute('value', $this->fullConfig[1]->elements[1]->options[2]);

        $this->fullConfig[1]->elements[1]->options[2]->label = '';

        new Config($this->fullConfig);
    }

    public function testOtherOptionValueEmptyIfOtherOptionNotSelectedForChoiceRadio()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Other option value must be empty when other option not selected');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);
        $this->assertEquals(3, count($this->fullConfig[1]->elements[1]->options));
        $this->assertTrue($this->fullConfig[1]->elements[1]->other_option);
        $this->assertFalse($this->fullConfig[1]->elements[1]->options[2]->selected);

        $this->fullConfig[1]->elements[1]->options[2]->value = 'this value should be empty';

        new Config($this->fullConfig);
    }

    public function testOtherOptionMustNotBeTheOnlyOptionForChoiceRadio()
    {
        $this->setExpectedException('GatherContent\ConfigValueObject\ConfigValueException', 'Other option must not be the only option');

        $this->assertEquals('choice_radio', $this->fullConfig[1]->elements[1]->type);
        $this->assertTrue($this->fullConfig[1]->elements[1]->other_option);
        $this->assertEquals(3, count($this->fullConfig[1]->elements[1]->options));
        $this->assertObjectHasAttribute('selected', $this->fullConfig[1]->elements[1]->options[2]);

        unset($this->fullConfig[1]->elements[1]->options[1]);
        unset($this->fullConfig[1]->elements[1]->options[0]);

        $this->assertEquals(1, count($this->fullConfig[1]->elements[1]->options));

        new Config($this->fullConfig);
    }

}
