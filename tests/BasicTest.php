<?php

require 'vendor/mobiledetect/mobiledetectlib/tests/BasicsTest.php';

use Jenssegers\Agent\Agent;

class BasicTestExtended extends BasicTest
{
    /**
     * @var Mobile_Detect
     */
    protected $detect;

    public function setUp()
    {
        $this->detect = new Agent;
    }
}
