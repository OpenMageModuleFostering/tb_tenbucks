# TenbucksWebhooks
Manage Webhooks and synchronize data with tenbucks.

# Usage
```php
$client = new TenbucksWebhooks();
$query = array(
    'shop_url' => 'http://www.example.org',
    'model' => 'product',
    'external_id' => 1,
);
try {
    if ($client->send($query)) {
        // success
    } else {
        // error
    }
} catch (Exception $e) {
    // Network error / timeout
}
```

# test
```bash
$ phpunit --bootstrap src/TenbucksWebhooks.php tests/TenbucksWebhooksTest.php
```
