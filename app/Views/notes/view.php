<div class="row">
    <div class="col-lg-10">
        <p class="pull-right">
            <a href="notes" class="btn btn-primary"><?= glyph('list-alt'); ?> Back</a>
        </p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="well well-sm">
            <?php if (!empty($note)): ?>
                <p class="pull-right">
                    <a href="notes/edit/<?= $note['id']; ?>" class="btn btn-info btn-xs"><?= glyph('pencil') ?> Edit</a>
                    <a href="notes/delete/<?= $note['id']; ?>" class="btn btn-danger btn-xs"><?= glyph('trash') ?> Delete</a>
                </p>
                <p>
                    Created by <?= ucwords($note['name']); ?>
                    on <?= date('D, M j, Y \a\t g:i a', strtotime($note['created_at'])); ?>
                </p>
                <p><?= $note['title']; ?></p>
                <p><?= nl2br($note['body']); ?></p>
                <?php if ($note['updated_at'] !== ''): ?>
                    <p class="pull-right small">
                        Modified <?= date('D, M j, Y \a\t g:i a', strtotime($note['updated_at'])); ?>
                    </p>
                    <div class="clearfix"></div>
                <?php endif; ?>
            <?php else: ?>
                <p>Could not display note data</p>
            <?php endif; ?>
        </div>
    </div>
</div>

