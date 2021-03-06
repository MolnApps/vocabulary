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
	
	$words = $vocabulary->getRandomWords(20);
	
	$options = [];
	foreach ($words as $word) {
		$options[] = $vocabulary->getOptions(4, $word);
	}

	return view('game', [
		'words' => json_encode($words),
		'options' => json_encode($options),
	]);
});

/*
Route::get('/dictionary', function(){
	$files = [
		"/Users/giorgio.schwarz/Sites/vocabulary/resources/dictionary/adjectives.csv",
		"/Users/giorgio.schwarz/Sites/vocabulary/resources/dictionary/nouns.csv",
		"/Users/giorgio.schwarz/Sites/vocabulary/resources/dictionary/verbs.csv",
	];

	foreach ($files as $file) {
		(new \App\ConvertCsvToPhp($file))->extract();
	}
});
*/