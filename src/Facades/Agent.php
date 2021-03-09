<?php

namespace Jenssegers\Agent\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array getRules()
 * @method static \Jaybizzle\CrawlerDetect\CrawlerDetect getCrawlerDetect()
 * @method static array getBrowsers()
 * @method static array getOperatingSystems()
 * @method static array getPlatforms()
 * @method static array getDesktopDevices()
 * @method static array getProperties()
 * @method static array languages()
 * @method static string|bool browser()
 * @method static string|bool platform()
 * @method static string|bool device()
 * @method static bool isDesktop()
 * @method static bool isPhone()
 * @method static string|bool robot()
 * @method static bool isRobot()
 * @method static string deviceType()
 * @method static string|bool version($propertyName, $type = 'string')
 */
class Agent extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'agent';
    }
}
