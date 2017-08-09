<script>
import gql from 'graphql-tag';

const topScoresQuery = gql`query topScores {
    topScores {
        score
        userName
    }
}`;

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
            query: topScoresQuery,
        }
    },
    methods: {
        saveScore() {
            const payload = {
                score: this.userScore,
                userName: this.user
            };

            if (!payload.userName) {
                alert('Please enter your initials');
                return false;
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
                        score: payload.score,
                        userName: payload.userName,
                    }
                },
                // Update leaderboard
                update: (proxy, { data: createScore }) => {
                    const data = proxy.readQuery({ query: topScoresQuery });
                    data.topScores.push(createScore);
                    // Write data back to the local cache
                    proxy.writeQuery({ query: topScoresQuery, data });
                },
            }).then((data) => {
                // Result
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
                Your score: <strong>{{ userScore }}</strong> <input type="text" placeholder="ENTER INITALS" maxlength="3" v-model="user" :disabled="!this.userScore" />
                <button v-on:click="saveScore" :disabled="!this.userScore">Enter Score</button>
            </label>
        </div>
        <div class="scores">
            <h1>HIGH SCORES</h1>
            <ul>
                <li>
                    <div class="col-2"><h4>NAME</h4></div>
                    <div class="col-2"><h4>SCORE</h4></div>
                </li>
                <li v-for="(item, i) in topScores" v-bind:key="i">
                    <div class="col-2">{{ item.userName }}</div>
                    <div class="col-2">{{ item.score }}</div>
                </li>
                <br>
                <li class="clear"></li>
            </ul>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    @import "~styles/card.scss";

    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .col-2 {
        width: 45%;
        float: left;
        margin: 0 15px;
    }

    .clear {
        height: 20px;
        clear: both;
    }
</style>