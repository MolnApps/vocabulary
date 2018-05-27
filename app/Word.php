<?php

namespace App;

class Word implements \JsonSerializable
{
	private $word;
	private $translation;
	private $pronounce;

	public function __construct($word, $translation, $pronounce)
	{
		$this->word = $word;
		$this->translation = $translation;
		$this->pronounce = $pronounce;
	}

	public function getWord()
	{
		return $this->word;
	}

	public function getTranslation()
	{
		return $this->translation;
	}

	public function getPronunce()
	{
		return $this->pronounce;
	}

	public function verify($answer)
	{
		return $this->getWord() == $answer;
	}

	public function jsonSerialize()
	{
		return [
			'word' => $this->word, 
			'pronounce' => $this->pronounce, 
			'translation' => $this->translation
		];
	}
}