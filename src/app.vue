<script>
import gql from 'graphql-tag';

export default {
    data() {
        return {
            quiz: '',
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
