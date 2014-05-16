TimeTraveler
===========

[![Build Status](https://secure.travis-ci.org/rezzza/TimeTraveler.png)](http://travis-ci.org/rezzza/TimeTraveler)

`````
          _
         /-\
    _____|#|_____
   |_____________|
  |_______________|
|||_Time_Traveler_|||
 | |¯|¯|¯|||¯|¯|¯| |
 | |-|-|-|||-|-|-| |
 | |_|_|_|||_|_|_| |
 | ||~~~| | |¯¯¯|| |
 | ||~~~|!|!| O || |
 | ||~~~| |.|___|| |
 | ||¯¯¯| | |¯¯¯|| |
 | ||   | | |   || |
 | ||___| | |___|| |
 | ||¯¯¯| | |¯¯¯|| |
 | ||   | | |   || |
 | ||___| | |___|| |
|¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯|
 ¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯
`````

Mock the time system in PHP using [AOP-PHP](https://github.com/AOP-PHP/AOP). You can now travel the time on your application easily !


Methods supported
-----------------

- `DateTime` object.
- `date_create`
- `date`
- `gmdate`
- `microtime`
- `strtotime`
- `time`

Usage
-----

```php
Rezzza\TimeTraveler::enable();
Rezzza\TimeTraveler::moveTo('2011-06-10 11:00:00');

var_dump(new \DateTime());           // 2011-06-10 11:00:00
var_dump(new \DateTime('+2 hours')); // 2011-06-10 13:00:00
var_dump(time());
var_dump(microtime());
var_dump(microtime(true));

Rezzza\TimeTraveler::comeBack();
```


Launch tests
------------

```
composer install --dev
bin/atoum
```
