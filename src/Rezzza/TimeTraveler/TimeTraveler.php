<?php

namespace Rezzza\TimeTraveler;

/**
 * TimeTraveler
 *
 * Needs AOP extension to works.
 *
 * @author Stephane PY <py.stephane1@gmail.com>
 */
class TimeTraveler
{
    /**
     * @param integer|null
     */
    private static $currentTimeOffset;

    /**
     * @param integer
     */
    private static $currentTime;

    /**
     * @param boolean
     */
    private static $enabled = false;

    /**
     */
    public static function enable()
    {
        if (static::$enabled === true) {
            return;
        }

        if (!function_exists('\aop_add_after')) {
            throw new \LogicException('Aop extension seems to not be installed.');
        }

        aop_add_after('time()', function(\AopJoinPoint $joinPoint) {
            $joinPoint->setReturnedValue($joinPoint->getReturnedValue() + TimeTraveler::getCurrentTimeOffset());
        });

        aop_add_after('DateTime->__construct()', function(\AopJoinPoint $joinPoint) {
            if (TimeTraveler::getCurrentTime()) {

                $args = $joinPoint->getArguments();
                $date = isset($args[0]) ? $args[0] : null;

                $joinPoint->getObject()->setTimestamp(TimeTraveler::getCurrentTime());

                if ($date) {
                    $joinPoint->getObject()->modify($date);
                }
            }
        });

        static::$enabled = true;
    }

    /**
     * Edit current date of your system.
     *
     * @param string $date date
     */
    public static function setCurrentDate($date)
    {
        if (!is_scalar($date)) {
            throw new \InvalidArgumentException('TimeTraveler::setCurrentDate expects a scalar.');
        }

        $now = static::$currentTimeOffset ? time() - static::$currentTimeOffset : time();

        static::$currentTime       = strtotime($date);

        if (static::$currentTime === false) {
            throw new \InvalidArgumentException(sprintf('Cannot parse "%s" as a date.', $date));
        }

        static::$currentTimeOffset = static::$currentTime - $now;
    }

    /**
     * @return integer|null
     */
    public static function getCurrentTimeOffset()
    {
        return static::$currentTimeOffset;
    }

    /**
     * @return integer
     */
    public static function getCurrentTime()
    {
        return static::$currentTime;
    }
}
