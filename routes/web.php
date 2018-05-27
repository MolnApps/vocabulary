<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Vocabulary;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/word', function() {
	$vocabulary = app()->make(Vocabulary::class);

	$nextWord = $vocabulary->getNextWord();

	return view('word', [
		'nextWord' => $nextWord, 
		'options' => $vocabulary->getOptions(3, $nextWord)
	]);
});

Route::post('/answer', function() {
	$vocabulary = app()->make(Vocabulary::class);

	$previousWord = $vocabulary->getPreviousWord();
	$nextWord = $vocabulary->getNextWord();
	$result = $previousWord->verify(request()->get('answer'));

	$session = request()->session();
	$session->put('totalAnswers', $session->get('totalAnswers') + 1);
	if ($result) {
		$session->put('correctAnswers', $session->get('correctAnswers') + 1);
	}
	
	return view('result', [
		'result' => $result, 
		'correctAnswer' => $previousWord->getWord(),

		'nextWord' => $nextWord,
		'options' => $vocabulary->getOptions(3, $nextWord)
	]);
});

Route::get('/game', function(){
	$vocabulary = app()->make(Vocabulary::class);
	
	$words = $vocabulary->getRandomWords(3);
	
	$options = [];
	foreach ($words as $word) {
		$options[] = $vocabulary->getOptions(4, $word);
	}

	$givenAnswers = [];
	foreach ($words as $word) {
		$givenAnswers[] = ['status' => ''];
	}

	return view('game', [
		'words' => $words,
		'options' => $options,
		'givenAnswers' => $givenAnswers
	]);
});