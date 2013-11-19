            <script>jQuery('#menu-report').addClass('active');</script>
            <form class="shift" role="form" action="<?php echo base_url(); ?>shift/report_period" method="post">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            <input type="text" lang="<?php echo lang('shortcode'); ?>" class="form-control" id="month" name="month" placeholder="<?php echo lang('ph_month'); ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-offset-7 col-sm-5">
                        <button type="submit" class="btn btn-lg btn-primary btn-block"><?php echo lang('btn_show'); ?></button>
                    </div>
                </div>
            </form>
