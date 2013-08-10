Laravel 4 User Agent
====================

A user agent class for Laravel 4, based on the CodeIgniter user agent library.

Installation
------------

Add the package to your `composer.json` or install manually.

	{
	    "require": {
	        "jenssegers/agent": "*"
	    }
	}

Run composer update to download and install the package.

Add the service provider in `app/config/app.php`:

	'Jenssegers\Agent\AgentServiceProvider',

And add an alias:

	'Agent'            => 'Jenssegers\Agent\Facades\Agent',

Usage
-----

*This documentation is taken from http://ellislab.com/codeigniter/user-guide/libraries/user_agent.html*

When the User Agent class is initialized it will attempt to determine whether the user agent browsing your site is a web browser, a mobile device, or a robot. It will also gather the platform information if it is available.

	if (Agent::isBrowser())
	{
	    $agent = Agent::browser() . ' ' . Agent::version();
	}
	elseif (Agent::isRobot())
	{
	    $agent = Agent::robot();
	}
	elseif (Agent::isMobile())
	{
	    $agent = Agent::mobile();
	}
	else
	{
	    $agent = 'Unidentified User Agent';
	}

	echo $agent;

	echo Agent::platform(); // Platform info (Windows, Linux, Mac, etc.)


### Agent::isBrowser()

Returns TRUE/FALSE (boolean) if the user agent is a known web browser.

	if (Agent::isBrowser('Safari'))
	{
	    echo 'You are using Safari.';
	}
	else if (Agent::isBrowser())
	{
	    echo 'You are using a browser.';
	}

### Agent::isMobile()

Returns TRUE/FALSE (boolean) if the user agent is a known mobile device.

	if (Agent::isMobile('iphone'))
	{
	    $this->load->view('iphone/home');
	}
	else if (Agent::isMobile())
	{
	    $this->load->view('mobile/home');
	}
	else
	{
	    $this->load->view('web/home');
	}

### Agent::isRobot()

Returns TRUE/FALSE (boolean) if the user agent is a known robot.

### Agent::browser()

Returns a string containing the name of the web browser viewing your site.

### Agent::version()

Returns a string containing the version number of the web browser viewing your site.

### Agent::mobile()

Returns a string containing the name of the mobile device viewing your site.

### Agent::robot()

Returns a string containing the name of the robot viewing your site.

### Agent::platform()

Returns a string containing the platform viewing your site (Linux, Windows, OS X, etc.).

### Agent::agent()

Returns a string containing the full user agent string. Typically it will be something like this:

	Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en-US; rv:1.8.0.4) Gecko/20060613 Camino/1.0.2

### Agent::acceptLang()

Lets you determine if the user agent accepts a particular language. Example:

	if (Agent::acceptLang('en'))
	{
	    echo 'You accept English!';
	}

### Agent::acceptCharset()

Lets you determine if the user agent accepts a particular character set. Example:

	if (Agent::acceptCharset('utf-8'))
	{
	    echo 'You browser supports UTF-8!';
	}