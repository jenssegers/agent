<?php

namespace Jenssegers\Agent\Contracts;

use Mobile_Detect;

interface Agent
{
    /**
     * Set the HTTP Headers.
     *
     * @param  array  $httpHeaders
     */
    public function setHttpHeaders($httpHeaders = null);

    /**
     * Set the User-Agent to be used.
     *
     * @param  string|null  $userAgent
     *
     * @return string|null
     */
    public function setUserAgent($userAgent = null);

    /**
     * Get accept languages.
     *
     * @param  string|null  $acceptLanguage
     *
     * @return array
     */
    public function languages($acceptLanguage = null);

    /**
     * Get the browser name.
     *
     * @param  string|null  $userAgent
     *
     * @return string
     */
    public function browser($userAgent = null);

    /**
     * Get the platform name.
     *
     * @param  string|null  $userAgent
     *
     * @return string
     */
    public function platform($userAgent = null);

    /**
     * Get the device name.
     *
     * @param  string|null  $userAgent
     *
     * @return string
     */
    public function device($userAgent = null);

    /**
     * Check if the device is a desktop computer.
     *
     * @return bool
     */
    public function isDesktop();

    /**
     * Check if the device is a mobile phone.
     *
     * @return bool
     */
    public function isPhone();

    /**
     * This method checks for a certain property in the userAgent.
     *
     * @param  string        $key
     * @param  string        $userAgent   deprecated
     * @param  string        $httpHeaders deprecated
     *
     * @return bool|int|null
     */
    public function is($key, $userAgent = null, $httpHeaders = null);

    /**
     * Get the robot name.
     *
     * @param  string|null  $userAgent
     *
     * @return string
     */
    public function robot($userAgent = null);

    /**
     * Check if device is a robot.
     *
     * @param  string|null  $userAgent
     *
     * @return bool
     */
    public function isRobot($userAgent = null);

    /**
     * Check the version of the given property in the User-Agent.
     *
     * @param  string  $propertyName
     * @param  string  $type
     *
     * @return string|float
     */
    public function version($propertyName, $type = Mobile_Detect::VERSION_TYPE_STRING);

    /**
     * Some detection rules are relative (not standard), because of the diversity of devices,
     * vendors and their conventions in representing the User-Agent or the HTTP headers.
     *
     * @param  string       $regex
     * @param  string|null  $userAgent
     *
     * @return bool
     */
    public function match($regex, $userAgent = null);
}
