<?php

namespace tests\units\Rezzza;

use mageekguy\atoum;
use Rezzza\Tests\Units\Stubs\Test;

class TimeTravelerAspect extends atoum\test
{
    public function test_override_custom_object_method()
    {
        $stub = new Test();

        $this->string($stub->format())->isEqualTo('overridden_format');
    }

    public function test_time_native_function()
    {
        $stub = new Test();

        $this->integer($stub->returnTimeFunctionResult())->isEqualTo(12345);
    }

    /**
     * Fails unfortunately
     */
    public function test_datetime_native_format_method()
    {
        $stub = new Test();

        $this->string($stub->returnNativeDateTimeFormatMethodResult())->isEqualTo('overridden_format');
    }
}
