           <div class="account-wall">
                <form class="user-form" id="user-register" name="user-register" action="<?php echo base_url(); ?>user/register" method="post">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" autofocus>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                    <button class="btn btn-lg btn-primary btn-block" name="register" type="submit">Create account</button>
<?php if (isset($notify)): ?>
                    <div class="alert alert-danger text-center"><?php echo $notify; ?></div>
<?php endif; ?>
                </form>
            </div>
            <a href="<?php echo base_url(); ?>user/login" class="text-center bottom-text">Sign in</a>
