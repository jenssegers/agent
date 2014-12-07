<?php

require 'vendor/mobiledetect/mobiledetectlib/tests/VendorsTest_tmp.php';
use Jenssegers\Agent\Agent;

class VendorsTestExtended extends VendorsTest
{
    protected $detect;

    public function setUp()
    {
        $this->detect = new Agent;
    }

}
