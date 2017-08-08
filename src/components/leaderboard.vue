<script>
import gql from 'graphql-tag';

export default {
    props: {
        userScore: {
            type: Number,
            default: 0,
        },
        isComplete: {
            type: Boolean,
            required: true,
        },
    },
   data() {
       return {
            user: '',
            topScores: [],
       };
    },
    apollo: {
        // GraphQL query
        topScores: {
            query: gql`query topScores {
                topScores {
                     score
                     userName
                }
            }`,
        }
    },
    methods: {
        saveScore() {
            const name = this.user;
            const score = this.userScore;

            if (!name && !isComplete) {
                alert('Please enter your initials');
                return;
            }

            this.$apollo.mutate({
                mutation: gql`mutation ($scoreInput: ScoreInput!) {
                    createScore(scoreInput: $scoreInput) {
                        score
                        userName
                    }
                }`,
                // Params
                variables: {
                    scoreInput: {
                        score: this.userScore,
                        userName: this.user
                    }
                },
            }).then((data) => {
                // Result
                console.log(data);
            }).catch((error) => {
                // Error
                console.error(error);
            });
        },
    }
}
</script>

<template>
    <div class="card">
        <div class="form" v-if="this.isComplete">
            <label>
                Your score: <strong>{{ userScore }}</strong> <input type="text" placeholder="ENTER INITALS" maxlength="3" v-model="user" />
                <button v-on:click="saveScore">Enter Score</button>
            </label>
        </div>
        <div class="scores">
            <h1>HIGH SCORES</h1>
            <ul>
                <li>
                    <div class="col-2">SCORE</div>
                    <div class="col-2">NAME</div>
                </li>
                <li v-for="(item, i) in topScores" v-bind:key="i">
                    <div class="col-2">{{ item.userName }}</div>
                    <div class="col-2">{{ item.score }}</div>
                </li>
            </ul>
        </div>
    </div>
</template>

<style lang="scss" scoped>
   @import "~styles/card.scss";
</style>