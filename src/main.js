// import Vue from 'vue';
// import App from './app.vue';
// import { ApolloClient, createNetworkInterface } from 'apollo-client';
// import VueApollo from 'vue-apollo';

// // Create the Apollo client
// const apolloClient = new ApolloClient({
//     networkInterface: createNetworkInterface({
//         uri: 'http://localhost:8080/graphql',
//         transportBatching: true,
//         opts: {
//             credentials: 'same-origin',
//             mode: 'no-cors',
//         },
//     }),
//     connectToDevTools: true,
// });

// const apolloProvider = new VueApollo({
//     defaultClient: apolloClient,
// });

// // Install the Vue plugin
// Vue.use(VueApollo);

// new Vue({
//     el: '#app',
//     apolloProvider,
//     render: h => h(App),
// });


import ApolloClient, { createNetworkInterface } from 'apollo-client';
import gql from 'graphql-tag';

const client = new ApolloClient({
  networkInterface: createNetworkInterface({
    uri: 'http://localhost:8080/graphql',
    transportBatching: true,
    opts: {
        credentials: 'same-origin',
        mode: 'no-cors',
    },
  }),
});

client.query({
  query: gql`
    query quiz {
        quiz {
            quote {
                text
            }
        }
    }
  `,
}).then(data => console.log('success:', data)).catch(error => console.error('error', error));