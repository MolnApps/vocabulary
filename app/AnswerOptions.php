<?php

namespace App;

class AnswerOptions
{
	private $words = [];
	private $solution;
	private $count;

	private $options = [];

	public function __construct(array $words, Word $solution, $count)
	{
		$this->words = $words;
		$this->solution = $solution;
		$this->count = $count;
	}

	public function getOptions()
	{
		$this->randomizeWords();
		$this->collectOptionsExceptSolution();
		$this->addSolutionToOptions();
		$this->randomizeOptions();

		return $this->options;
	}

	private function randomizeWords()
	{
		shuffle($this->words);
	}

	private function collectOptionsExceptSolution()
	{
		$i = 0;
		$this->options = [];
		
		while (count($this->options) < $this->count - 1) {
			if ($this->words[$i] != $this->solution) {
				$this->options[] = $this->words[$i];
			}
			$i++;
		}
	}

	private function addSolutionToOptions()
	{
		$this->options[] = $this->solution;
	}

	private function randomizeOptions()
	{
		shuffle($this->options);
	}
}