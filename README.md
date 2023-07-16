Tech Test 
==========

Plan
----

Movie look up site.
Form for name/year
Check db
If in db return data
Else ping open movie api
And save data in db for future calls, before returning data
For fun add a button for 'I'm feeling lucky?' 
Get a random result from the db. 

Edge cases
----------

No move in the api? - covered error path take user back search page with no error msgs 
2 movies in the api ? -  covered returns only one result
Missing fields in the api ?  - covered with validation 
Look up title in db not exact match - covered with looser search query for titles.

Improvements? 
--------------

Error logging, to track if/how api calls fail. 
Use data seeders to prefill some movies in the db, so there's always data at hand. 
Run tests with coverage, aim for close to 100% as possible. 
Started using tailwindcss as its new, would go further with it nextime

Progress
--------

-   Step one is to get a clean local install of laravel, done using laravel sail, to get a docker container spun up. 
-   Configure basics, scraping some extra stuff not needed etc 
-   Misc project specific local setup 
-   Add new phpunit config and directories to phpstorm, and make sure the tests run clean.
-   Setup xdebug in phpstorm so data/variables can be inspected mid execution.
-   Made 'Movie' eloquent model, and matching migration.
-   Running migration on command line made new table

-   Setup call basic call to the movie api. Call uses config to extract the api keys, and has a title search field passed in
-   Before the api is called, the movie title from the search form is checked against the db. If theres a match we skip the api. 
-   Else the api is called and data is received.

-   Map data that we will be expecting from the api  
-   Data to include : movie title, year, synopsis, poster, age rating, and metacritic

-   Api data is checked, for status, and basic data validity. 
    If either fail we dont try to add to the db, and the user is taken back to the form without loading anything.
-   If data is good it is mapped out and saved as a new entry in the movies table. 
-   Before returning the page with the data from the db, ready to render.
-   Unit tests:  adding more useful test coverage, using to change code to catch edge cases, and general tidyup safely.

-   Alternate path is i'm feeling lucky, this pings the db, looking for a single row at random, and renders the page with its result accordingly.

Frontend : 
-   Started to break things into blade components/layouts
-   Quick tidy of the view, using existing style options to save time as much as possible.

Screenshots
--------------
A bunch of screenshots from dev, can be found in the screenshots directory. 
