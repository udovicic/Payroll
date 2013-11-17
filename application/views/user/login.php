            <div class="account-wall">
                <form class="user-form" id="user-login" name="user-login" action="<?php echo base_url(); ?>user/login" method="post">
                    <div class="input-group first">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" id="username" name="username" class="form-control" placeholder="<?php echo lang('ph_username') ?>" autofocus>
                    </div>
                    <div class="input-group last">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        <input type="password" id="password" name="password" class="form-control" placeholder="<?php echo lang('ph_pwd'); ?>">
                    </div>
                    <a href="<?php echo base_url(); ?>user/reset" class="reset"><?php echo lang('lbl_reset_pwd'); ?></a>
                    <button id="signin" name="signin" class="btn btn-lg btn-primary btn-block" type="submit"><?php echo lang('btn_sign_in'); ?></button>
<?php if (isset($notify)): ?>
                    <div class="alert alert-danger text-center"><?php echo $notify; ?></div>
<?php endif; ?>
                </form>
            </div>
            <a href="<?php echo base_url(); ?>user/register" class="text-center bottom-text"><?php echo lang('lbl_create_acc'); ?></a>
