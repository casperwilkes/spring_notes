<div class="row">
    <div class="col-xs-10 col-md-10 col-xs-offset-1 col-md-offset-1">
        <?php if ($messenger->count()): ?>
            <?php foreach ($messenger->getMessages() as $message): ?>
                <?php
                // Check message type type //
                switch ($message['type']) {
                    case 'error':
                        $class = 'danger';
                        break;
                    case 'success':
                        $class = 'success';
                        break;
                    case 'warning':
                        $class = 'warning';
                        break;
                    default:
                        $class = 'info';
                        break;
                }
                ?>
                <div class="alert alert-<?= $class; ?> text-center alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                    <p class="lead">
                        <?= $message['message']; ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>