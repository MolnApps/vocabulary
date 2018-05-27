<?php

namespace App;

class Vocabulary implements \Countable
{
	private $words = [];

	public function __construct(array $words)
	{
		$this->words = $words;
	}

	public function getPreviousWord()
	{
		return $this->getWordAtIndex($this->getPreviousWordIndex());
	}

	public function getNextWord()
	{
		$currentWordIndex = $this->getCurrentWordIndex();

		$this->setNextWordIndex();
		
		return $this->getWordAtIndex($currentWordIndex);
	}

	private function getPreviousWordIndex()
	{
		$previousWordIndex = $this->getCurrentWordIndex() - 1;
		if ($previousWordIndex < 0) {
			$previousWordIndex = count($this) - 1;
		}
		return $previousWordIndex;
	}

	private function getCurrentWordIndex()
	{
		$currentWordIndex = request()->session()->get('wordIndex');
		
		if ( ! $currentWordIndex || $currentWordIndex >= count($this)) {
			$currentWordIndex = 0;
		}
		
		return $currentWordIndex;
	}

	private function setNextWordIndex()
	{
		request()->session()->put('wordIndex', $this->getCurrentWordIndex() + 1);
	}

	private function getWordAtIndex($index)
	{
		return $this->words[$index];
	}

	public function count()
	{
		return count($this->words);
	}

	public function getOptions($count, Word $solution)
	{
		return (new AnswerOptions($this->words, $solution, $count))->getOptions();
	}

	public function getRandomWords($count)
	{
		$tmp = $this->words;
		shuffle($tmp);
		return array_slice($tmp, 0, $count);
	}
}