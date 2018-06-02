<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Learn words</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700&amp;subset=cyrillic" rel="stylesheet">
	<style>
	body {
		display: flex;
		justify-content: center;
		align-items: center;
		padding: 48px;
		font-family: 'Roboto', sans-serif;
	}
	h1, h2, h3, h4, h5, h6, p {
		margin: 0;
		padding: 0;
		font-size: 18px;
	}
	a {
		color: #000;
		text-decoration: none;
	}
	ul, li {
		list-style: none;
		margin: 0;
		padding: 0;
	}

	.container {
		max-width: 800px;
		width: 800px;
	}

	.question {
		background: #efefef;
		margin-bottom: 24px;
		border-radius: 5px;
		font-size: 18px;
		border: 2px solid #efefef;
	}
	.question-word {
		padding: 12px;
		padding-bottom: 0px;
		font-weight: 700;
		font-size: 36px;
	}
	.question-pronounce {
		padding-top: 0px;
		padding: 12px;
		color: #999;
		font-size: 36px;
	}
	.question-pronounce em {
		font-style: normal;
		font-weight: 100;
	}

	.answer {
		border-top: 1px solid #ccc;
		font-weight: 400;
	}
	.answer-item {
		display: block;
		padding: 12px;
		border-bottom: 1px solid #ccc;
		border-radius: 4px;
	}
	.answer-item:hover {
		background: #fff;
	}
	.answer li:last-child .answer-item {
		border-bottom: 0px;
	}

	.question-is-correct {
		color: green;
		border: 2px solid green;
	}
	.question-is-wrong {
		color: red;
		border: 2px solid red;
	}

	.answer-is-correct {
		color: #fff;
		background: green;
	}
	.answer-is-wrong {
		color: #fff;
		background: red;
	}

	.vocabulary-counter {
	    position: fixed;
	    left: auto;
	    right: auto;
	    bottom: 0;
	    width: 800px;
	    max-width: 800px;
	    background-color: green;
	    color: #fff;
	    text-align: center;
	    padding: 12px 0px;
	    border-radius: 4px;
	}

	.vocabulary-new-game {
		background: orange;
		color: #fff;
		border-radius: 4px;
		display: block;
		padding: 12px;
		text-align: center;
		margin-bottom: 48px;
		font-size: 36px;
	}
	</style>
</head>
<body>
	<div id="app" class="container">
		<!-- TODO: 
			— Add CSS Styling
		-->
		<vocabulary-game 
			:words="{{ $words }}" 
			:options="{{ $options }}" 
		></vocabulary-game>
	</div>
	<script src="js/app.js"></script>
</body>
</html>