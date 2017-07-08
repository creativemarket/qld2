<script>
import gql from 'graphql-tag';

export default {
    data() {
        return {
            hello: '',
        };
    },
    apollo: {
        // Simple query that will update the 'hello' vue property
        hello: gql`{ hello }`,
    },
}
</script>

<template>
    <div class="">
        <h1>Welcome to Star War</h1>
        <h2>{{ hello }}</h2>
    </div>
</template>

<style lang="scss" scoped>
   @import "~styles/main.scss";
</style>
