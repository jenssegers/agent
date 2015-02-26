<?php namespace Jenssegers\Agent;

use BadMethodCallException;
use Mobile_Detect;

class Agent extends Mobile_Detect {

    /**
     * List of additional operating systems.
     *
     * @var array
     */
    protected static $additionalOperatingSystems = array(
        'Windows'           => 'Windows',
        'Windows NT'        => 'Windows NT',
        'OS X'              => 'Mac OS X',
        'Debian'            => 'Debian',
        'Ubuntu'            => 'Ubuntu',
        'Macintosh'         => 'PPC',
        'OpenBSD'           => 'OpenBSD',
        'Linux'             => 'Linux',
    );

    /**
     * List of additional browsers.
     *
     * @var array
     */
    protected static $additionalBrowsers = array(
        'Opera'             => 'Opera|OPR',
        'Chrome'            => 'Chrome',
        'Firefox'           => 'Firefox',
        'Safari'            => 'Safari',
        'IE'                => 'MSIE|IEMobile|MSIEMobile|Trident/[.0-9]+',
        'Netscape'          => 'Netscape',
        'Mozilla'           => 'Mozilla',
    );

    /**
     * List of additional browsers.
     *
     * @var array
     */
    protected static $additionalProperties = array(

        // Operating systems
        'Windows'           => 'Windows NT [VER]',
        'Windows NT'        => 'Windows NT [VER]',
        'OS X'              => 'OS X [VER]',
        'BlackBerryOS'      => array('BlackBerry[\w]+/[VER]', 'BlackBerry.*Version/[VER]', 'Version/[VER]'),
        'AndroidOS'         => 'Android [VER]',

        // Browsers
        'Opera'             => array(' OPR/[VER]', 'Opera Mini/[VER]', 'Version/[VER]', 'Opera [VER]'),
        'Netscape'          => 'Netscape/[VER]',
        'Mozilla'           => 'rv:[VER]',
        'IE'                => array('IEMobile/[VER];', 'IEMobile [VER]', 'MSIE [VER];', 'rv:[VER]')
    );

    /**
     * List of robots.
     *
     * @var array
     */
    protected static $robots = array(
        'Googlebot'         => 'googlebot',
        'MSNBot'            => 'msnbot',
        'Baiduspider'       => 'baiduspider',
        'Bing'              => 'bingbot',
        'Yahoo'             => 'yahoo',
        'Lycos'             => 'lycos',
    );

    /**
     * Get all detection rules. These rules include the additional
     * platforms and browsers.
     *
     * @return array
     */
    public function getDetectionRulesExtended()
    {
        static $rules;

        if (!$rules)
        {
            $rules = $this->mergeRules(
                static::$phoneDevices,
                static::$tabletDevices,
                static::$operatingSystems,
                static::$additionalOperatingSystems, // NEW
                static::$browsers,
                static::$additionalBrowsers, // NEW
                static::$utilities
            );
        }

        return $rules;
    }

    /**
     * Retrieve the current set of rules.
     *
     * @return array
     */
    public function getRules()
    {
        if ($this->detectionType == static::DETECTION_TYPE_EXTENDED)
        {
            return static::getDetectionRulesExtended();
        }
        else
        {
            return static::getMobileDetectionRules();
        }
    }

    /**
     * Get accept languages.
     *
     * @return array
     */
    public function languages($acceptLanguage = null)
    {
        if (!$acceptLanguage)
        {
            $acceptLanguage = $this->getHttpHeader('HTTP_ACCEPT_LANGUAGE');
        }

        if ($acceptLanguage)
        {
            return explode(',', preg_replace('/(;q=[0-9\.]+)/i', '', strtolower(trim($acceptLanguage))));
        }

        return array();
    }

    /**
     * Match a detection rule and return the matched key.
     *
     * @param  array     $rules
     * @param  null      $userAgent
     * @return string
     */
    protected function findDetectionRulesAgainstUA(array $rules, $userAgent = null)
    {
        // Loop given rules
        foreach ($rules as $key => $regex)
        {
            if (empty($regex)) continue;

            // Check match
            if ($this->match($regex, $userAgent)) return $key;
        }

        return false;
    }

    /**
     * Get the browser name.
     *
     * @return string
     */
    public function browser($userAgent = null)
    {
        // Get browser rules
        // Here we need to test for the additional browser first, otherwise
        // MobileDetect will mostly detect Chrome as the browser.
        $rules = $this->mergeRules(
            static::$additionalBrowsers, // NEW
            static::$browsers
        );

        return $this->findDetectionRulesAgainstUA($rules, $userAgent);
    }

    /**
     * Get the platform name.
     *
     * @param  string $userAgent
     * @return string
     */
    public function platform($userAgent = null)
    {
        // Get platform rules
        $rules = $this->mergeRules(
            static::$operatingSystems,
            static::$additionalOperatingSystems // NEW
        );

        return $this->findDetectionRulesAgainstUA($rules, $userAgent);
    }

    /**
     * Get the device name.
     *
     * @param  string $userAgent
     * @return string
     */
    public function device($userAgent = null)
    {
        // Get device rules
        $rules = $this->mergeRules(
            static::$phoneDevices,
            static::$tabletDevices,
            static::$utilities
        );

        return $this->findDetectionRulesAgainstUA($rules, $userAgent);
    }

    /**
     * Check if the device is a desktop computer.
     *
     * @param  string $userAgent   deprecated
     * @param  array  $httpHeaders deprecated
     * @return bool
     */
    public function isDesktop($userAgent = null, $httpHeaders = null)
    {
        return (! $this->isMobile() && ! $this->isTablet() && ! $this->isRobot());
    }

    /**
     * Check if device is a robot.
     *
     * @param  string  $userAgent
     * @return boolean
     */
    public function isRobot($userAgent = null)
    {
        // Get bot rules
        $rules = $this->mergeRules(
            array(static::$utilities['Bot']),
            static::$robots // NEW
        );

        foreach ($rules as $regex)
        {
            // Check for match
            if ($this->match($regex, $userAgent)) return true;
        }

        return false;
    }

    /**
     * Check the version of the given property in the User-Agent.
     *
     * @inherit
     */
    public function version($propertyName, $type = self::VERSION_TYPE_STRING)
    {
        $check = key(static::$additionalProperties);

        // Check if the additional properties have been added already
        if ( ! array_key_exists($check, parent::$properties))
        {
            // TODO: why is mergeRules not working here?
            parent::$properties = array_merge(
                parent::$properties,
                static::$additionalProperties
            );
        }

        return parent::version($propertyName, $type);
    }

    /**
     * Merge multiple rules into one array.
     *
     * @return array
     */
    protected function mergeRules()
    {
        $merged = array();

        foreach (func_get_args() as $rules)
        {
            foreach ($rules as $key => $value)
            {
                if (empty($merged[$key]))
                {
                    $merged[$key] = $value;
                }
                else
                {
                    if (is_array($merged[$key]))
                    {
                        $merged[$key][] = $value;
                    }
                    else
                    {
                        $merged[$key] .= '|' . $value;
                    }
                }
            }
        }

        return $merged;
    }

    /**
     * Changing detection type to extended.
     *
     * @inherit
     */
    public function __call($name, $arguments)
    {
        //make sure the name starts with 'is', otherwise
        if (substr($name, 0, 2) != 'is')
        {
            throw new BadMethodCallException("No such method exists: $name");
        }

        $this->setDetectionType(self::DETECTION_TYPE_EXTENDED);

        $key = substr($name, 2);

        return $this->matchUAAgainstKey($key);
    }

}
