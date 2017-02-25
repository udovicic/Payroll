<?php if(isset($success)): ?>
    <div class="alert alert-success text-center"><?php echo $success; ?></div>
<?php else: ?>
<form action="<?php echo base_url(); ?>user/feedback" role="form" class="form-horizontal feedback" method="post">
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
                <span class="input-group-addon"><span class="glyphicon glyphicon glyphicon-pencil"></span></span>
                <textarea name="comment" id="comment" class="form-control" rows="10" placeholder="<?php echo lang('ph_comment'); ?>"></textarea>
            </div>
        </div>
    </div>
    <?php if (isset($notify)): ?>
        <div class="alert alert-danger text-center"><?php echo $notify; ?></div>
    <?php endif; ?>
    <div class="form-group row">
        <div class="col-sm-offset-3 col-sm-5">
            <button type="submit" class="btn btn-lg btn-success btn-block"><?php echo lang('btn_submit'); ?></button>
        </div>
    </div>
</form>
<?php endif ?>
<div class="alert alert-warning text-justify"><b><?php echo lang('feedback_note_start') ?></b><?php echo lang('feedback_note_body') ?></div>
    <script>
    dataLayer.push({
        'eventCategory' : 'pageview',
        'eventAction'   : 'pageview',
<?php if(isset($success)): ?>
        'eventLabel'    : 'user-feedback',
<?php else: ?>
        'eventLabel'    : 'user-feedback-submitted,
<?php endif ?>
        'event'         : 'UAevent',
        'eventValue'    : 1
    });
</script>
<?php if(isset($success)): ?>
<a class="pull-right" href="<?php echo base_url(); ?>" class="text-center bottom-text"><?php echo lang('lbl_return'); ?></a>
<?php endif ?>
