# PHP Server-Sent Events Helper

This PHP library simplifies the use of Server-Sent Events (SSE) in your PHP applications.

## Installation

You can install this library via Composer:

```bash
composer require murdej/sse
```
## Usage

Here's a basic example of how to use the library:

```php
<?php

use Murdej\Sse\SseService;

require_once __DIR__ . '/../vendor/autoload.php';

$sse = new SSEService();

for ($i = 0; $i < 4; $i++) {
    $sse->sendMessage(['index' => $i, 'dt' => time()]);
    sleep(1);
}
```

## Client site JavaScript

Here's an example of how to use this library with JavaScript on the client side:

```javascript
const es = new EventSource('./sse-service.php');

es.onmessage = (messsage) => {
    log.innerText += messsage.data + "\n"
}
es.onerror = (ev) => {
    es.close();
}
```

## Contributing

Contributions are welcome! Please feel free to submit a pull request or open an issue.

## License

This library is licensed under the MIT License.