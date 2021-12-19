# SendPulse REST client library with throttling requests

A simple SendPulse REST client library with throttling requests (no more 10 per second according to API rules) and example for PHP.

API Documentation [https://sendpulse.com/api](https://sendpulse.com/api)

modified by [Leonid74](https://github.com/Leonid74/sendpulse-php) (forked from [sendpulse/sendpulse-rest-api-php](https://github.com/sendpulse/sendpulse-rest-api-php))

### Installing

Via Composer:

```bash
composer require Leonid74/sendpulse-php
```

### Usage

```php
<?php
require 'vendor/autoload.php';

// Without Composer (and instead of "require 'vendor/autoload.php'"):
// require("your-path/sendpulse-php/src/ApiInterface.php");
// require("your-path/sendpulse-php/src/ApiClient.php");
// require("your-path/sendpulse-php/src/Storage/TokenStorageInterface.php");
// require("your-path/sendpulse-php/src/Storage/FileStorage.php");
// require("your-path/sendpulse-php/src/Storage/SessionStorage.php");
// require("your-path/sendpulse-php/src/Storage/MemcachedStorage.php");
// require("your-path/sendpulse-php/src/Storage/MemcacheStorage.php");

use Leonid74\Sendpulse\ApiClient;
use Leonid74\Sendpulse\Storage\FileStorage;

// API credentials from https://login.sendpulse.com/settings/#api
define('API_USER_ID', '');
define('API_SECRET', '');
define('PATH_TO_ATTACH_FILE', __FILE__);

$SPApiClient = new ApiClient(API_USER_ID, API_SECRET, new FileStorage());

// DEBUG level can be one of: DEBUG_NONE (default) or DEBUG_URL, DEBUG_HEADERS, DEBUG_CONTENT
$SPApiClient->debugLevel = ApiClient::DEBUG_URL;

/*
 * Example: Get Mailing Lists
 */
var_dump($SPApiClient->listAddressBooks());

/*
 * Example: Add new email to mailing lists
 */
 $bookID = 123;
 $emails = array(
    array(
        'email' => 'subscriber@example.com',
        'variables' => array(
            'phone' => '+12345678900',
            'name' => 'User Name',
        )
    )
);
 $additionalParams = array(
   'confirmation' => 'force',
   'sender_email' => 'sender@example.com',
);
 // With confirmation
var_dump($SPApiClient->addEmails($bookID, $emails, $additionalParams));

// Without confirmation
var_dump($SPApiClient->addEmails($bookID, $emails));

/*
 * Example: Send mail using SMTP
 */
$email = array(
    'html' => '<p>Hello!</p>',
    'text' => 'Hello!',
    'subject' => 'Mail subject',
    'from' => array(
        'name' => 'John',
        'email' => 'sender@example.com',
    ),
    'to' => array(
        array(
            'name' => 'Subscriber Name',
            'email' => 'subscriber@example.com',
        ),
    ),
    'bcc' => array(
        array(
            'name' => 'Manager',
            'email' => 'manager@example.com',
        ),
    ),
    'attachments' => array(
        'file.txt' => file_get_contents(PATH_TO_ATTACH_FILE),
    ),
);
var_dump($SPApiClient->smtpSendMail($email));

/*
 * Example: create new push
 */
$task = array(
    'title' => 'Hello!',
    'body' => 'This is my first push message',
    'website_id' => 1,
    'ttl' => 20,
    'stretch_time' => 0,
);

// This is optional
$additionalParams = array(
    'link' => 'http://yoursite.com',
    'filter_browsers' => 'Chrome,Safari',
    'filter_lang' => 'en',
    'filter' => '{"variable_name":"some","operator":"or","conditions":[{"condition":"likewith","value":"a"},{"condition":"notequal","value":"b"}]}',
);
var_dump($SPApiClient->createPushTask($task, $additionalParams));
```
