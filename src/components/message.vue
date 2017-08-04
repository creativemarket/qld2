<script>
export default {
    props: {
        message: {
            type: Object,
            required: true,
        },
    },
}
</script>

<template>
    <div>
        <h3>{{ message.type }}</h3>
    </div>
</template>

<style lang="scss" scoped>
   @import "~styles/card.scss";
</style>