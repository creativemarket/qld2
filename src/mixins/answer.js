import { EventBus } from '../main.js';

/* 
* Clicked; check isCorrect and display message
* roll for chance to play bonus round
*/
export default {
    methods: {
        answerClick(bool, type) {
            if (bool && type == 'character') {
                // Character answer
                EventBus.$emit('update:score', 100);
                EventBus.$emit('show:message', { visibile: true, type: 'correct' });

                // Roll for a possible bonus quesiton
                if (Math.floor(Math.random() * 2)) {
                    EventBus.$emit('show:movie', true);
                } else {
                    // No luck, move on
                    EventBus.$emit('progress:quiz');
                }
            } else if (bool && type == 'movie') {
                // Movie answer
                EventBus.$emit('update:score', 150);
                EventBus.$emit('show:message', { visibile: true, type: 'correct' });
                EventBus.$emit('progress:quiz');
            } else {
                // If incorrect progress quiz
                EventBus.$emit('show:message', { visibile: true, type: 'incorrect' });
                EventBus.$emit('progress:quiz');
            }
        },
    },
};
