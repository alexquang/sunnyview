<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TranslationsGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate translations json string for VueJS';

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
        $generatedTranslations = $this->generate();

        file_put_contents(base_path('resources/js/i18n.js'), $generatedTranslations);
    }

    private function generate()
    {
        $translations = json_encode([
            'ja' => $this->phpTranslations('ja')->merge($this->jsonTranslations('ja'))->toArray(),
        ]);

        return <<<JAVASCRIPT
const Translations = {$translations};

export { Translations };

JAVASCRIPT;
    }

    private function phpTranslations($locale)
    {
        $path = resource_path("lang/$locale");

        return collect(\File::allFiles($path))->flatMap(function ($file) use ($locale) {
            $key = ($translation = $file->getBasename('.php'));

            return [$key => trans($translation, [], $locale)];
        });
    }

    private function jsonTranslations($locale)
    {
        $path = resource_path("lang/$locale.json");

        if (is_string($path) && is_readable($path)) {
            return json_decode(file_get_contents($path), true);
        }

        return [];
    }
}
