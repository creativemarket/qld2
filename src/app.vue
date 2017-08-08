<script>
import gql from 'graphql-tag';
import { EventBus } from './main.js';
import Score from './components/score.vue';
import Card from './components/card/card.vue';
import Message from './components/message.vue';
import Leaderboard from './components/leaderboard.vue';

export default {
    data() {
        return {
            quiz: null,
            score: 0,
            total: 0,
            message: {},
            current: 1,
            completed: false,
            boardVisible: false,
        };
    },
    apollo: {
        // GraphQL query
        quiz: {
            query: gql`query quiz {
                quiz {
                    quote {
                        text
                    }
                    characters {
                        answer
                        isCorrect
                    }
                    movies {
                        answer
                        isCorrect
                    }
                }
            }`,
        },
    },
    components: {
        'card': Card,
        'score': Score,
        'message': Message,
        'leaderboard': Leaderboard,
    },
    created() {
        EventBus.$on('progress:quiz', () => { this.next() });
        EventBus.$on('update:score', amt => { this.updateScore(amt) });
        EventBus.$on('show:message', payload => { this.showMessage(payload) });
        EventBus.$on('show:leaderboard', (bool) => { this.toggleLeaderBoard(bool) });
    },
    methods: {
        next() {
            if (this.current+1 <= this.quiz.length) {
                this.current++;
                EventBus.$emit('show:movie', false);

                // Quiz complete
                if (this.current == this.quiz.length) {
                    this.completed = true;
                    this.toggleLeaderBoard(true);
                }
            }

        },
        updateScore(amt) {
            this.score = this.score + amt;
        },
        showMessage(payload) {
            this.message = payload;
        },
        toggleLeaderBoard(bool) {
            this.boardVisible = bool;
        },
    },
}
</script>

<template>
    <div class="">
        <div class="stars"></div>
        <div class="starsLg"></div>
        <div class="header">
            <h1>Welcome to Star War</h1>
            <p class="link" v-on:click="toggleLeaderBoard(true)">View Leaderboard</p>
            <score :score="this.score" :total="this.total"></score>
        </div>
        <message :message="this.message"></message>
        <div v-if="!this.boardVisible">
            <card v-for="(q, i) in quiz" :quiz="q" v-show="i === current" v-bind:key="i"></card>
        </div>
        <leaderboard v-if="this.boardVisible" :userScore="this.score" :isComplete="this.completed"></leaderboard>
    </div>
</template>

<style lang="scss" scoped>
   @import "~styles/main.scss";
</style>
