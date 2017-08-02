<script>
export default {
    props: {
        scores: {
            type: Object,
            required: true,
        },
    },
}
</script>

<template>
    <div>
        <h1>Leaderboard</h1>
        <ul>
            <li v-for="(user, i) in scores" v-bind:key="i">{{ user.name }} - {{ user.score }}</li>
        </ul>
    </div>
</template>

<style lang="scss" scoped>
   @import "~styles/card.scss";
</style>