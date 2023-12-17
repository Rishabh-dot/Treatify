<?php

require 'token_generator.php';
require 'priaid_client.php';

class Demo
{
    private $config;
    private $diagnosisClient;

    function __construct()
    {
        $this->config = parse_ini_file("config.ini");
    }

    private function checkRequiredParameters()
    {
        $pass = true;

        if (!isset($this->config['username'])) {
            $pass = false;
            print "You didn't set username in config.ini";
        }

        if (!isset($this->config['password'])) {
            $pass = false;
            print "You didn't set password in config.ini";
        }

        if (!isset($this->config['authServiceUrl'])) {
            $pass = false;
            print "You didn't set authServiceUrl in config.ini";
        }

        if (!isset($this->config['healthServiceUrl'])) {
            $pass = false;
            print "You didn't set healthserviceUrl in config.ini";
        }

        return $pass;
    }

    public function simulate()
    {
        if (!$this->checkRequiredParameters())
            return;

        $tokenGenerator = new TokenGenerator($this->config['username'], $this->config['password'], $this->config['authServiceUrl']);
        $token = $tokenGenerator->loadToken();

        if (!isset($token))
            exit();

        $this->diagnosisClient = new DiagnosisClient($token, $this->config['healthServiceUrl'], 'en-gb');
        $bodyLocations = $this->diagnosisClient->loadBodyLocations();
        if (!isset($bodyLocations))
            exit();
        $this->printSimpleObject($bodyLocations);
    }

    private function printSimpleObject($object)
    {
        array_map(function ($var) {
            echo "<br><input type='radio' value='", $var['ID'], "' name='body_loc'> ", $var['Name'], "<br>";
        }, $object);
    }
}

$demo = new Demo();
$demo->simulate();

?>