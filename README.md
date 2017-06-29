## Sample query 

```
{
  viewer {
    ...charData
  }
	rey: character(id: 1) {
    ...charData
  }
  leia: character(id: 2) {
		...charData
  }
  maz: character(id: 3) {
    ... charData
  }
  movies {
    title
    totalQuoteCount
    quotes(after: 1) {
      ... quoteInfo
      replies {
        ... quoteInfo
      }
    }
  }
  lastMoviePosted {
    title
  }
}

fragment charData on Character {
    email
    firstName
    lastName
}

fragment quoteInfo on Quote {
  body
  character {
    ... charData    
  }
  totalReplyCount
}
```
