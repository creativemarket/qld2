import graphql from 'graphql.js';

const graph = graphql("http://localhost:8080/graphql", {
    method: "POST", // POST by default.
});

graph.query(`{
    quiz {
        quote {
            text
        }
    }
`)();
