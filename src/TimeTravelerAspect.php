<?php

namespace Rezzza;

use Go\Aop\Aspect;
use Go\Aop\Intercept\FunctionInvocation;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\After;
use Go\Lang\Annotation\Before;
use Go\Lang\Annotation\Around;
use Go\Lang\Annotation\Pointcut;
use Go\Aop\Intercept\FieldAccess;

/**
 * @author Guillaume MOREL <guillaume.morel@verylastroom.com>
 */
class TimeTravelerAspect implements Aspect
{
   /**
     * @param FunctionInvocation $invocation
     *
     * @Around("execution(**\time(*))")
     *
     * @return int
     */
    public function aroundTimeFunction(FunctionInvocation $invocation)
    {
        echo 'Calling Around Interceptor for function: ',
            $invocation->getFunction()->getName(),
            '()',
            ' with arguments: ',
            json_encode($invocation->getArguments()),
            PHP_EOL;

        return 12345;
    }

    /**
     * @param MethodInvocation $invocation
     *
     * @Around("execution(public Rezzza\Tests\Units\Stubs\Test->format(*))")
     *
     * @return string
     */
    public function aroundTestDateTimeFormatMethod(MethodInvocation $invocation)
    {
        $obj = $invocation->getThis();
        echo 'Calling Around Interceptor for method: ',
             is_object($obj) ? get_class($obj) : $obj,
             $invocation->getMethod()->isStatic() ? '::' : '->',
             $invocation->getMethod()->getName(),
             '()',
             ' with arguments: ',
             json_encode($invocation->getArguments()),
             "<br>\n";

        return 'overridden_format';
    }

    /**
     * @param MethodInvocation $invocation
     *
     * @Around("execution(public DateTime->format(*))")
     *
     * @return string
     */
    public function aroundNativeDateTimeFormatMethod(MethodInvocation $invocation)
    {
        $obj = $invocation->getThis();
        echo 'Calling Around Interceptor for method: ',
             is_object($obj) ? get_class($obj) : $obj,
             $invocation->getMethod()->isStatic() ? '::' : '->',
             $invocation->getMethod()->getName(),
             '()',
             ' with arguments: ',
             json_encode($invocation->getArguments()),
             "<br>\n";

        return 'overridden_format';
    }
}
