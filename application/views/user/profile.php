            <form action="<?php echo base_url(); ?>user/profile" role="form" class="form-horizontal profile" method="post">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $username ?>" placeholder="Username">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email ?>" placeholder="Email">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <select name="rate" class="form-control" id="rate">
<?php foreach ($rates as $rate): $selected = ($rate['rate_id'] == $rate_id) ? 'selected' : ''; ?>
                            <option value="<?php echo $rate['rate_id']; ?>" <?php echo $selected; ?>><?php echo $rate['name']; ?></option>
<?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-lg btn-success btn-block">Spremi</button>
                    </div>
                </div>
                <?php if (isset($notify)): ?>
                    <div class="alert alert-danger text-center"><?php echo $notify; ?></div>
                <?php endif; ?>
            </form>
