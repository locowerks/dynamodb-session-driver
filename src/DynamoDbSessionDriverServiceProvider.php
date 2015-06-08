<?php namespace Locowerks\DynamoDbSessionDriver;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Aws\DynamoDb\DynamoDbClient;

class DynamoDbSessionDriverServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        // Publishes package config file to applications config folder
        $this->publishes([__DIR__ . '/config/dynamodb-session.php' => config_path('vendor/locowerks/dynamodb-session.php')]);

        Session::extend('dynamodb', function($app) {
            $config = config('vendor.locowerks.dynamodb-session');

            $db = new DynamoDbClient([
                'version'   => $config['version'],
                'region'    => $config['region'],
                'credentials' => [
                    'key'       => $config['key'],
                    'secret'    => $config['secret'],
                ]
            ]);

            $handler = $db->registerSessionHandler([
                'table_name'                => $config['table'],
                'hash_key'                  => $config['hash_key'],
                'session_lifetime'          => $config['lifetime'],
                'consistent_read'           => $config['consistent_read'],
                'locking_strategy'          => $config['locking_strategy'],
                'automatic_gc'              => $config['automatic_gc'],
                'gc_batch_size'             => $config['gc_batch_size'],
                'max_lock_wait_time'        => $config['max_lock_wait_time'],
                'min_lock_retry_microtime'  => $config['min_lock_retry_microtime'],
                'max_lock_retry_microtime'  => $config['max_lock_retry_microtime'],
            ]);

            return $handler;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('command.dynamodb-session.gc', function ($app) {
            return $app['Locowerks\DynamoDbSessionDriver\Commands\GarbageCollectCommand'];
        });
        $this->commands('command.dynamodb-session.gc');
    }

}