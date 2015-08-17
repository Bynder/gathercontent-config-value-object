<?php

use GatherContent\ConfigValueObject\Config;

class ConfigTest extends PHPUnit_Framework_TestCase
{
    public function testValidConfig()
    {
        $expected = $originalConfig = [
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

        $config = new Config($originalConfig);
        $result = $config->toArray();

        $this->assertEquals($expected, $result);
    }

    public function testCastingToArray()
    {
        $expected = $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [],
            ],
        ];

        $config = new Config($originalConfig);
        $result = $config->toArray();

        $this->assertEquals($expected, $result);
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
        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [],
            ],
        ];

        $config1 = new Config($originalConfig);
        $config2 = new Config($originalConfig);

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

        $originalConfig = [
            (object)[
                //'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingName()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                //'name' => 'tab1',
                'hidden' => false,
                'elements' => [],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingHidden()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                //'hidden' => false,
                'elements' => [],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingElements()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                //'elements' => [],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testAdditionalAttribute()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [],
                'this' => 'shouldn\'t be here',
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidLabel()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => true,
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidName()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => null,
                'hidden' => false,
                'elements' => [],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidHidden()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => 'false',
                'elements' => [],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidElements()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => null,
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testEmptyLabel()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => '',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testEmptyName()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => '',
                'hidden' => false,
                'elements' => [],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testNonUniqueTabNames()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [],
            ],
            (object)[
                'label' => 'Meta',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testRandomElements()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => ['a', 's', 'd', 'f'],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingElementType()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        //'type' => 'text',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'value' => '<p>How goes it?</p>',
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'words',
                        'limit' => 50,
                        'plain_text' => false,
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingElementName()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'text',
                        //'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'value' => '<p>How goes it?</p>',
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'words',
                        'limit' => 50,
                        'plain_text' => false,
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidElementType()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'asdf',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'value' => '<p>How goes it?</p>',
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'words',
                        'limit' => 50,
                        'plain_text' => false,
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidElementName()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'text',
                        'name' => 12345,
                        'required' => false,
                        'label' => 'Label',
                        'value' => '<p>How goes it?</p>',
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'words',
                        'limit' => 50,
                        'plain_text' => false,
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingTextRequired()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'text',
                        'name' => 'el12345',
                        //'required' => false,
                        'label' => 'Label',
                        'value' => '<p>How goes it?</p>',
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'words',
                        'limit' => 50,
                        'plain_text' => false,
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingTextLabel()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'text',
                        'name' => 'el12345',
                        'required' => false,
                        //'label' => 'Label',
                        'value' => '<p>How goes it?</p>',
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'words',
                        'limit' => 50,
                        'plain_text' => false,
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingTextValue()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'text',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        //'value' => '<p>How goes it?</p>',
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'words',
                        'limit' => 50,
                        'plain_text' => false,
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingTextMicrocopy()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'text',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'value' => '<p>How goes it?</p>',
                        //'microcopy' => 'Microcopy',
                        'limit_type' => 'words',
                        'limit' => 50,
                        'plain_text' => false,
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingTextLimitType()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'text',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'value' => '<p>How goes it?</p>',
                        'microcopy' => 'Microcopy',
                        //'limit_type' => 'words',
                        'limit' => 50,
                        'plain_text' => false,
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingTextLimit()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'text',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'value' => '<p>How goes it?</p>',
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'words',
                        //'limit' => 50,
                        'plain_text' => false,
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingTextPlainText()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'text',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'value' => '<p>How goes it?</p>',
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'words',
                        'limit' => 50,
                        //'plain_text' => false,
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testAdditionalTextAttribute()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'text',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'value' => '<p>How goes it?</p>',
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'words',
                        'limit' => 50,
                        'plain_text' => false,
                        'this' => 'shouldn\'t be here',
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidTextRequired()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'text',
                        'name' => 'el12345',
                        'required' => 'false',
                        'label' => 'Label',
                        'value' => '<p>How goes it?</p>',
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'words',
                        'limit' => 50,
                        'plain_text' => false,
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidTextLabel()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'text',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => null,
                        'value' => '<p>How goes it?</p>',
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'words',
                        'limit' => 50,
                        'plain_text' => false,
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidTextValue()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'text',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'value' => ['test'],
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'words',
                        'limit' => 50,
                        'plain_text' => false,
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidTextMicrocopy()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'text',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'value' => '<p>How goes it?</p>',
                        'microcopy' => null,
                        'limit_type' => 'words',
                        'limit' => 50,
                        'plain_text' => false,
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidTextLimitType()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'text',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'value' => '<p>How goes it?</p>',
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'characters',
                        'limit' => 50,
                        'plain_text' => false,
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidTextLimit()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'text',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'value' => '<p>How goes it?</p>',
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'words',
                        'limit' => -50,
                        'plain_text' => false,
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidTextPlainText()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'text',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'value' => '<p>How goes it?</p>',
                        'microcopy' => 'Microcopy',
                        'limit_type' => 'words',
                        'limit' => 50,
                        'plain_text' => 'false',
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingFilesRequired()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'files',
                        'name' => 'el12345',
                        //'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingFilesLabel()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'files',
                        'name' => 'el12345',
                        'required' => false,
                        //'label' => 'Label',
                        'microcopy' => 'Microcopy',
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingFilesMicrocopy()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'files',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        //'microcopy' => 'Microcopy',
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testAdditionalFilesAttribute()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'files',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'this' => 'shouldn\'t be here',
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidFilesRequired()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'files',
                        'name' => 'el12345',
                        'required' => 'false',
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidFilesLabel()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'files',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => null,
                        'microcopy' => 'Microcopy',
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidFilesMicrocopy()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'files',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => null,
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingSectionTitle()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'section',
                        'name' => 'el12345',
                        //'title' => 'Title',
                        'subtitle' => '<p>How goes it?</p>',
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingSectionSubtitle()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'section',
                        'name' => 'el12345',
                        'title' => 'Title',
                        //'subtitle' => '<p>How goes it?</p>',
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testAdditionalSectionAttribute()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'section',
                        'name' => 'el12345',
                        'title' => 'Title',
                        'subtitle' => '<p>How goes it?</p>',
                        'this' => 'shouldn\'t be here',
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidSectionTitle()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'section',
                        'name' => 'el12345',
                        'title' => null,
                        'subtitle' => '<p>How goes it?</p>',
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidSectionSubtitle()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'section',
                        'name' => 'el12345',
                        'title' => 'Title',
                        'subtitle' => null,
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingChoiceRadioRequired()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        //'required' => false,
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
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingChoiceRadioLabel()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        //'label' => 'Label',
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
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingChoiceRadioMicrocopy()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        //'microcopy' => 'Microcopy',
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
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingChoiceRadioOtherOption()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        //'other_option' => true,
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
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingChoiceRadioOptions()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => true,
                        /*'options' => [
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
                        ],*/
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingChoiceRadioOptionName()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => true,
                        'options' => [
                            (object)[
                                //'name' => 'op6',
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
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingChoiceRadioOptionLabel()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => true,
                        'options' => [
                            (object)[
                                'name' => 'op6',
                                //'label' => 'First choice',
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
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingChoiceRadioOptionSelected()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => true,
                        'options' => [
                            (object)[
                                'name' => 'op6',
                                'label' => 'First choice',
                                //'selected' => false,
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
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testAdditionalChoiceRadioAttribute()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
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
                        'this' => 'shouldn\'t be here',
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testAdditionalChoiceRadioOptionAttribute()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => true,
                        'options' => [
                            (object)[
                                'name' => 'op6',
                                'label' => 'First choice',
                                'selected' => false,
                                'this' => 'shouldn\'t be here',
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
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testAdditionalChoiceRadioOtherOptionAttribute()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
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
                                'this' => 'shouldn\'t be here',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidChoiceRadioRequired()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => 'false',
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
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidChoiceRadioLabel()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => null,
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
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidChoiceRadioMicrocopy()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => null,
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
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidChoiceRadioOtherOption()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => 'true',
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
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidChoiceRadioOptions()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => 'true',
                        'options' => 'none',
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidChoiceRadioOptionName()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => 'true',
                        'options' => [
                            (object)[
                                'name' => 6,
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
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidChoiceRadioOptionLabel()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => 'true',
                        'options' => [
                            (object)[
                                'name' => 'op6',
                                'label' => null,
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
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidChoiceRadioOptionSelected()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => 'true',
                        'options' => [
                            (object)[
                                'name' => 'op6',
                                'label' => 'First choice',
                                'selected' => 'false',
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
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidChoiceRadioOptionValues()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => 'true',
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
                                'value' => null,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingChoiceCheckboxRequired()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_checkbox',
                        'name' => 'el12345',
                        //'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
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
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingChoiceCheckboxLabel()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_checkbox',
                        'name' => 'el12345',
                        'required' => false,
                        //'label' => 'Label',
                        'microcopy' => 'Microcopy',
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
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingChoiceCheckboxMicrocopy()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_checkbox',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        //'microcopy' => 'Microcopy',
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
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingChoiceCheckboxOptions()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_checkbox',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        /*'options' => [
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
                        ],*/
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingChoiceCheckboxOptionName()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_checkbox',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'options' => [
                            (object)[
                                //'name' => 'op6',
                                'label' => 'First choice',
                                'selected' => false,
                            ],
                            (object)[
                                'name' => 'op7',
                                'label' => 'Second choice',
                                'selected' => false,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingChoiceCheckboxOptionLabel()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_checkbox',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'options' => [
                            (object)[
                                'name' => 'op6',
                                //'label' => 'First choice',
                                'selected' => false,
                            ],
                            (object)[
                                'name' => 'op7',
                                'label' => 'Second choice',
                                'selected' => false,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingChoiceCheckboxOptionSelected()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_checkbox',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'options' => [
                            (object)[
                                'name' => 'op6',
                                'label' => 'First choice',
                                //'selected' => false,
                            ],
                            (object)[
                                'name' => 'op7',
                                'label' => 'Second choice',
                                'selected' => false,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testAdditionalChoiceCheckboxAttribute()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_checkbox',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
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
                        ],
                        'this' => 'shouldn\'t be here',
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testAdditionalChoiceCheckboxOptionAttribute()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_checkbox',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'options' => [
                            (object)[
                                'name' => 'op6',
                                'label' => 'First choice',
                                'selected' => false,
                                'this' => 'shouldn\'t be here',
                            ],
                            (object)[
                                'name' => 'op7',
                                'label' => 'Second choice',
                                'selected' => false,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidChoiceCheckboxRequired()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_checkbox',
                        'name' => 'el12345',
                        'required' => 'false',
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
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
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidChoiceCheckboxLabel()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_checkbox',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => null,
                        'microcopy' => 'Microcopy',
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
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidChoiceCheckboxMicrocopy()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_checkbox',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => null,
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
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidChoiceCheckboxOptions()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_checkbox',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => null,
                        'options' => 'asdf',
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidChoiceCheckboxOptionName()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_checkbox',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'options' => [
                            (object)[
                                'name' => 6,
                                'label' => 'First choice',
                                'selected' => false,
                            ],
                            (object)[
                                'name' => 'op7',
                                'label' => 'Second choice',
                                'selected' => false,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidChoiceCheckboxOptionLabel()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_checkbox',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'options' => [
                            (object)[
                                'name' => 'op6',
                                'label' => null,
                                'selected' => false,
                            ],
                            (object)[
                                'name' => 'op7',
                                'label' => 'Second choice',
                                'selected' => false,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testInvalidChoiceCheckboxOptionSelected()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_checkbox',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'options' => [
                            (object)[
                                'name' => 'op6',
                                'label' => 'First choice',
                                'selected' => 'false',
                            ],
                            (object)[
                                'name' => 'op7',
                                'label' => 'Second choice',
                                'selected' => false,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testNonUniqueElementNames()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'section',
                        'name' => 'el12345',
                        'title' => 'Title',
                        'subtitle' => '<p>How goes it?</p>',
                    ],
                    (object)[
                        'type' => 'section',
                        'name' => 'el12345',
                        'title' => 'Title 2',
                        'subtitle' => '<p>It goes well.</p>',
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testNonUniqueOptionNames()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_checkbox',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'options' => [
                            (object)[
                                'name' => 'op6',
                                'label' => 'First choice',
                                'selected' => false,
                            ],
                            (object)[
                                'name' => 'op6',
                                'label' => 'Second choice',
                                'selected' => false,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testNoOptionsForChoiceRadio()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => false,
                        'options' => [],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testNoOptionsForChoiceCheckbox()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_checkbox',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'options' => [],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testNonObjectOptionForChoiceRadio()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => false,
                        'options' => [
                            [
                                'name' => 'op6',
                                'label' => 'First choice',
                                'selected' => false,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMultipleOptionsSelectedForChoiceRadio()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => false,
                        'options' => [
                            (object)[
                                'name' => 'op6',
                                'label' => 'First choice',
                                'selected' => true,
                            ],
                            (object)[
                                'name' => 'op7',
                                'label' => 'Second choice',
                                'selected' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testMissingOtherOptionValueForChoiceRadio()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => true,
                        'options' => [
                            (object)[
                                'name' => 'op6',
                                'label' => 'First choice',
                                'selected' => true,
                            ],
                            (object)[
                                'name' => 'op7',
                                'label' => 'Second choice',
                                'selected' => false,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testUnnecessaryOptionValueForChoiceRadio()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => false,
                        'options' => [
                            (object)[
                                'name' => 'op6',
                                'label' => 'First choice',
                                'selected' => true,
                            ],
                            (object)[
                                'name' => 'op7',
                                'label' => 'Second choice',
                                'selected' => false,
                                'value' => '',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testOtherOptionValueOnOtherThanLastOptionForChoiceRadio()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => true,
                        'options' => [
                            (object)[
                                'name' => 'op6',
                                'label' => 'First choice',
                                'selected' => true,
                                'value' => '',
                            ],
                            (object)[
                                'name' => 'op7',
                                'label' => 'Second choice',
                                'selected' => false,
                                'value' => '',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

    public function testOtherOptionValueEmptyIfOtherOptionNotSelectedForChoiceRadio()
    {
        $this->setExpectedException('DomainException');

        $originalConfig = [
            (object)[
                'label' => 'Content',
                'name' => 'tab1',
                'hidden' => false,
                'elements' => [
                    (object)[
                        'type' => 'choice_radio',
                        'name' => 'el12345',
                        'required' => false,
                        'label' => 'Label',
                        'microcopy' => 'Microcopy',
                        'other_option' => true,
                        'options' => [
                            (object)[
                                'name' => 'op6',
                                'label' => 'First choice',
                                'selected' => true,
                            ],
                            (object)[
                                'name' => 'op7',
                                'label' => 'Second choice',
                                'selected' => false,
                                'value' => 'this value should be empty',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $config = new Config($originalConfig);
    }

}
