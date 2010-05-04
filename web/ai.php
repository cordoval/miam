<?php

require_once __DIR__.'/../ai/AiKernel.php';

$kernel = new AiKernel('prod', false);
$kernel->handle()->send();