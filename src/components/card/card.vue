<script>
import { EventBus } from '../../main.js';
import answer from '../../mixins/answer.js';

export default {
    props: {
        quiz: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            bonus: false,
            hasAnswered: false,
        };
    },
    mixins: [answer],
    mounted() {
        EventBus.$on('show:movie', bool => { this.showMovie(bool) });
    },
    methods: {
        showMovie(bool) {
            this.bonus = bool;
        },
    },
}
</script>

<template>
    <div class="card">
        <h1>"{{ quiz.quote.text }}"</h1>
        <div class="answers characters" v-if="!bonus">
            <h2>Who said it?...</h2>
            <a class="answer" v-for="(character, i) in quiz.characters" v-bind:key="i" v-on:click="answerClick(character.isCorrect, 'character')">{{ character.answer }}</a>
        </div>
        <div class="answers movies" v-if="bonus">
            <h2>Which movie did this quote belong to?...</h2>
            <a class="answer" v-for="(movie, i) in quiz.movies" v-bind:key="i" v-on:click="answerClick(movie.isCorrect, 'movie')">{{ movie.answer }}</a>
        </div>
        <br>
    </div>
</template>

<style lang="scss" scoped>
   @import "~styles/card.scss";
</style>