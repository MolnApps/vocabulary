<template>
    <div>
        <vocabulary-game-question 
            v-for="(word, index) in words" 
            :key="index"
            :index="index"
            :word="word"  
            :options="options[index]"
            v-on:giveAnswer="markAnswer"
        ></vocabulary-game-question>
        <h3 class="vocabulary-counter">{{ getCorrectAnswersCount }} / {{ words.length }}</h3>
        <a href="/game" v-show="gameIsCompleted" class="vocabulary-new-game">Start new game</a>
    </div>
</template>

<script>
    export default {
        props: ['words', 'options'],
        created: function() {
            this.words.forEach(function(el){
                this.givenAnswers.push({status:''});
            }.bind(this));
        },
        data: function() {
            return {
                givenAnswers: []
            }
        },
        computed: {
            getCorrectAnswersCount: function() {
                return this.getGivenAnswers('correct').length;
            },
            gameIsCompleted: function() {
                return this.getGivenAnswers('').length == 0;
            }
        },
        methods: {
            markAnswer: function(answer) {
                this.givenAnswers[answer.index].status = answer.status;
            },
            getGivenAnswers: function(status) {
                return this.givenAnswers.filter(answer => answer.status == status);
            }
        }
    }
</script>