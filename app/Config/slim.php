<?php

/**
 * Purpose:
 *  Slim default application config
 * History:
 *  110517 - Lincoln: Created file
 */

use Slim\LogWriter;
use Spring_App\Includes\CustomView;

return array(
    // Log writer //
    'log.writer' => new LogWriter(fopen(SITE_ROOT . '/logs/slim_errors.txt', 'a')),
    // Debug options //
    'debug' => false,
    // Templates path //
    'templates.path' => TPL_DIR,
    // Slim Templates Render Engine //
    'view' => new CustomView(),
    // What environment are we in //
    'mode' => ENV,
    // Make route calls case-insensitive //
    'routes.case_sensitive' => false,
);