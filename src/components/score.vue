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
        <h1>{{ score }} pts</h1>
    </div>
</template>

<style lang="scss" scoped>
</style>