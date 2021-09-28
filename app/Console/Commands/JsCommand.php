<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class JsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'js';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate prerequisites JS for VueJS';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('ziggy:generate', ['path' => './resources/js/ziggy-admin.js', '--group' => 'admin']);
        $this->call('ziggy:generate', ['path' => './resources/js/ziggy-frontend.js', '--group' => 'frontend']);
        $this->call(TranslationsGenerateCommand::class);
    }
}
