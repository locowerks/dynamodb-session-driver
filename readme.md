## AWS DynamoDB session driver for Laravel 5

A simple DynamoDB Session driver for Laravel 5, no more, no less.

## Installation

To install latest version simply add it to your `composer.json`:

```javascript
"locowerks/dynamodb-session-driver": "~0.1"
```

## Configuration

Publish config:

```javascript
$ php artisan vendor:publish --provider='Locowerks\DynamoDbSessionDriver'
```

Update config:

Config file is published to config/dynamodb-session.php

Add your AWS DynamoDB credentials to your .env file:

AWS_DYNAMODB_KEY
AWS_DYNAMODB_SECRET
AWS_DYNAMODB_REGION


### License

The DynamoDB Sessions Driver is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
