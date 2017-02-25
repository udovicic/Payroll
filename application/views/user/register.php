<?php if ($ajax == false): ?>           
            <div class="account-wall">
                <form class="user-form" id="user-register" name="user-register" action="<?php echo base_url(); ?>user/register" method="post">
                    <div class="input-group first">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" id="username" name="username" class="form-control" placeholder="<?php echo lang('ph_username'); ?>" autofocus>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                        <input type="email" id="email" name="email" class="form-control" placeholder="<?php echo lang('ph_email'); ?>">
                    </div>
                    <div class="input-group last">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        <input type="password" id="password" name="password" class="form-control" placeholder="<?php echo lang('ph_pwd'); ?>">
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" name="register" type="submit"><?php echo lang('btn_create_acc'); ?></button>
                    <div id="result">
<?php endif; ?>
<?php if (isset($notify)): ?>
                        <div class="alert alert-danger text-center"><?php echo $notify; ?></div>
<?php endif; ?>
<?php if ($ajax == false): ?>
                    </div>
                </form>
            </div>
            <a href="<?php echo base_url(); ?>user/login" class="text-center bottom-text"><?php echo lang('lbl_sign_in'); ?></a>
<?php endif; ?>
<script>
    dataLayer.push({
        'eventCategory' : 'pageview',
        'eventAction'   : 'pageview',
        'eventLabel'    : 'user-register',
        'event'         : 'UAevent',
        'eventValue'    : 1
    });
</script>
