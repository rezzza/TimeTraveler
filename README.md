TimeTraveler
===========

[![Build Status](https://secure.travis-ci.org/rezzza/TimeTraveler.png)](http://travis-ci.org/rezzza/TimeTraveler)

Mock the time system in PHP using [AOP-PHP](https://github.com/AOP-PHP/AOP). You can now travel the time on your application easily !

Methods supported
-----------------

- `DateTime` object.
- `time`

Methods not supported
---------------------

- `microtime`

Usage
-----

```php
use Rezzza\TimeTraveler\TimeTraveler;

TimeTraveler::enable();
TimeTraveler::setCurrentDate('2011-06-10 11:00:00');

var_dump(new \DateTime());
var_dump(time());
```


Launch tests
------------

```
composer install --dev
bin/atoum -d tests/units
```
