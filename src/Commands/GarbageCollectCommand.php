<?php namespace LocowerksPackages\DynamoDbSessionDriver\Commands;

use Illuminate\Console\Command;
use Aws\DynamoDb\DynamoDbClient;

class GarbageCollectCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'dynamodb-session:gc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the DynamoDB native garbage collection on the sessions table.';

    /**
     * Create a new command instance.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire() {
        $config = config('vendor.locowerks.dynamodb-session');

        if($config['automatic_gc'] == true) {
            $this->comment('Automatic garbage collection is turned on.');
            $this->comment('Set "automatic_gc" to false in the config file to use the garbage collector.');
            die();
        }

        $this->comment('Running garbage collection ...');

        $db = new DynamoDbClient([
            'version'   => $config['version'],
            'region'    => $config['region'],
            'credentials' => [
                'key'       => $config['key'],
                'secret'    => $config['secret'],
            ]
        ]);

        $handler = $db->registerSessionHandler([
            'table_name'            => $config['table'],
            'gc_operation_delay'    => $config['gc_operation_delay'],
        ]);

        $handler->garbageCollect();
        $this->info(' - All done');
    }

}
