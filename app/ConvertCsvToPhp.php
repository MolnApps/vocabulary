<?php

namespace App;

class ConvertCsvToPhp
{
	private $pathToFile;

	public function __construct($pathToFile)
	{
		$this->pathToFile = $pathToFile;
	}

	public function extract()
	{
		$str = [];

		$str[] = '<?php';
		$str[] = 'return [';

		$handle = fopen($this->pathToFile, "r");
		
		if ($handle === FALSE) {
		    return;
		}

		$translationIndex = !strstr($this->pathToFile, 'adjectives') ? 2 : 3;
		
		while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE) {
			if ( ! isset($data[1]) || ! isset($data[$translationIndex])) {
				continue;
			}
	    	$translit = $this->getTranslit($data[1]);
	    	$word = $data[$translationIndex];
	        $str[] = "\t['word' => \"{$data[1]}\", 'translit' => \"{$translit}\", 'translation' => \"{$word}\"],";
	    }

	    fclose($handle);

		$str[] = '];';

		$this->writePhpFile(implode($str, "\r\n"));
	}

	private function getTranslit($str){
	    $tr = array(
	        "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
	        "Д"=>"d","Е"=>"e","Ё"=>"yo","Ж"=>"zh","З"=>"z","И"=>"i",
	        "Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
	        "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
	        "У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"c","Ч"=>"ch",
	        "Ш"=>"sh","Щ"=>"shch","Ъ"=>"","Ы"=>"y","Ь"=>"",
	        "Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
	        "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ё"=>"yo","ж"=>"zh",
	        "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
	        "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
	        "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
	        "ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"shch","ъ"=>"",
	        "ы"=>"y","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya", 
	        " "=> "-", "."=> "", ","=> "", "/"=> "", "\""=> "",
			"'"=> "", "/"=> "", ":"=> "", "("=> "", ")"=> "", "!"=> "",
			"&amp;"=> "", "&quot;"=> "", "&laquo;"=> "", "&raquo;"=> "",
			"%"=> "", "-"=> "-", "&"=> "", "$"=> "", "«"=> "", "»"=> "", "+"=> ""
	    );
	    return trim(strtr($str,$tr), "-");
	}

	private function writePhpFile($content)
	{
		$path = str_replace('.csv', '.php', $this->pathToFile);
		file_put_contents($path, $content);
	}
}