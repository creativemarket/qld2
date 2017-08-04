<script>
import gql from 'graphql-tag';
import { EventBus } from './main.js';
import Score from './components/score.vue';
import Card from './components/card/card.vue';
import Message from './components/message.vue';
import Leaderboard from './components/leaderboard.vue';

export default {
    data() {
        console.log(this.$apollo);
        return {
            quiz: null,
            score: 0,
            total: 0,
            message: {},
            completed: false,
            current: 1,
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
        }
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
    },
    methods: {
        next() {
            if (this.current+1 < this.quiz.length) {
                this.current++;
                EventBus.$emit('show:movie', false);
            }
        },
        updateScore(amt) {
            this.score = this.score + amt;
        },
        showMessage(payload) {
            this.message = payload;
        },
    },
}
</script>

<template>
    <div class="">
        <h1>Welcome to Star War</h1>
        <score :score="this.score" :total="this.total"></score>
        <message :message="this.message"></message>
        <card v-for="(q, i) in quiz" :quiz="q" v-show="i === current" v-bind:key="i"></card>
    </div>
</template>

<style lang="scss" scoped>
   @import "~styles/main.scss";
</style>
