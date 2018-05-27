<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use \PHPUnit\Framework\Assert as PHPUnit;

use App;
use App\Vocabulary;
use App\Word;

class WordTest extends DuskTestCase
{
    private $vocabulary;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        parent::prepare();

        Browser::macro('assertElementsCountIs', function ($count, $selector) {
            PHPUnit::assertEquals($count, count($this->elements($selector)));

            return $this;
        });
    }

    protected function setUp()
    {
        parent::setUp();

        $this->vocabulary = new Vocabulary([
            new Word('Hello', 'Ciao', 'cia-o'), 
            new Word('Cat', 'Gatto', 'gat-to'), 
            new Word('Man', 'Uomo', 'uo-mo'),
            new Word('Woman', 'Donna', 'don-na'),
            new Word('Child', 'Bambino', 'bam-bi-no'),
            new Word('Dog', 'Cane', 'ca-ne'),
        ]);

        App::instance(Vocabulary::class, $this->vocabulary);
    }

    /** @test */
    public function it_presents_a_word()
    {
        $this->withSession(['wordIndex' => '0']);

        $this->get('/word')
            ->assertSeeText('Ciao')
            ->assertSeeText('cia-o')
            ->assertStatus(200);
    }

    /** @test */
    public function it_presents_a_different_word_the_next_time()
    {
        $this->withSession(['wordIndex' => '1']);

        $this->get('/word')
            ->assertSeeText('Gatto')
            ->assertSeeText('gat-to')
            ->assertStatus(200);
    }

    /** @test */
    public function it_will_present_all_words_in_a_loop()
    {
        $this->withSession(['wordIndex' => count($this->vocabulary) - 1]);

        $this->get('/word')
            ->assertSeeText('Cane')
            ->assertSeeText('ca-ne')
            ->assertStatus(200);

        $this->get('/word')
            ->assertSeeText('Ciao')
            ->assertSeeText('cia-o')
            ->assertStatus(200);
    }

    /** @test */
    public function it_will_present_options()
    {
        $this->browse(function ($browser) {
            $browser->visit('/word')
                ->assertSee('Hello')
                ->assertElementsCountIs(3, "input[type='radio'][name='answer']");
        });
    }

    /** @test */
    public function it_will_assert_that_an_answer_is_correct()
    {
        $this->withSession(['wordIndex' => 1]);

        $this->call('POST', '/answer', [
            '_token' => csrf_token(), 
            'answer' => 'Hello'
        ])
            ->assertSeeText('Correct')
            ->assertSeeText('Cat')
            ->assertStatus(200);
    }

    /** @test */
    public function it_will_assert_that_an_answer_is_wrong()
    {
        $this->withSession(['wordIndex' => 1]);

        $this->call('POST', '/answer', [
            '_token' => csrf_token(), 
            'answer' => 'Dog'
        ])
            ->assertSeeText('Wrong')
            ->assertSeeText('The correct answer was Hello')
            ->assertSeeText('Cat')
            ->assertStatus(200);
    }

    /** @test */
    public function it_will_assert_that_an_answer_is_correct_in_loop()
    {
        $this->withSession(['wordIndex' => 0]);

        $this->call('POST', '/answer', [
            '_token' => csrf_token(), 
            'answer' => 'Dog'
        ])
            ->assertSeeText('Correct')
            ->assertSeeText('Hello')
            ->assertStatus(200);
    }

    /** @test */
    public function it_will_keep_track_of_score()
    {
        $this->browse(function ($browser) {
            $browser
                ->visit('/word')
                ->assertSee('Кот')
                ->assertSee('Kot')
                ->radio('answer', 'Cat')
                ->press('Submit')
                ->assertPathIs('/answer')
                ->assertSee('Correct')
                ->assertSee('1 / 1')
                //
                ->assertSee('Собака')
                ->assertSee('Sobaka')
                ->radio('answer', 'Dog')
                ->press('Submit')
                ->assertPathIs('/answer')
                ->assertSee('Correct')
                ->assertSee('2 / 2')
                //
                ->assertSee('Мужчина')
                ->assertSee('Muzhchina')
                ->press('Submit')
                ->assertPathIs('/answer')
                ->assertSee('Wrong')
                ->assertSee('2 / 3');
        });
    }

    // Todo: we should set the scope of the play. E.g. 20 words, 50 words, etc.
    // Todo: on refresh, we go to the next word, regardless of whether the user gave answer.
}
