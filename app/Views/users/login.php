<div class="row">
    <div class="col-xs-10 col-lg-8 col-xs-offset-1 col-lg-offset-2">
        <div class="panel panel-default">
            <div class="panel-body">
                <form method="POST" action="login" class="form-horizontal">
                    <fieldset>
                        <div class="form-group">
                            <label for="email" class="control-label col-md-2 hidden-sm hidden-xs">Email</label>
                            <div class="col-xs-12 col-md-10">
                                <input type="email" id="email" name="email" class="form-control"
                                       value="<?= isset($email) ? $email : ''; ?>" placeholder="Email Address"
                                       maxlength="255" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Password" class="col-md-2 control-label hidden-sm hidden-xs">Password</label>
                            <div class="col-xs-12 col-md-10">
                                <input type="password" id="password" name="password" class="form-control"
                                       value="<?= isset($password) ? $password : ''; ?>" placeholder="Password"
                                       maxlength="255" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-1">
                                <button type="submit" name="submit" class="btn btn-primary">Send</button>
                                <a href="register" class="btn btn-info">Register</a>
                                <button type="Reset" class="btn btn-default">Cancel</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>