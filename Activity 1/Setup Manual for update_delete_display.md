How to Implement in WAMP:
1. Start WAMP Server: Make sure your WAMP server icon is green (indicating Apache and MySQL are running).

2. Access phpMyAdmin: Go to http://localhost/phpmyadmin/ in your browser (you can usually click the WAMP icon and select "phpMyAdmin").

3. Create the Database:

Click the "Databases" tab.

In the "Create database" field, type test_db and click "Create".

4. Create the Table:

Click on the newly created test_db database in the left panel.

Click the "SQL" tab.

Paste the Test_db.sql file command above into the text area and click "Go".

5. Save the PHP Files:

Go to your WAMP directory (usually C:\wamp64\www).

Create a new folder for your project (e.g., C:\wamp64\www\php_crud).

Save the four PHP files (config.php, delete.php, display.php, update.php) inside this new folder.


6. Test the Programs: Open your browser and navigate to http://localhost/php_crud/display.php

7. Make sure to insert all of the .sql files into the phpmyadmin server. (number 4).
