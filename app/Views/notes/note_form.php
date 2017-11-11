<div class="row">
    <form method="POST" action="<?= $action; ?>" class="form-horizontal">
        <fieldset>
            <div class="col-xs-10 col-md-10 col-xs-offset-1 col-md-offset-1">
                <div class="row">
                    <div class="form-group">
                        <div class="col-xs-12 col-md-8 col-md-offset-2">
                            <input type="title" id="title" name="title" class="form-control"
                                   value="<?= isset($title) ? $title : ''; ?>" placeholder="Note Title"
                                   required="required">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-xs-12 col-md-8 col-md-offset-2">
                                <textarea class="form-control"
                                          id="body"
                                          name="body"
                                          rows=8
                                          required="required"
                                          placeholder="Note Body"><?= isset($body) ? $body : ''; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-xs-12 col-md-8 col-md-offset-2">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            <?php if (strpos($action, 'create') !== false): ?>
                                <button type="Reset" class="btn btn-default">Cancel</button>
                            <?php else: ?>
                                <a href="notes" class="btn btn-default">Cancel</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        </fieldset>
    </form>
</div>