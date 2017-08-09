/*
  ÛÛÛÛÛÛÛÛÛ  ÛÛÛÛÛÛÛÛÛÛÛ   ÛÛÛÛÛÛÛÛÛ   ÛÛÛÛÛÛÛÛÛÛÛ      ÛÛÛÛÛ   ÛÛÛ   ÛÛÛÛÛ   ÛÛÛÛÛÛÛÛÛ   ÛÛÛÛÛÛÛÛÛÛÛ  
 ÛÛÛ°°°°°ÛÛÛ°Û°°°ÛÛÛ°°°Û  ÛÛÛ°°°°°ÛÛÛ °°ÛÛÛ°°°°°ÛÛÛ    °°ÛÛÛ   °ÛÛÛ  °°ÛÛÛ   ÛÛÛ°°°°°ÛÛÛ °°ÛÛÛ°°°°°ÛÛÛ 
°ÛÛÛ    °°° °   °ÛÛÛ  °  °ÛÛÛ    °ÛÛÛ  °ÛÛÛ    °ÛÛÛ     °ÛÛÛ   °ÛÛÛ   °ÛÛÛ  °ÛÛÛ    °ÛÛÛ  °ÛÛÛ    °ÛÛÛ 
°°ÛÛÛÛÛÛÛÛÛ     °ÛÛÛ     °ÛÛÛÛÛÛÛÛÛÛÛ  °ÛÛÛÛÛÛÛÛÛÛ      °ÛÛÛ   °ÛÛÛ   °ÛÛÛ  °ÛÛÛÛÛÛÛÛÛÛÛ  °ÛÛÛÛÛÛÛÛÛÛ  
 °°°°°°°°ÛÛÛ    °ÛÛÛ     °ÛÛÛ°°°°°ÛÛÛ  °ÛÛÛ°°°°°ÛÛÛ     °°ÛÛÛ  ÛÛÛÛÛ  ÛÛÛ   °ÛÛÛ°°°°°ÛÛÛ  °ÛÛÛ°°°°°ÛÛÛ 
 ÛÛÛ    °ÛÛÛ    °ÛÛÛ     °ÛÛÛ    °ÛÛÛ  °ÛÛÛ    °ÛÛÛ      °°°ÛÛÛÛÛ°ÛÛÛÛÛ°    °ÛÛÛ    °ÛÛÛ  °ÛÛÛ    °ÛÛÛ 
°°ÛÛÛÛÛÛÛÛÛ     ÛÛÛÛÛ    ÛÛÛÛÛ   ÛÛÛÛÛ ÛÛÛÛÛ   ÛÛÛÛÛ       °°ÛÛÛ °°ÛÛÛ      ÛÛÛÛÛ   ÛÛÛÛÛ ÛÛÛÛÛ   ÛÛÛÛÛ
 °°°°°°°°°     °°°°°    °°°°°   °°°°° °°°°°   °°°°°         °°°   °°°      °°°°°   °°°°° °°°°°   °°°°° 
*/

import Vue from 'vue';
import App from './app.vue';
import { ApolloClient, createNetworkInterface } from 'apollo-client';
import VueApollo from 'vue-apollo';
import $ from 'jquery';

export const EventBus = new Vue();

// Create the Apollo client
const apolloClient = new ApolloClient({
    networkInterface: createNetworkInterface({
        uri: 'http://localhost:8080/graphql',
        transportBatching: true,
        opts: {
            credentials: 'same-origin',
        },
    }),
    connectToDevTools: true,
});

const apolloProvider = new VueApollo({
    defaultClient: apolloClient,
});

// Install the Vue plugin
Vue.use(VueApollo);

new Vue({
    el: '#app',
    apolloProvider,
    render: h => h(App),
});
