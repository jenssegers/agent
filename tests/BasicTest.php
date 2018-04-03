<?php

require __DIR__ . '/../vendor/mobiledetect/mobiledetectlib/tests/BasicsTest.php';

use Jenssegers\Agent\Agent;

class BasicTestExtended extends BasicTest
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
