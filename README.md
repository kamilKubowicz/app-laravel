# Laravel-app

To run the project, create a folder, then use the command 

```
   git clone git@github.com:kamilKubowicz/app-laravel.git
```

Then install the required packages by 

```
   composer install
```

Copy the .env.example file as .env and set up the connection to the database 

It is recommended to set the alias

```
   alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```
To start all of the Docker containers in the background, you may start Sail in "detached" mode

```
   sail up -d
```

If you have set up database access migrate the tables

```
   sail artisan migrate
```

To handle the statements sent to the queue, run the following


```
   sail artisan queue:work
```


To run the tests use

```
   sail phpunit
```
