<?php namespace Jenssegers\Agent;

use \Config;

class Agent {

    /**
     * Current user-agent
     *
     * @var string
     */
    protected $agent = null;

    /**
     * Flag for if the user-agent belongs to a browser
     *
     * @var bool
     */
    protected $is_browser = false;

    /**
     * Flag for if the user-agent is a robot
     *
     * @var bool
     */
    protected $is_robot = false;

    /**
     * Flag for if the user-agent is a mobile browser
     *
     * @var bool
     */
    protected $is_mobile = false;

    /**
     * Languages accepted by the current user agent
     *
     * @var array
     */
    protected $languages = array();

    /**
     * Character sets accepted by the current user agent
     *
     * @var array
     */
    protected $charsets = array();

    /**
     * List of platforms to compare against current user agent
     *
     * @var array
     */
    protected $platforms = array();

    /**
     * List of browsers to compare against current user agent
     *
     * @var array
     */
    protected $browsers = array();

    /**
     * List of mobile browsers to compare against current user agent
     *
     * @var array
     */
    protected $mobiles = array();

    /**
     * List of robots to compare against current user agent
     *
     * @var array
     */
    protected $robots = array();

    /**
     * Current user-agent platform
     *
     * @var string
     */
    protected $platform = null;

    /**
     * Current user-agent browser
     *
     * @var string
     */
    protected $browser = null;

    /**
     * Current user-agent version
     *
     * @var string
     */
    protected $version = null;

    /**
     * Current user-agent mobile name
     *
     * @var string
     */
    protected $mobile = null;

    /**
     * Current user-agent robot name
     *
     * @var string
     */
    protected $robot = null;


    /**
     * Construct Agent
     */
    public function __construct()
    {
        // Get the user agent
        if (isset($_SERVER['HTTP_USER_AGENT']))
        {
            $this->agent = trim($_SERVER['HTTP_USER_AGENT']);
        }

        // Load the config
        foreach (array('platforms', 'browsers', 'mobiles', 'robots') as $key)
        {
            $this->{$key} = Config::get("agent::$key");
        }

        // Start building
        if (!is_null($this->agent))
        {
            $this->initialize();
        }
    }


    /**
     * Parse the current user agent
     * 
     * @return void
     */
    protected function initialize()
    {
        $this->_set_platform();

        foreach (array('_set_robot', '_set_browser', '_set_mobile') as $function)
        {
            if ($this->$function() === TRUE)
            {
                break;
            }
        }
    }

    /**
     * Set the Platform
     *
     * @return  bool
     */
    protected function _set_platform()
    {
        if (is_array($this->platforms) && count($this->platforms) > 0)
        {
            foreach ($this->platforms as $key => $val)
            {
                if (preg_match('|'.preg_quote($key).'|i', $this->agent))
                {
                    $this->platform = $val;
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * Set the Browser
     *
     * @return  bool
     */
    protected function _set_browser()
    {
        if (is_array($this->browsers) && count($this->browsers) > 0)
        {
            foreach ($this->browsers as $key => $val)
            {
                if (preg_match('|'.preg_quote($key).'.*?([0-9\.]+)|i', $this->agent, $match))
                {
                    $this->is_browser = true;
                    $this->version = $match[1];
                    $this->browser = $val;
                    $this->_set_mobile();
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * Set the Robot
     *
     * @return  bool
     */
    protected function _set_robot()
    {
        if (is_array($this->robots) && count($this->robots) > 0)
        {
            foreach ($this->robots as $key => $val)
            {
                if (preg_match('|'.preg_quote($key).'|i', $this->agent))
                {
                    $this->is_robot = true;
                    $this->robot = $val;
                    $this->_set_mobile();
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Set the Mobile Device
     *
     * @return  bool
     */
    protected function _set_mobile()
    {
        if (is_array($this->mobiles) && count($this->mobiles) > 0)
        {
            foreach ($this->mobiles as $key => $val)
            {
                if (false !== (stripos($this->agent, $key)))
                {
                    $this->is_mobile = true;
                    $this->mobile = $val;
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Set the accepted languages
     *
     * @return  void
     */
    protected function _set_languages()
    {
        if ((count($this->languages) === 0) && ! empty($_SERVER['HTTP_ACCEPT_LANGUAGE']))
        {
            $this->languages = explode(',', preg_replace('/(;q=[0-9\.]+)/i', '', strtolower(trim($_SERVER['HTTP_ACCEPT_LANGUAGE']))));
        }

        if (count($this->languages) === 0)
        {
            $this->languages = array();
        }
    }


    /**
     * Set the accepted character sets
     *
     * @return  void
     */
    protected function _set_charsets()
    {
        if ((count($this->charsets) === 0) && ! empty($_SERVER['HTTP_ACCEPT_CHARSET']))
        {
            $this->charsets = explode(',', preg_replace('/(;q=.+)/i', '', strtolower(trim($_SERVER['HTTP_ACCEPT_CHARSET']))));
        }

        if (count($this->charsets) === 0)
        {
            $this->charsets = array();
        }
    }


    /**
     * Is Browser
     *
     * @param   string  $key
     * @return  bool
     */
    public function isBrowser($key = null)
    {
        if (!$this->is_browser)
        {
            return false;
        }

        // No need to be specific, it's a browser
        if ($key === null)
        {
            return true;
        }

        // Check for a specific browser
        return (isset($this->browsers[$key]) && $this->browser === $this->browsers[$key]);
    }


    /**
     * Is Robot
     *
     * @param   string  $key
     * @return  bool
     */
    public function isRobot($key = null)
    {
        if (!$this->is_robot)
        {
            return false;
        }

        // No need to be specific, it's a robot
        if ($key === null)
        {
            return true;
        }

        // Check for a specific robot
        return (isset($this->robots[$key]) && $this->robot === $this->robots[$key]);
    }


    /**
     * Is Mobile
     *
     * @param   string  $key
     * @return  bool
     */
    public function isMobile($key = null)
    {
        if (!$this->is_mobile)
        {
            return false;
        }

        // No need to be specific, it's a mobile
        if ($key === null)
        {
            return true;
        }

        // Check for a specific robot
        return (isset($this->mobiles[$key]) && $this->mobile === $this->mobiles[$key]);
    }


    /**
     * Agent String
     *
     * @return  string
     */
    public function agent()
    {
        return $this->agent;
    }


    /**
     * Get Platform
     *
     * @return  string
     */
    public function platform()
    {
        return $this->platform;
    }


    /**
     * Get Browser Name
     *
     * @return  string
     */
    public function browser()
    {
        return $this->browser;
    }


    /**
     * Get the Browser Version
     *
     * @return  string
     */
    public function version()
    {
        return $this->version;
    }


    /**
     * Get The Robot Name
     *
     * @return  string
     */
    public function robot()
    {
        return $this->robot;
    }


    /**
     * Get the Mobile Device
     *
     * @return  string
     */
    public function mobile()
    {
        return $this->mobile;
    }


    /**
     * Get the referrer
     *
     * @return  bool
     */
    public function referrer()
    {
        return empty($_SERVER['HTTP_REFERER']) ? '' : trim($_SERVER['HTTP_REFERER']);
    }


    /**
     * Get the accepted languages
     *
     * @return  array
     */
    public function languages()
    {
        if (count($this->languages) === 0)
        {
            $this->_set_languages();
        }

        return $this->languages;
    }


    /**
     * Get the accepted Character Sets
     *
     * @return  array
     */
    public function charsets()
    {
        if (count($this->charsets) === 0)
        {
            $this->_set_charsets();
        }

        return $this->charsets;
    }


    /**
     * Test for a particular language
     *
     * @param   string  $lang
     * @return  bool
     */
    public function acceptLang($lang = 'en')
    {
        return in_array(strtolower($lang), $this->languages(), true);
    }


    /**
     * Test for a particular character set
     *
     * @param   string  $charset
     * @return  bool
     */
    public function acceptCharset($charset = 'utf-8')
    {
        return in_array(strtolower($charset), $this->charsets(), true);
    }

}