An example of a full working solution with Symfony 2 and doctrine

A Symfony project created on November 13, 2016, 9:23 am.
Download the repository
run composer install
configure the database information (Mysql)
Create the database by running the following command "php app/console doctrine:database:create"
Create the database schema by running the following command "app/console doctrine:schema:update --force"
Run the application by running the following command "php app/console server:run"

Open a browser and register as a user http://127.0.0.1:8000/register

