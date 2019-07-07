Agent
=====

[![Financial Contributors on Open Collective](https://opencollective.com/agent/all/badge.svg?label=financial+contributors)](https://opencollective.com/agent) [![Latest Stable Version](http://img.shields.io/packagist/v/jenssegers/agent.svg)](https://packagist.org/packages/jenssegers/agent) [![Total Downloads](http://img.shields.io/packagist/dm/jenssegers/agent.svg)](https://packagist.org/packages/jenssegers/agent) [![Build Status](http://img.shields.io/travis/jenssegers/agent.svg)](https://travis-ci.org/jenssegers/agent) [![Coverage Status](http://img.shields.io/coveralls/jenssegers/agent.svg)](https://coveralls.io/r/jenssegers/agent) [![Donate](https://img.shields.io/badge/donate-paypal-blue.svg)](https://www.paypal.me/jenssegers)

A PHP desktop/mobile user agent parser with support for Laravel, based on [Mobile Detect](https://github.com/serbanghita/Mobile-Detect) with desktop support and additional functionality.

<p align="center">
<img src="http://jenssegers.be/uploads/images/agent.png?v4" height="275">
</p>

Installation
------------

Install using composer:

```bash
composer require jenssegers/agent
```

Laravel (optional)
------------------

Add the service provider in `config/app.php`:

```php
Jenssegers\Agent\AgentServiceProvider::class,
```

And add the Agent alias to `config/app.php`:

```php
'Agent' => Jenssegers\Agent\Facades\Agent::class,
```

Basic Usage
-----------

Start by creating an `Agent` instance (or use the `Agent` Facade if you are using Laravel):

```php
use Jenssegers\Agent\Agent;

$agent = new Agent();
```

If you want to parse user agents other than the current request in CLI scripts for example, you can use the `setUserAgent` and `setHttpHeaders` methods:

```php
$agent->setUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/537.13+ (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2');
$agent->setHttpHeaders($headers);
```

All of the original [Mobile Detect](https://github.com/serbanghita/Mobile-Detect) methods are still available, check out some original examples at https://github.com/serbanghita/Mobile-Detect/wiki/Code-examples

### Is?

Check for a certain property in the user agent.

```php
$agent->is('Windows');
$agent->is('Firefox');
$agent->is('iPhone');
$agent->is('OS X');
```

### Magic is-method

Magic method that does the same as the previous `is()` method:

```php
$agent->isAndroidOS();
$agent->isNexus();
$agent->isSafari();
```

### Mobile detection

Check for mobile device:

```php
$agent->isMobile();
$agent->isTablet();
```

### Match user agent

Search the user agent with a regular expression:

```php
$agent->match('regexp');
```

Additional Functionality
------------------------

### Accept languages

Get the browser's accept languages. Example:

```php
$languages = $agent->languages();
// ['nl-nl', 'nl', 'en-us', 'en']
```

### Device name

Get the device name, if mobile. (iPhone, Nexus, AsusTablet, ...)

```php
$device = $agent->device();
```

### Operating system name

Get the operating system. (Ubuntu, Windows, OS X, ...)

```php
$platform = $agent->platform();
```

### Browser name

Get the browser name. (Chrome, IE, Safari, Firefox, ...)

```php
$browser = $agent->browser();
```

### Desktop detection

Check if the user is using a desktop device.

```php
$agent->isDesktop();
```

*This checks if a user is not a mobile device, tablet or robot.*

### Phone detection

Check if the user is using a phone device.

```php
$agent->isPhone();
```

### Robot detection

Check if the user is a robot. This uses [jaybizzle/crawler-detect](https://github.com/JayBizzle/Crawler-Detect) to do the actual robot detection.

```php
$agent->isRobot();
```

### Robot name

Get the robot name.

```php
$robot = $agent->robot();
```

### Browser/platform version

MobileDetect recently added a `version` method that can get the version number for components. To get the browser or platform version you can use:

```php
$browser = $agent->browser();
$version = $agent->version($browser);

$platform = $agent->platform();
$version = $agent->version($platform);
```

*Note, the version method is still in beta, so it might not return the correct result.*

## Contributors

### Code Contributors

This project exists thanks to all the people who contribute. [[Contribute](CONTRIBUTING.md)].
<a href="https://github.com/jenssegers/agent/graphs/contributors"><img src="https://opencollective.com/agent/contributors.svg?width=890&button=false" /></a>

### Financial Contributors

Become a financial contributor and help us sustain our community. [[Contribute](https://opencollective.com/agent/contribute)]

#### Individuals

<a href="https://opencollective.com/agent"><img src="https://opencollective.com/agent/individuals.svg?width=890"></a>

#### Organizations

Support this project with your organization. Your logo will show up here with a link to your website. [[Contribute](https://opencollective.com/agent/contribute)]

<a href="https://opencollective.com/agent/organization/0/website"><img src="https://opencollective.com/agent/organization/0/avatar.svg"></a>
<a href="https://opencollective.com/agent/organization/1/website"><img src="https://opencollective.com/agent/organization/1/avatar.svg"></a>
<a href="https://opencollective.com/agent/organization/2/website"><img src="https://opencollective.com/agent/organization/2/avatar.svg"></a>
<a href="https://opencollective.com/agent/organization/3/website"><img src="https://opencollective.com/agent/organization/3/avatar.svg"></a>
<a href="https://opencollective.com/agent/organization/4/website"><img src="https://opencollective.com/agent/organization/4/avatar.svg"></a>
<a href="https://opencollective.com/agent/organization/5/website"><img src="https://opencollective.com/agent/organization/5/avatar.svg"></a>
<a href="https://opencollective.com/agent/organization/6/website"><img src="https://opencollective.com/agent/organization/6/avatar.svg"></a>
<a href="https://opencollective.com/agent/organization/7/website"><img src="https://opencollective.com/agent/organization/7/avatar.svg"></a>
<a href="https://opencollective.com/agent/organization/8/website"><img src="https://opencollective.com/agent/organization/8/avatar.svg"></a>
<a href="https://opencollective.com/agent/organization/9/website"><img src="https://opencollective.com/agent/organization/9/avatar.svg"></a>

## License

Laravel User Agent is licensed under [The MIT License (MIT)](LICENSE).
