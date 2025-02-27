<?php

use Murdej\Sse\SseService;

require_once __DIR__ . '/../vendor/autoload.php';

$sse = new SSEService('the end');

for ($i = 0; $i < 4; $i++) {
    $sse->sendMessage(['index' => $i, 'dt' => time()]);
    sleep(1);
}
