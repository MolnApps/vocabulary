<template>
    <div class="question" :class="getClass(index)" :data-index="index">
        <h2 class="question-word">{{word.translation}}</h2>
        <h3 class="question-pronounce"><em>{{word.pronounce}}</em></h3>
        <ul class="answer">
            <li v-for="option in options">
                <a
                    href="#"
                    class="answer-item"
                    :data-answer="option.word"
                    :class="getAnswerClass(index, option.word)"
                    v-on:click.prevent="giveAnswer(option.word)" 
                >{{option.word}}</a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['word', 'options', 'index'],
        
        data: function() {
            return {
                givenAnswer: null,
            }
        },

        methods: {
            giveAnswer: function(answer) {
                if (this.givenAnswer) {
                    return;
                }

                this.givenAnswer = answer;

                this.$emit('giveAnswer', {
                    index: this.index, 
                    status: this.getResult(this.givenAnswer)
                });
            },
            
            getAnswerClass: function(index, answer) {
                if ( ! this.givenAnswer) {
                    return;
                }

                if (this.getResult(answer) == 'correct') {
                    return 'answer-is-correct';
                }

                if (answer == this.givenAnswer) {
                    return 'answer-is-wrong';
                }
            },
            
            getClass: function(index) {
                if ( ! this.givenAnswer) {
                    return;
                }

                return  'question-is-' + this.getResult(this.givenAnswer);
            },

            getResult(answer) {
                return (this.word.word == answer) ? 'correct' : 'wrong';
            }
        }
    }
</script>