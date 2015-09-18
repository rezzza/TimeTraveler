<?php

namespace Rezzza\Tests\Units\Stubs;

/**
 * @author Guillaume MOREL <guillaume.morel@verylastroom.com>
 */
class Test
{
    /**
     * Call for native function `time()`
     *
     * @return int
     */
    public function returnTimeFunctionResult()
    {
        return time();
    }

    /**
     * Call for native `DateTime->format()` method
     *
     * @return string
     */
    public function returnNativeDateTimeFormatMethodResult()
    {
        $dateTime = new \DateTime();

        return $dateTime->format('Y-m-d H:i:s');
    }

    /**
     * Call for custom Object method
     *
     * @return string
     */
    public function format()
    {
        return 'expected_format';
    }
}
