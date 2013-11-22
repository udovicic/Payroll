            <div class="account-wall">
                <form class="profile user-delete" id="user-delete" name="user-delete" action="<?php echo base_url(); ?>user/delete" method="post">
                    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="code" id="code" value="<?php echo $code; ?>">
                    <div class="form-group row">
                        <p class="form-control-static"><h3 class="text-center"><?php echo lang('user_delete_msg'); ?></h3></p>
                    </div>
                    <div class="form-group row">
                        <p class="form-control-static text-center"><strong><?php echo lang('user_delete_confirm'); ?></strong></p>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-offset-2 col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="<?php echo lang('ph_pwd'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-offset-4 col-sm-4">
                            <button type="submit" class="btn btn-lg btn-danger btn-block"><?php echo lang('btn_delete_acc'); ?></button>
                        </div>
                    </div>
                    <div id="result">
<?php if (isset($notify)): ?>
                        <div class="alert alert-danger text-center"><?php echo $notify; ?></div>
<?php endif; ?>
                    </div>
                </form>
            </div>
