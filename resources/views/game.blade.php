<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Learn words</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- development version, includes helpful console warnings -->
	<!--<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>-->
	<style>
	.is-correct {
		color: green;
	}
	.is-wrong {
		color: red;
	}
	</style>
</head>
<body>
	<div id="app">
		<vocabulary-game 
			:words="{{ $words }}" 
			:options="{{ $options }}" 
		></vocabulary-game>
	</div>
	<script src="js/app.js"></script>
</body>
</html>