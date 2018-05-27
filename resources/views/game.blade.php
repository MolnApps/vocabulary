<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Learn words</title>
	<script src="https://cdn.jsdelivr.net/npm/vue"></script>
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
		<div v-for="(word, index) in words" :class="isAnswered(index)" :data-index="index">
			<h2>@{{word.translation}}</h2>
			<h3><em>@{{word.pronounce}}</em></h3>
			<ul>
				<li v-for="option in options[index]">
					<a 
						href="#" 
						v-on:click.prevent="checkAnswer" 
						:data-word="word.word" 
						:data-answer="option.word" 
						:data-index="index"
					>@{{option.word}}</a>
				</li>
			</ul>
		</div>
		<h3>@{{ getCorrectAnswersCount }} / 3</h3>
		<a href="/game" v-show="gameIsCompleted">Start new game</a>
	</div>
	<script>
		new Vue({
			el: '#root',
			data: {
				words: JSON.parse('<?= json_encode($words); ?>'),
				options: JSON.parse('<?= json_encode($options); ?>'),
				givenAnswers: JSON.parse('<?= json_encode($givenAnswers); ?>')
			},
			computed: {
				getCorrectAnswersCount: function() {
					return this.getGivenAnswers('correct').length;
				},
				gameIsCompleted: function() {
					return this.getGivenAnswers('').length == this.givenAnswers.length;
				}
			},
			methods: {
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
				},
				getGivenAnswers: function(status) {
					return this.givenAnswers.filter(el => el.status == status);
				}
			}
		})
	</script>
</body>
</html>