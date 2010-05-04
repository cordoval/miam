<?php

require_once __DIR__.'/../ai/AiKernel.php';

$kernel = new AiKernel('dev', true);
$kernel->handle()->send();
