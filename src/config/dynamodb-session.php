<?php

return [
    'key'                       => env('AWS_DYNAMODB_KEY'),
    'secret'                    => env('AWS_DYNAMODB_SECRET'),
    'region'                    => env('AWS_DYNAMODB_REGION'),

    'version'                   => 'latest',
    'table'                     => 'sessions',
    'hash_key'                  => 'id',
    'lifetime'                  => 3600,

    'consistent_read'           => true,
    'locking_strategy'          => null,
    'automatic_gc'              => true,
    'gc_batch_size'             => 50,
    'gc_operation_delay'        => 0,
    'max_lock_wait_time'        => 15,
    'min_lock_retry_microtime'  => 5000,
    'max_lock_retry_microtime'  => 50000,
];
