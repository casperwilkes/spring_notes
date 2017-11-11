## Configs ##

## How to use the configs ##

The config files are very important, and may require some explaining. There are base configs, and configs that are setup
based on what environment the application is setup in. I've created a function that will examine the environment, and merge
all of the configs needed for that particular use case. In most cases, the default configs are enough. In some instances though,
you will want a particular setting over another. That is where the configs come in.

**Note**
_The function first looks at the base config, and then merges the environment over the top of that. Any key overwritten will be coming 
from the environment config._ 

### Configs: Example Usage ###

Let's say that for different environments, you have different database connection settings. 

_**Dev**_: username = dev_user, password = dev_pass, and database = dev_db

_**QA**_: username = qa_user, password = dev_pass, and database = dev_db.

_**my_box**_: username = dev_user, password = password, and database = dev_db.

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

`configs/qa/db.php`:
```php
return array(
    'username' => 'qa_user',
);
```

And because only your password changed in your personal environment, that's all that needs to be changed in the `my_box` environment

`configs/my_box/db.php`:
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