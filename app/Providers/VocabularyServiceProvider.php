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
            return new Vocabulary([
                new Word('Hello', 'Привет', 'Privet'), 
                new Word('Cat', 'Кот', 'Kot'), 
                new Word('Dog', 'Собака', 'Sobaka'),
                new Word('Man', 'Мужчина', 'Muzhchina'),
                new Word('Woman', 'Женщина', 'Zhenshchina'),
                new Word('Kid', 'Дитя', 'Ditya'),
            ]);
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
