            <form action="<?php echo base_url(); ?>user/profile" role="form" class="form-horizontal profile" method="post">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $username ?>" placeholder="<?php echo lang('ph_username'); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email ?>" placeholder="<?php echo lang('ph_email'); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="<?php echo lang('ph_pwd'); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <select name="language" class="form-control" id="language">
                            <option value="croatian" <?php if ($sel_lang == 'hr') echo 'selected'; ?>><?php echo lang('lang_hr'); ?></option>
                            <option value="english" <?php if ($sel_lang == 'en') echo 'selected'; ?>><?php echo lang('lang_en'); ?></option>
                        </select>
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
                        <button type="submit" class="btn btn-lg btn-success btn-block"><?php echo lang('btn_profile_confirm'); ?></button>
                    </div>
                </div>
<?php if (isset($notify)): ?>
                <div class="alert alert-danger text-center"><?php echo $notify; ?></div>
<?php endif; ?>
            <a class="pull-right" href="<?php echo base_url(); ?>user/delete" class="text-center bottom-text"><?php echo lang('lbl_delete_acc'); ?></a>

            </form>
<script>
    dataLayer.push({
        'eventCategory' : 'pageview',
        'eventAction'   : 'pageview',
        'eventLabel'    : 'user-profile',
        'event'         : 'UAevent',
        'eventValue'    : 1
    });
</script>
