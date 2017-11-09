# Spring Notes #

## Purpose ##

The purpose of this application is to display proficiency in web-development driven programming languages and 
constructs. Also, knowledge and a working example of API usage.

## Requirements ##

Create a simple note making application. The application should consist of:

* A login page
* A logout mechanism
* Session control
* A main notes dashboard
* A notes creation page
* A notes edit page
* A notes deletion mechanism

I also took the liberty to create a user's registration page for quick and easy account creation without 
having to manually create users through other means.

## Languages used in application ##

* mysql
* php
* html
* css
* javascript

## Frameworks used ##

The base of the application relies on [Slim Framework v2](http://docs.slimframework.com). 

The application's bootstrap / Autoloader is [Composer](https://getcomposer.org/).

The [php-curl-class](https://github.com/php-curl-class/php-curl-class) was used to talk to the API portion of the application.

[Bootstrap v3](https://getbootstrap.com/docs/3.3/) was used as the base framework of the front end.

## Application Layout ##
```text
.
├── app # Base of the application
│   ├── Config # Various config files for the application
│   ├── Controller # Controllers for application (routes)
│   ├── Includes # Misc. include files needed for instantiation
│   ├── Model # Models 
│   ├── Utility # Classes that have various tasks throughout the application
│   └── Views # Template files
├── logs # Log output directory
├── public # Public facing portion of the application
│   ├── assets # Assets for the front end (css, js, img..)
│   └── index.php
└── vendor # Composer container
```

## Setup ##

In order to run the application, there are a few steps that need to be taken to setup. The most important are
setting the environment, and setting the configs up for that environment. Both are explained below.

### Environments ###

Setting the environment is important because we can set a single application up and have it run in multiple environments
with very little hassle in between. 

The environment that the application will run on can be whatever you want it to be (dev, qa, prod, my_box.. etc). 

There are 2 different places that you can set the environment up: `./public/.htaccess`, and `./app/includes/bootstrap.php`. 

The reason I have included separate ways is because some people prefer one over the other. Both preferences are explained below.

**Note:**
>If you set the `.htaccess`, you will not need to set the `bootstrap.php`. 

#### Setting the Environment With .htaccess ####

In order to set your environment with the htaccess, replace `dev` with the environment of your choice.

```apacheconfig
# Multiple Environment config, set this to development, staging or production
SetEnv ENV dev
```

#### Setting the Environment with Bootstrap.php ####

In order to set your environment up with the bootstrap, replace `'dev'` with the environment of your choice.
```php
// Manual Environment //
$env = 'dev';
```

## How to use the configs ##

The config files are very important, and may require some explaining. There are base configs, and configs that are setup
based on what environment the application is setup in. I've created a function that will examine the environment, and merge
all of the configs needed for that particular use case. In most cases, the default configs are enough. In some instances though,
you will want a particular setting over another. That is where the configs come in.

**Note**
> The function first looks at the base config, and then merges the environment over the top of that. Any key overwritten will be coming 
from the environment config. 

### Configs: Example Usage ###

Let's say that for different environments, you have different database connection settings. 

**Dev**: username = dev_user, password = dev_pass, and database = dev_db

**QA**: username = qa_user, password = dev_pass, and database = dev_db.

**my_box**: username = dev_user, password = password, and database = dev_db.

Your config setup would be:

```text
./App
    /Configs
        /dev
            db.php
        /qa
            db.php
        /prod
            db.php
        /my_box
            db.php
    db.php
```

You're base settings would look like the following:

`configs/db.php`:
```php
return array(
    'dsn' => 'mysql:dbname=dev_db;host=127.0.0.1;port=3306',
    'username' => 'dev_user',
    'password' => 'dev_pass',
);
```

Because only the username has changed in your QA environment, that's all we need to change in the config.

`configs/qa/db.php`
```php
return array(
    'username' => 'qa_user',
);
```

And because only your password changed in your personal environment, that's all that needs to be changed in the `my_box` environment
`configs/my_box/db.php`
```php
return array(
    'password' => 'password',
);
```

### Config usage ###

To use the config setting in the code, all you do is use the function to pull the configs in as an array.

With the function, all you need to do is call the file by name without the extension. 

For our above example of `db.php`:

```php
// You now have a config array //
$config = loadConfig(db);
```

## Running the Application ##

### spring_notes.sql ###
After cloning your directory into your webroot, setting up the environment and configs, you will probably want to import the .sql file.
This step is not necessary, but to speed up the setup, you may want to. The sql file is found in the root of this application, `spring_notes.sql`.

This file:
* Creates a new database: `s_notes`
* Creates a new user: `spring@localhost` with a password of: `pastword`
* Grants the new user basic privileges to the `s_notes` database
* Creates a `users` and `notes` tables
* Imports some test data to the new tables

**Note:**
> I would recommend setting up a database config file or at least looking at the one in `app/configs/db.php`

### Routes ###

Because I'm not sure of you're web-root, or setup (as far as what server setup you're using), I don't know the best way to set up the 
SITE_ROOT to point to the public directory. Because of this, the routes will look like:

`http://localhost/spring_notes/public/*`

I've setup the .htaccess to point all traffic into the `public` directory to the `index.php`.

### Using the API ###

I've added authentication to the API, so in order to use it without going through the application, you will need
to include the `key` and `token` tokens with your requests. These tokens can be found at: `Configs/app_tokens.php`.

Because I wanted to show several different ways of doing different things throughout the application, I chose to keep
the API notes only. The user stuff is all handled directly through the controller/model/database layers. 

#### Sample Routes ####

To get all notes in the database: GET- `http://localhost/spring_notes/public/v1/notes?key=$2y$10$Q7hi&token=IQlFFY3A96BJveDtOPQ9Nf40i2Vf4QV0g8IoDYA8RZtgTD06`

To get note with id of 1: GET - `http://localhost/spring_notes/public/v1/notes/1?key=$2y$10$Q7hi&token=IQlFFY3A96BJveDtOPQ9Nf40i2Vf4QV0g8IoDYA8RZtgTD06`

To get all notes for user 2: GET - `http://localhost/spring_notes/public/v1/notes/2/user_id?key=$2y$10$Q7hi&token=IQlFFY3A96BJveDtOPQ9Nf40i2Vf4QV0g8IoDYA8RZtgTD06`

There are also create/update/delete routes

## Contact ###

I think that pretty much sums up everything. There are a few more things I wish I had time to do, but I tried to get it together as quickly as possible. 
If there is anything missing you'd like to see, or you'd like more information on how to do something, please let me know. I would be more than willing
to go over it or work with you. I can be contacted @ <casper@casperwilkes.net> 