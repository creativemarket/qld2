<script>
import gql from 'graphql-tag';

export default {
    data() {
        return {
            quiz: this.$root.$data,
            score: 0,
            total: 0,
            message: {},
            completed: false,
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
                }
            }`,
        }
    },
    mounted() {
        console.log(this.$root.$data);
    },
}
</script>

<template>
    <div class="">
        <h1>Welcome to Star War</h1>
        <h2>{{ quiz }}</h2>
    </div>
</template>

<style lang="scss" scoped>
   @import "~styles/main.scss";
</style>
