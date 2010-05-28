<?php

require_once __DIR__.'/../miam/MiamKernel.php';

$kernel = new MiamKernel('prod', true);
$kernel->handle()->send();