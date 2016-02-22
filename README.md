# YahooGroups
Create your own archive for yahoogroups. Need PGOffline &amp; MS-ACCESS 

For many years I am using PGOffline, a tool to get all the content from yahoogroups.

PGOffline was using up to version 3 an Access Database but with the release of version  4 they went to an SQLite database.  Here came my problem.
For years I was inserting the data from the Access Database into an MySQL database so that with an PHP script I could search through more than 100.00 messages.
But after PGOffline went to SQLite I had an issue cause my ODBC connection was not working anymore. Due to some change in PC’s and notebooks I lost my access database with the ODBC and Queries as well (damn .. )
Altough the mailinglist is not that active anymore, there were some 6000 messages submitted in around 1,5 to 2 years. and I want to have them inserted in the MySQL database still ..
The issue I had was that the SQLite database of PGOffline contains a BLOB (Binary Object)  with the message and is not ‘simply’ readable.
for months I was trying and there was no solution for me to fix that. Until last weekend. And actually it was pretty easy. And I fixed it ..

1. Microsoft Access
2. Make sure you have access to your MySQL database and able to connect to it (do check my.cnf for the bind address (if you are on Linux) make sure you can connect to it from other machines) and make sure the firewall does not block its port (which I noticed after 15 minutes of trying or so)
3. install MySQL ODBC drivers in your environment
4. install SQLite ODBC drivers in your environment

In Access make sure you link to the database with linked tables.
the SQLite database is just the file. In my example its on the same computer as the Access database
The issue I had with the SQLite database and its linked tables was that the ODBC driver did not allow me to search with wildcards (select * from person  where person is like ‘a%’) . To make sure I have all subscribers I made an update query to a local table with all the persons, but in fact that is not needed.
Than I made sure I could read the messages
with this query: ‘StrConv([content],64)’ I was able to decode the BLOB.  and with some other InStr queries I removed the beginning and end of the start of the message as this is ‘garbage’ not needed, I added some HTML breaks.

Finally I created an update query inserting all the new messages from the SQL database not in the MySQL database, I even found that very old messages were not imported at all they were forgotten, now they were inserted as my Query statement request to insert all YahooMessageID’s not in the MySQL database ..
