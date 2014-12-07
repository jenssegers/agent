<?php

require 'vendor/mobiledetect/mobiledetectlib/tests/UserAgentTest.php';
use Jenssegers\Agent\Agent;

class UserAgentTestExtended extends UserAgentTest
{

    /**
     * @medium
     * @dataProvider userAgentData
     */
    public function testUserAgents($userAgent, $isMobile, $isTablet, $version, $model, $vendor)
    {
        //make sure we're passed valid data
        if (!is_string($userAgent) || !is_bool($isMobile) || !is_bool($isTablet)) {
            $this->markTestIncomplete("The User-Agent $userAgent does not have sufficient information for testing.");

            return;
        }

        //setup
        $md = new Agent;
        $md->setUserAgent($userAgent);

        //is mobile?
        $this->assertEquals($md->isMobile(), $isMobile);

        //is tablet?
        $this->assertEquals($md->isTablet(), $isTablet, 'FAILED: ' . $userAgent . ' isTablet: ' . $isTablet);

        if (isset($version)) {
            foreach ($version as $condition => $assertion) {
                $this->assertEquals($assertion, $md->version($condition), 'FAILED UA (version("'.$condition.'")): '.$userAgent);
            }
        }

        //version property tests
        if (isset($version)) {
            foreach ($version as $property => $stringVersion) {
                $v = $md->version($property);
                $this->assertSame($stringVersion, $v);
            }
        }

        //@todo: model test, not sure how exactly yet
        //@todo: vendor test. The below is theoretical, but fails 50% of the tests...
        /*if (isset($vendor)) {
            $method = "is$vendor";
            $this->assertTrue($md->{$method}(), "Expected Mobile_Detect::{$method}() to be true.");
        }*/
    }
}
