<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Spring Notes Project Portal">
        <link rel="icon" href="favicon.ico">

        <title>Spring Notes <?= $title ?></title>
        <link href="<?= $baseUrl; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= $baseUrl; ?>/assets/css/ie10_viewport.css" rel="stylesheet">
        <link href="<?= $baseUrl; ?>/assets/css/theme/basic.css" rel="stylesheet">
        <link href="<?= $baseUrl; ?>/assets/css/custom.css<?= '?' . strtotime('now'); ?>" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?= $baseUrl; ?>/assets/js/jquery.min.js"><\/script>');</script>
        <script src="<?= $baseUrl; ?>/assets/js/bootstrap.min.js"></script>
        <script src="<?= $baseUrl; ?>/assets/js/ie10_viewport.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <base href="<?= $baseUrl; ?>/">
    </head>

    <body>
        <div class="container">
            <nav class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#navbar"
                                aria-expanded="false"
                                aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?= $baseUrl; ?>"><?= $navigation->getProject(); ?></a>
                    </div>
                    <div id="navbar" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <?php foreach ($navigation->navBar() as $n): ?>
                                <li class="<?= ($n['active']) ? 'active' : ''; ?>">
                                    <a href="<?= $n['link']; ?>"><?= $n['display']; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </nav>

            <header class="row">
                <div class="col-sm-12">
                    <h2 class="text-center"><?= isset($header) ? $header : ''; ?></h2>
                </div>
            </header>

            <?php include TPL_DIR . '/messages/index.php'; ?>

            <main role="main" class="row">
                <?= $content; ?>
            </main>
            <footer class="row">
                <div class="col-sm-12">
                    <p class="pull-right small">&copy;<?= date('Y'); ?> The Spring Notes Project</p>
                </div>
            </footer>
        </div>
    </body>
</html>
