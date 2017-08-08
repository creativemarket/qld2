<script>
export default {
    props: {
        score: {
            type: Number,
            required: true,
        },
    },
}
</script>

<template>
    <div class="score">
        <h2>{{ score }} pts</h2>
    </div>
</template>

<style lang="scss" scoped>
   @import "~styles/score.scss";
</style>