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
_If you set the `.htaccess`, you will not need to set the `bootstrap.php`._ 

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

An abbreviated explanation of config files is provided here. For a more comprehensive explanation, see the `./Configs.md`
file.

The config files are personalized settings for whatever environment the application is currently set on. Config files should
not interfere with each other. As long as the environment is set correctly, the configs set for `dev` should not interfere 
with the config settings for `prod`. 

The main take away is that there should be a config directory setup for your environment. If your environment is named `my_box`,
and you want personalized settings for a specific feature, you need to have a config dir named `my_box`, and a config file named 
after that feature. 

The beauty of this setup is that you build upon already defined default settings which you can then tweak without having to redefine
default presets. You only need to modify specific settings. 

For more information, see the `Configs.md` file. 

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
* _I would recommend setting up a database config file or at least looking at the one in `app/configs/db.php`_
* _The default password for all of the accounts besides test is `password`_


### Routes ###

Because I'm not sure of you're web-root, or setup (as far as what server setup you're using), I don't know the best way to set up the 
SITE_ROOT to point to the public directory. Because of this, the routes will look like:

`http://localhost/spring_notes/public/*`

I've setup the .htaccess to point all traffic into the `public` directory to the `index.php`.

### Using the API ###

Because I wanted to show several different ways of doing things throughout the application, I chose to keep
the API focused on Notes only. The User data is all handled directly through the controller/model/database layers. 

**Note:**

_I've added authentication to the API, so in order to use it without going through the application, you will need
to include the `key` and `token` tokens with your requests.These tokens can be found at: `.app/Configs/app_tokens.php`._

For more information, go to `http://localhost/spring_notes/public/api`

## Contact ###

I think that pretty much sums up everything. There are a few more things I wish I had time to do, but I tried to get it together as quickly as possible. 
If there is anything missing you'd like to see, or you'd like more information on how to do something, please let me know. I would be more than willing
to go over it or work with you. I can be contacted @ <casper@casperwilkes.net> 