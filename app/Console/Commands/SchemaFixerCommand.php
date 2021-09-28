<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SchemaFixerCommand extends Command
{
    use SchemaRelationsFixerTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schema:fix {instruction}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix schemas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $instruction = $this->argument('instruction');

        switch ($instruction) {
            case 'add-relations':
                $this->addRelations();
                break;
            case 'drop-relations':
                $this->dropRelations();
                break;
            default:
                break;
        }
    }
}
