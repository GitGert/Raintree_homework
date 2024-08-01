# RAINTREE PHP + MYSQL homework

in this project I followed the instructions to demonstrate my skills using PHP and MYSQL

## Setting Up Your Local Environment

You will need to have [MySQL](https://dev.mysql.com/doc/mysql-getting-started/en/) and [PHP](https://www.php.net/manual/en/install.php) installed and configured.

1. Clone the repository.
2. Create a `.env` file in the root directory of your project.
3. Populate the `.env` file with your database credentials:
```bash
DB_SERVER=your_server_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```
4. build the database by:
    * opening the mysql console while in the root directory
    ```bash
    mysql
    ```
    * running the following command:
    ```bash
    source setup.sql 
    ```
Now you are all set to test out the program.

 # HOW TO RUN:


### task 1:

task 1 can be inspected in the setup.sql file.

### task 2:

Task 2 is in the src/task-2.php file.

You can run the file in order to test with:
```bash
php src/task-2.php
```

### task 3:

task 3 is in src/task-3.php

the easiest way to test task 3 is to run the test:
```bash
php src/test.php
```

Optionally you can also uncomment any or both of these lines in order to get class specific tests (inside of src/test.php):
```bash
// test_patient();
// test_insurance();
```


## USAGE OF AI DURING DEVELOPMENT

Since the task was fairly straight forward I would like to point out where I did and did not use the help of AI.

setup.sql - is mostly done by AI, I only modified some of the dates and made sure that everything was correct.

as for everything else - **NONE of the functions or longer pieces of code have been AI generated**, most of the help I took was from [official documentation](https://www.php.net/manual/en/), [w3schools tutorials](https://www.w3schools.com/php/default.asp) or [stackoverflow](https://stackoverflow.com/).
For some specific issues I used [AI](https://www.phind.com/).