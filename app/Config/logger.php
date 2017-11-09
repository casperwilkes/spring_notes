<?php

/**
 * Purpose:
 *  Logger utility default config
 * History:
 *  110617 - Lincoln: Created file
 */

return array(
    // Time formats //
    'time_format' => "%Y-%m-%d %H:%M:%S", // 2016-01-24 14:11:16
    // Sample Formats //
    //'time_format' => "%m-%d-%Y %H:%M:%S", // 01-24-2016 17:34:32
    //'time_format' => "%m-%d-%Y %I:%M:%S %p", // 01-24-2016 05:39:05 PM
    //'time_format' => "%a %m/%d/%y %H:%M:%S", // Sun 01/24/16 17:42:31
    //'time_format' => "%A %m/%d/%Y %I:%M:%S %p", // Sunday 01/24/2016 05:44:18 PM
    //'time_format' => "%A %d %B %Y %I:%M:%S %p", // Sunday 24 January 2016 05:47:45 PM
    // If you want the logs serialized for storage and unserialized when retrieving //
    'serialize' => false,
    // Path to logs directory //
    'log_path' => SITE_ROOT,
    // Directory name to save logs //
    'logs_dir' => '/logs/',
    // If no log is specified //
    'default_log' => 'general',
    // Default logging level if not is specified //s
    'default_level' => 'info',
    // How to handle multi-dimensional arrays //
    'multi' => 'print',
    // 'multi' => 'json',
);

