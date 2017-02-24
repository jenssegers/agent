<?php

// Mobiledetect tests are still the old phpunit class.
if (! class_exists('PHPUnit_Framework_TestCase')) {
    class_alias(PHPUnit\Framework\TestCase::class, 'PHPUnit_Framework_TestCase');
}

require 'vendor/mobiledetect/mobiledetectlib/tests/VendorsTest_tmp.php';

use Jenssegers\Agent\Agent;

class VendorsTestExtended extends VendorsTest
{
    /**
     * @var Agent
     */
    protected $detect;

    public function setUp()
    {
        $this->detect = new Agent;
    }
}
