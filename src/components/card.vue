<script>
import answer from '../mixins/answer';

export default {
    props: {
        type: {
            type: Object,
            required: true,
        },
    },
    mixins: [answer],
}
</script>

<template>
    <div class="card">
        <h1>Card</h1>
    </div>
</template>
