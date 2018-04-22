ASSIGNMENT NOTES

I had to improvise a bit, since I did not understand what was meant by 
'Book only read endpoint' and 'An endpoint to bind 1 or more books to an user'

So I came up with a description that allows me to set up a relational database structure. 

This API is for a simple sport betting game.

Users can place bets on matches between teams.
Each match has the odds set.
All teams have unique names, and a team has not more then 1 match per day. 

The 'book' in this game is defined as a list of all bets that are placed on the match, listing the user and amount. 
We can retrieve the book using the names of the team, and the date.

-----

DEVELOPMENT NOTES

Currently the system allows duplicate bets. 
We might want to allow users to place multiple bets on the same match, 
but then we need to find a solution to prevent duplicate requests create unwanted duplicate bets. 
To prevent this, we ask the client to send a unique transaction id when sending the bet. 

Some database migration scripts have been updated. This is justified when the code has not yet been pushed, 
and other developers or environments have not yet run the migrations.
Otherwise new migrations to alter the tables need to be added.

You might have noticed that I ask the client to send the names of both teams, 
even though the name of 1 team would technically be enough. 
I like to be more specific when asking the client to provide information, to prevent any errors made by the client. 
They might be confused, send 'Manchester City' instead of 'Manchester United', 
but still complain to us because they bet on the wrong match. 

The tests are now restoring the database with a dump file, in real life I don't do that. 
I would use the migration scripts to setup the structure, and have a few classes to 
pre populate the database with the necessary data. I would also use a separate test database. 