<div class="row">
    <div class="col-xs-12 col-md-6 col-md-offset-1">
        <p>
            <a href="notes" class="btn btn-primary"><?= glyph('list-alt'); ?> Back</a>
        </p>
    </div>
</div>

<?php if ($title === '' && $body === ''): ?>
    <p class="text-center lead">Unable to locate note</p>
<?php else: ?>
    <?php include TPL_DIR . DS . 'notes' . DS . 'note_form.php'; ?>
<?php endif; ?>
