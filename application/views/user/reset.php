            <div class="account-wall">
                <form class="user-form pwd-reset" id="user-reset" name="user-reset" action="<?php echo base_url(); ?>user/reset" method="post">
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" autofocus>
                    <button id="pwd_reset" name="pwd_reset" class="btn btn-lg btn-primary btn-block" type="submit">Reset password</button>
<?php if (isset($notify)): ?>
                    <div class="alert alert-danger text-center"><?php echo $notify; ?></div>
<?php endif; ?>
                </form>
            </div>
            <a href="<?php echo base_url(); ?>user/login" class="text-center bottom-text">Sign in</a>
