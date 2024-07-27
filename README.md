# Raintree_homework


sudo mysql -u root -p


# Prerequistes:

* MYSQL:
    * Create USER 'gert'@'localhost'
    * GRANT ALL PRIVILEGES ON *.* TO 'gert'@'localhost';



mysql -u username -p database_name < setup.sql
mysql -u gert -p insurance_db < setup.sql


in order to run the setup.sql you will need to :
* have access to your mysql console.
* go into project root 
* in mysql terminal -->:
source setup.sql 



DB commands: 

source drop_all_table.sql


use insurance_db

 show databases;
 show tables;
 describe patient;
 describe insurance;

 select * from patient;
 select * from insurance;