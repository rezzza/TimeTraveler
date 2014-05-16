<?php

namespace tests\units\Rezzza;

use mageekguy\atoum;
use Rezzza\TimeTraveler as TestedClass;

class TimeTraveler extends atoum\test
{
    public function testSetCurrentDate()
    {
        $this->if(TestedClass::moveTo('now'))
            ->integer(TestedClass::getCurrentTimeOffset())
            ->isEqualTo(0)

            ->and(TestedClass::moveTo('+1 second'))
            ->integer(TestedClass::getCurrentTimeOffset())
            ->isEqualTo(1)

            ->and(TestedClass::moveTo('-2 seconds'))
            ->integer(TestedClass::getCurrentTimeOffset())
            ->isEqualTo(-1)
            ;
    }

    public function testComeBack()
    {
        $this->if(TestedClass::moveTo('+1 second'))
            ->integer(TestedClass::getCurrentTimeOffset())
            ->isEqualTo(1)

            ->and(TestedClass::comeBack())
            ->variable(TestedClass::getCurrentTimeOffset())
            ->isNull()
            ;
    }


    public function testDateTimeConstructNotEnabled()
    {
        $this->if(TestedClass::moveTo('2013-05-25 00:00:00'))
            ->object(new \DateTime())
            ->isNotEqualTo(new \DateTime('2013-05-25 00:00:00'));
    }

    public function dateTimeConstructDataProvider()
    {
        return array(
            // currentDate, args of construct, result
            array('2013-05-25 00:00:00', null, '2013-05-25 00:00:00'),
            array('2013-05-25 00:00:00', '+2 hours', '2013-05-25 02:00:00'),
            array('2013-05-25 00:00:00', '-2 hours', '2013-05-24 22:00:00'),
            array('2013-05-25 00:00:00', '10:30:20', '2013-05-25 10:30:20'),
            array('2013-05-25 10:00:00', '2014-02-02', '2014-02-02 10:00:00'),
        );
    }

    /**
     * @dataProvider dateTimeConstructDataProvider
     */
    public function testDateTimeConstruct($currentDate, $date, $result)
    {
        $this->if(TestedClass::enable())
            ->and(TestedClass::moveTo($currentDate))
            ->object(new \DateTime($date))
            ->isEqualTo(new \DateTime($result));
    }

    /**
     * @dataProvider dateTimeConstructDataProvider
     */
    public function testDateCreate($currentDate, $date, $result)
    {
        $this->if(TestedClass::enable())
            ->and(TestedClass::moveTo($currentDate))
            ->object(date_create($date))
            ->isEqualTo(date_create($result));
    }

    public function timeDataProvider()
    {
        return array(
            // currentDate, result
            array('2013-05-25 00:00:00', 1369440000, 'UTC'),
            array('2013-05-26 00:00:00', 1369526400, 'UTC'),

            array('2013-05-25 00:00:00', 1369432800, 'europe/paris'),
            array('2013-05-26 00:00:00', 1369519200, 'europe/paris'),
        );
    }

    /**
     * @dataProvider timeDataProvider
     */
    public function testTime($currentDate, $result, $tz)
    {
        ini_set('date.timezone', $tz);

        $this->if(TestedClass::enable())
            ->and(TestedClass::moveTo($currentDate))
            ->integer(time())
            ->isIdenticalTo($result);
    }

    public function microtimeDataProvider()
    {
        return array(
            // currentDate, result, timezone
            array('2013-05-25 00:00:00', 1369440000, 'UTC'),
            array('2013-05-26 00:00:00', 1369526400, 'UTC'),

            array('2013-05-25 00:00:00', 1369432800, 'europe/paris'),
            array('2013-05-26 00:00:00', 1369519200, 'europe/paris'),
        );
    }

    /**
     * @dataProvider microtimeDataProvider
     */
    public function testMicrotime($currentDate, $result, $tz)
    {
        ini_set('date.timezone', $tz);

        $this->if(TestedClass::enable())
            ->and(TestedClass::moveTo($currentDate))

            ->integer(intval(microtime(true)))
            ->isEqualTo($result)

            ->string(microtime(false))
            ->endWith((string) $result);
    }

    public function strtotimeDataProvider()
    {
        return array(
            // currentDate, str, 2nd argument of strtotime, time
            array('2013-05-25 00:00:00', '+2 hours', null, 1369447200, 'UTC'),
            array('2013-05-26 00:00:00', '+1 hour', null, 1369530000, 'UTC'),
            array('2013-05-26 00:00:00', '10:00:00', null, 1369562400, 'UTC'),
            array('2013-05-26 00:00:00', '2014-01-01 10:00:00', null, 1388570400, 'UTC'),
            array('2013-05-26 00:00:00', '+1 second', 1369447200, 1369447201, 'UTC'),

            array('2013-05-25 00:00:00', '+2 hours', null, 1369440000, 'europe/paris'),
            array('2013-05-26 00:00:00', '+1 hour', null, 1369522800, 'europe/paris'),
            array('2013-05-26 00:00:00', '10:00:00', null, 1369555200, 'europe/paris'),
            array('2013-05-26 00:00:00', '2014-01-01 10:00:00', null, 1388566800, 'europe/paris'),
            array('2013-05-26 00:00:00', '+1 second', 1369447200, 1369447201, 'europe/paris'),
        );
    }

    /**
     * @dataProvider strtotimeDataProvider
     */
    public function testStrtotime($currentDate, $str, $strTime, $result, $tz)
    {
        ini_set('date.timezone', $tz);

        $this->if(TestedClass::enable())
            ->and(TestedClass::moveTo($currentDate))

            ->integer(strtotime($str, $strTime))
            ->isEqualTo($result);
    }

    public function dateDataProvider()
    {
        return array(
            // currentDate, format, method used, result expected
            array('2011-06-10 11:00:00', 'Y-m-d H:i:s', 'date', '2011-06-10 11:00:00'),
            array('2011-06-11 11:00:00', 'Y-m-d', 'date', '2011-06-11'),

            array('2011-06-11 11:00:00', 'Y-m-d H:i:s', 'gmdate', '2011-06-11 09:00:00'),
            array('2011-06-11 11:00:00', 'Y-m-d', 'gmdate', '2011-06-11'),
        );
    }

    /**
     * @dataProvider dateDataProvider
     */
    public function testDate($currentDate, $format, $function, $result)
    {
        ini_set('date.timezone', 'europe/paris');

        $this->if(TestedClass::enable())
            ->and(TestedClass::moveTo($currentDate))

            ->string($function($format))
            ->isEqualTo($result);
    }

    public function gettimeofdayDataProvider()
    {
        return array(
            array('2013-05-25 00:00:00', 1369440000, 'UTC'),
            array('2025-05-26 00:00:00', 1748217600, 'UTC'),

            array('2013-05-25 00:00:00', 1369432800, 'europe/paris'),
            array('2025-05-26 00:00:00', 1748210400, 'europe/paris'),
        );
    }

    /**
     * @dataProvider gettimeofdayDataProvider
     */
    public function testGettimeofday($currentDate, $roundSec, $timezone)
    {
        ini_set('date.timezone', $timezone);

        $this->if(TestedClass::enable())
            ->and(TestedClass::moveTo($currentDate))

            ->float(gettimeofday(true))
            ->isNearlyEqualTo((float) $roundSec, pow(10, -9))

            ->then($data = gettimeofday(false))
            ->array($data)
            ->integer($data['sec'])->isEqualTo($roundSec);
        ;
    }
}
