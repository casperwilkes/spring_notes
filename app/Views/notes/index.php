<div class="row">
    <div class="col-sm-12 col-md-6 col-md-offset-1">
        <a href="notes/create" class="btn btn-primary"><?= glyph('plus'); ?> New Note</a>
        <a href="logout" class="btn btn-warning"><?= glyph('remove'); ?> Log Out</a>
    </div>
</div>

<br>
<div class="row">
    <div class="col-sm-12 col-md-8 col-md-offset-2">
        <?php if (!empty($notes)): ?>
            <?php foreach ($notes as $note): ?>
                <div class="well well-sm">
                    <p class="pull-right">
                        <a href="notes/edit/<?= $note['id']; ?>" class="btn btn-info btn-xs"><?= glyph('pencil') ?>
                            Edit</a>
                        <a href="notes/delete/<?= $note['id']; ?>" class="btn btn-danger btn-xs"><?= glyph('trash') ?>
                            Delete</a>
                    </p>
                    <p>
                        Created by <?= ucwords($note['name']); ?>
                        on <?= date('D, M j, Y \a\t g:i a', strtotime($note['created_at'])); ?>
                    </p>
                    <p><?= htmlspecialchars($note['title'], ENT_QUOTES | ENT_SUBSTITUTE); ?></p>
                    <p><?= nl2br(htmlspecialchars($note['body'], ENT_QUOTES | ENT_SUBSTITUTE)); ?></p>
                    <?php if (!is_null($note['updated_at'])): ?>
                        <p class="pull-right small">
                            Modified <?= date('D, M j, Y \a\t g:i a', strtotime($note['updated_at'])); ?>
                        </p>
                        <div class="clearfix"></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="well well-sm">
                <p class="text-center">There are no notes to show at this time. Please create a new note to get started!</p>
            </div>
        <?php endif; ?>
    </div>
</div>
