<?php

$script->bootstrapFile(__DIR__ . DIRECTORY_SEPARATOR . '.atoum.bootstrap.php');

$cliReport = $script->addDefaultReport();
$cliReport->addField(new atoum\report\fields\runner\result\logo());

$runner->addReport($cliReport);
