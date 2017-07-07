import Vue from 'vue';
import App from './app.vue';
import { ApolloClient, createNetworkInterface } from 'apollo-client';
import VueApollo from 'vue-apollo';

const apolloProvider = new VueApollo({
    defaultClient: apolloClient,
});

// Create the Apollo client
const apolloClient = new ApolloClient({
    networkInterface: createNetworkInterface({
        uri: 'http://localhost:8080/graphql',
        transportBatching: true,
    }),
    connectToDevTools: true,
})

// Install the Vue plugin
Vue.use(VueApollo);

new Vue({
    el: '#app',
    apolloProvider,
    render: h => h(App),
});
