<?php if ($ajax == false): ?>
            <script>jQuery('#menu-add').addClass('active');</script>
            <form id="form-shift-add" class="shift" role="form" action="<?php echo base_url(); ?>shift/add" method="post">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            <input type="text" class="form-control" lang="<?php echo lang('shortcode'); ?>" id="date" name="date" placeholder="<?php echo lang('ph_date'); ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group row">        
                    <div class="col-sm-4">
                        <div class="input-group multiple-form-row">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-step-backward"></span></span>
                            <input type="text" class="form-control" lang="<?php echo lang('shortcode'); ?>" id="start" name="start" placeholder="<?php echo lang('ph_start'); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group multiple-form-row">
                            <input type="text" class="form-control" lang="<?php echo lang('shortcode'); ?>" id="end" name="end" placeholder="<?php echo lang('ph_end'); ?>" readonly>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-step-forward"></span></span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group multiple-form-row">
                            <input type="text" class="form-control" lang="<?php echo lang('shortcode'); ?>" id="bonus" name="bonus" placeholder="<?php echo lang('ph_bonus'); ?>">
                            <span class="input-group-addon">Kn</span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                            <input type="text" class="form-control" id="note" name="note" placeholder="<?php echo lang('ph_note'); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-offset-7 col-sm-5">
                        <button type="submit" class="btn btn-lg btn-primary btn-block"><?php echo lang('btn_add'); ?></button>
                    </div>
                </div>
<?php endif; ?>
                <div id="result">
<?php if (isset($notify)): ?>
                    <div class="alert alert-danger text-center"><?php echo $notify; ?></div>
<?php endif; ?>
<?php if (isset($details)): ?>
                    <div class="panel panel-default">
                        <div class="panel-heading"><?php echo lang('lbl_details'); ?></div>
                        <div class="panel-body">
                            <ul class="list-group">
<?php
    foreach ($details as $key => $value):
        if ($value != 0):
?>
                                <li class="list-group-item">
                                    <span class="badge"><?php echo $value; ?></span>
                                    <?php echo lang($key); ?>
                                </li>
<?php   endif; 
    endforeach;
?>
                            </ul>
                            <p><strong><em><?php echo lang('lbl_total'); ?>:</em> <span class="text-success"><?php echo $total ?> Kn</span></strong></p>
<?php if ($note != false): ?>
                         <p><strong><em><?php echo lang('lbl_note'); ?>:</em> <span class="text-warning"><?php echo $note; ?></span></strong></p>
<?php endif; ?>
                        </div>
                    </div>
                </div>
<?php endif; ?>
<?php if ($ajax == false): ?>
            </form>
<?php endif; ?>
