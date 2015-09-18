<?php

namespace Rezzza;

use Go\Core\AspectKernel;
use Go\Core\AspectContainer;

/**
 * @author Guillaume MOREL <guillaume.morel@verylastroom.com>
 */
class TimeTravelerAspectKernel extends AspectKernel
{
    /**
     * Configure an AspectContainer with advisors, aspects and pointcuts
     *
     * @param AspectContainer $container
     *
     * @return void
     */
    protected function configureAop(AspectContainer $container)
    {
        $container->registerAspect(new TimeTravelerAspect());
    }
}
