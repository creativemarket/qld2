<script>
import gql from 'graphql-tag';
import Score from './components/score.vue';
import Card from './components/card/card.vue';

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
    },
    computed: {
    },
    methods: {
        next() {
            if (this.current+1 < this.quiz.length) {
                this.current++;
            }
        },
    },
}
</script>

<template>
    <div class="">
        <h1>Welcome to Star War</h1>
        <score :score="this.score" :total="this.total"></score>
        <card v-for="(q, i) in quiz" :quiz="q" v-show="i === current" v-bind:key="i"></card>
    </div>
</template>

<style lang="scss" scoped>
   @import "~styles/main.scss";
</style>
