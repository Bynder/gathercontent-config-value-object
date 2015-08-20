<?php

namespace GatherContent\ConfigValueObject;

final class Config
{
    private $config;

    public function __construct($config, Validator $validator = null)
    {
        $this->validator = $validator ?: new Validator;

        $this->validator->validate($config);

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
        return (string) $this === (string) $config;
    }
}
