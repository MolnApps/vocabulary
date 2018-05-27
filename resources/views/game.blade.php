<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<!-- development version, includes helpful console warnings -->
	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
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
	<div id="root">
		<ul>
			<li v-for="(word, index) in words" :class="isAnswered(index)" :data-index="index">
				@{{word.word}}<br/>
				<em>@{{word.pronounce}}</em><br/>
				<ol>
					<li v-for="option in options[index]">
						<a 
							href="#" 
							v-on:click.prevent="checkAnswer" 
							:data-word="word.word" 
							:data-answer="option.word" 
							:data-index="index"
						>@{{option.translation}}</a>
					</li>
				</ol>
			</li>
		</ul>
		<h3>@{{ getCorrectAnswersCount }} / 3</h3>
		<button v-show="gameIsCompleted" v-on:click="startNewGame">Start new game</button>
	</div>
	<?php
	use \App\Word;
	use \App\Vocabulary;
	
	$vocabulary = new Vocabulary([
		new Word('hello', 'ciao', 'hello'),
		new Word('man', 'uomo', 'man'),
		new Word('woman', 'donna', 'woman'),
		new Word('child', 'bambino', 'child')
	]);
	
	$words = $vocabulary->getRandomWords(3);
	$options = [];
	foreach ($words as $word) {
		$options[] = $vocabulary->getOptions(3, $word);
	}
	?>
	<script>
		var words = JSON.parse('<?= json_encode($words); ?>');
		var options = JSON.parse('<?= json_encode($options); ?>');
		
		new Vue({
			el: '#root',
			data: {
				words: words,
				options: options,
				givenAnswers: []
			},
			created: function() {
				this.startNewGame();
			},
			computed: {
				getCorrectAnswersCount: function() {
					var correctAnswers = 0;
					this.givenAnswers.forEach(function(el){
						if (el.status == 'correct') {
							correctAnswers++;
						}
					});
					return correctAnswers;
				},
				gameIsCompleted: function() {
					var givenAnswers = 0;
					this.givenAnswers.forEach(function(el){
						if (el.status) {
							givenAnswers++;
						}
					});

					return givenAnswers == this.givenAnswers.length;
				}
			},
			methods: {
				startNewGame: function() {
					this.givenAnswers = [
						{status: ''}, 
						{status: ''}, 
						{status: ''}
					];
				},
				checkAnswer: function(e) {
					var index = e.target.getAttribute('data-index');
					var word = e.target.getAttribute('data-word');
					var answer = e.target.getAttribute('data-answer');

					if (this.givenAnswers[index].status) {
						return;
					}

					this.givenAnswers[index].status = (word == answer) ? 'correct' : 'wrong';
				},
				isAnswered: function(index) {
					return this.givenAnswers[index].status ? 'is-' + this.givenAnswers[index].status : '';
				}
			}
		})
	</script>
</body>
</html>