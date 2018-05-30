<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Vocabulary;
use App\Word;

class VocabularyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(Vocabulary::class, function ($app) {
            $nouns = include "/Users/giorgio.schwarz/Sites/vocabulary/resources/dictionary/nouns.php";

            $words = [];
            foreach ($nouns as $noun) {
                $words[] = new Word($noun['translation'], $noun['word'], $noun['translit']);
            }

            return new Vocabulary($words);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
