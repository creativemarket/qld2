<script>
import answer from '../mixins/answer';

export default {
    props: {
        card: {
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
}
</script>

<template>
    <div class="card">
        <h1>{{ card.quote }}</h1>
        <div v-if="!bonus">
            <a class="answer" v-for="(character, i) in card.characters" v-bind:key="i" v-on:click="answerClick(character.isCorrect)"></a>
        </div>
        <div v-if="bonus">
            <a class="answer" v-for="(movie, i) in card.movie" v-bind:key="i" v-on:click="answerClick(movie.isCorrect)"></a>
        </div>
    </div>
</template>

<style lang="scss" scoped>
   @import "~styles/card.scss";
</style>