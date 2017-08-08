<script>
import { EventBus } from '../main.js';

export default {
    props: {
        message: {
            type: Object,
            required: true,
        },
    },
    updated() {
        setTimeout(() => {
            EventBus.$emit('show:message', { visibile: false, type: undefined });
        }, 2000); 
    },
}
</script>

<template>
    <div v-if="this.message.type" :class="'alert alert-' + this.message.type + ''">
        <h4 v-if="this.message.type == 'correct'">Correct! Well done kid!</h4>
        <h4 v-else>Incorrect! You must learn to use the force...</h4>
    </div>
</template>

<style lang="scss" scoped>
   @import "~styles/message.scss";
</style>