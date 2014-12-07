<?php

use Jenssegers\Agent\Agent;

class AgentTest extends PHPUnit_Framework_TestCase {

    private $operatingSystems = array(
        'Windows' => 'Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko',
        'OS X' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/537.13+ (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2',
        'iOS' => 'Mozilla/5.0 (iPad; CPU OS 5_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko ) Version/5.1 Mobile/9B176 Safari/7534.48.3',
        'Ubuntu' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:24.0) Gecko/20100101 Firefox/24.0',
        'BlackBerryOS' => 'Mozilla/5.0 (BlackBerry; U; BlackBerry 9900; en) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.1.0.346 Mobile Safari/534.11+',
        'AndroidOS' => 'Mozilla/5.0 (Linux; U; Android 2.2; en-us; Nexus One Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
    );

    private $browsers = array(
        'IE' => 'Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko',
        'Safari' => 'Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5355d Safari/8536.25',
        'Netscape' => 'Mozilla/5.0 (Windows; U; Win 9x 4.90; SG; rv:1.9.2.4) Gecko/20101104 Netscape/9.1.0285',
        'Firefox' => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:25.0) Gecko/20100101 Firefox/25.0',
        'Chrome' => 'Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1667.0 Safari/537.36',
        'Mozilla' => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201',
        'Opera' => 'Opera/9.80 (Windows NT 6.0) Presto/2.12.388 Version/12.14',
    );

    private $robots = array(
        'Google' => 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
        'Facebook' => 'facebookexternalhit/1.1 (+http(s)://www.facebook.com/externalhit_uatext.php)',
        'Bing' => 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)',
    );

    private $devices = array(
        'iPhone' => 'Mozilla/5.0 (iPhone; U; ru; CPU iPhone OS 4_2_1 like Mac OS X; ru) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148a Safari/6533.18.5',
        'iPad' => 'Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5355d Safari/8536.25',
        'HTC' => 'Mozilla/5.0 (Linux; U; Android 2.3.4; fr-fr; HTC Desire Build/GRJ22) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
        'BlackBerry' => 'Mozilla/5.0 (BlackBerry; U; BlackBerry 9900; en) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.1.0.346 Mobile Safari/534.11+',
        'Nexus' => 'Mozilla/5.0 (Linux; U; Android 2.2; en-us; Nexus One Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
        'AsusTablet' => 'Mozilla/5.0 (Linux; U; Android 4.0.3; en-us; ASUS Transformer Pad TF300T Build/IML74K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
    );

    private $browserVersions = array(
        '10.6' => 'Mozilla/5.0 (compatible; MSIE 10.6; Windows NT 6.1; Trident/5.0; InfoPath.2; SLCC1; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET CLR 2.0.50727) 3gpp-gba UNTRUSTED/1.0',
        '11.0' => 'Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko',
        '6.0' => 'Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5355d Safari/8536.25',
        '9.1.0285' => 'Mozilla/5.0 (Windows; U; Win 9x 4.90; SG; rv:1.9.2.4) Gecko/20101104 Netscape/9.1.0285',
        '25.0' => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:25.0) Gecko/20100101 Firefox/25.0',
        '32.0.1667.0' => 'Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1667.0 Safari/537.36',
        '2.2' => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201',
        '12.14' => 'Opera/9.80 (Windows NT 6.0) Presto/2.12.388 Version/12.14',
        '11.51' => 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; de) Opera 11.51'
    );

    private $operatingSystemVersions = array(
        '6.3' => 'Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko',
        '10_6_8' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/537.13+ (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2',
        '5_1' => 'Mozilla/5.0 (iPad; CPU OS 5_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko ) Version/5.1 Mobile/9B176 Safari/7534.48.3',
        '7.1.0.346' => 'Mozilla/5.0 (BlackBerry; U; BlackBerry 9900; en) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.1.0.346 Mobile Safari/534.11+',
        '2.2' => 'Mozilla/5.0 (Linux; U; Android 2.2; en-us; Nexus One Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
    );

    private $desktops = array(
        'Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko',
        'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:24.0) Gecko/20100101 Firefox/24.0',
        'Mozilla/5.0 (Windows; U; Win 9x 4.90; SG; rv:1.9.2.4) Gecko/20101104 Netscape/9.1.0285',
        'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:25.0) Gecko/20100101 Firefox/25.0',
        'Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1667.0 Safari/537.36',
        'Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201',
        'Opera/9.80 (Windows NT 6.0) Presto/2.12.388 Version/12.14',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/537.13+ (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2',
    );

    public function testLanguages()
    {
        $agent = new Agent;
        $agent->setHttpHeaders(array(
            'HTTP_ACCEPT_LANGUAGE'  => 'nl-NL,nl;q=0.8,en-US;q=0.6,en;q=0.4'
        ));

        $this->assertEquals(array('nl-nl', 'nl', 'en-us', 'en'), $agent->languages());
    }

    public function testOperatingSystems()
    {
        $agent = new Agent;

        foreach($this->operatingSystems as $platform => $ua)
        {
            $agent->setUserAgent($ua);
            $this->assertTrue($agent->is($platform), $platform);
            $this->assertEquals($platform, $agent->platform());

            if (!strpos($platform, ' '))
            {
                $method = "is{$platform}";
                $this->assertTrue($agent->{$method}());
            }
        }
    }

    public function testBrowsers()
    {
        $agent = new Agent;

        foreach($this->browsers as $browser => $ua)
        {
            $agent->setUserAgent($ua);
            $this->assertTrue($agent->is($browser), $browser);
            $this->assertEquals($browser, $agent->browser());

            if (!strpos($browser, ' '))
            {
                $method = "is{$browser}";
                $this->assertTrue($agent->{$method}());
            }
        }
    }

    public function testRobots()
    {
        $agent = new Agent;

        foreach($this->robots as $robot => $ua)
        {
            $agent->setUserAgent($ua);
            $this->assertTrue($agent->isRobot());
        }
    }

    public function testDevices()
    {
        $agent = new Agent;

        foreach($this->devices as $device => $ua)
        {
            $agent->setUserAgent($ua);
            $this->assertTrue($agent->isMobile());
            $this->assertEquals($device, $agent->device());

            if (!strpos($device, ' '))
            {
                $method = "is{$device}";
                $this->assertTrue($agent->{$method}());
            }
        }
    }

    public function testVersions()
    {
        $agent = new Agent;

        foreach($this->browserVersions as $version => $ua)
        {
            $agent->setUserAgent($ua);
            $browser = $agent->browser();
            $this->assertEquals($version, $agent->version($browser));
        }

        foreach($this->operatingSystemVersions as $version => $ua)
        {
            $agent->setUserAgent($ua);
            $platform = $agent->platform();
            $this->assertEquals($version, $agent->version($platform));
        }
    }

    public function testDesktop()
    {
        $agent = new Agent;

        foreach($this->desktops as $ua)
        {
            $agent->setUserAgent($ua);
            $this->assertTrue($agent->isDesktop());
        }

        foreach($this->robots as $ua)
        {
            $agent->setUserAgent($ua);
            $this->assertFalse($agent->isDesktop());
        }

        foreach($this->devices as $ua)
        {
            $agent->setUserAgent($ua);
            $this->assertFalse($agent->isDesktop());
        }
    }

}
