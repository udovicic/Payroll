            <script>jQuery('#menu-add').addClass('active');</script>
            <form class="shift" role="form" action="<?php echo base_url(); ?>shift/add" method="post">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            <input type="text" class="form-control" id="date" name="date" placeholder="Datum" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group row">        
                    <div class="col-sm-4">
                        <div class="input-group multiple-form-row">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-step-backward"></span></span>
                            <input type="text" class="form-control" id="start" name="start" placeholder="Početak" readonly>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group multiple-form-row">
                            <input type="text" class="form-control" id="end" name="end" placeholder="Kraj" readonly>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-step-forward"></span></span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group multiple-form-row">
                            <input type="text" class="form-control" id="bonus" name="bonus" placeholder="Bonus">
                            <span class="input-group-addon">Kn</span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                            <input type="text" class="form-control" id="note" name="note" placeholder="Komentar">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-offset-7 col-sm-5">
                        <button type="submit" class="btn btn-lg btn-primary btn-block">Spremi</button>
                    </div>
                </div>
<?php if (isset($notify)): ?>
                <div class="alert alert-danger text-center"><?php echo $notify; ?></div>
<?php endif; ?>
<?php if (isset($details)): ?>
                <div class="panel panel-default">
                    <div class="panel-heading">Details</div>
                    <div class="panel-body">
                        <ul class="list-group">
<?php
    $translate = array(
        'day' => 'Day',
        'night' => 'Night',
        'sunday' => 'Sunday',
        'sunday_night' => 'Sunday night',
        'holiday' => 'Holiday',
        'holiday_night' => 'Holiday night',
        'bonus' => 'Bonus'
    );
    foreach ($details as $key => $value):
        if ($value != 0):
?>
                            <li class="list-group-item">
                                <span class="badge"><?php echo $value; ?></span>
                                <?php echo $translate[$key]; ?>
                            </li>
<?php endif; endforeach; ?>
                        </ul>
                        <p><strong><em>Total:</em> <span class="text-success"><?php echo $total ?> Kn</span></strong></p>
<?php if ($note != false): ?>
                        <p><strong><em>Note:</em> <span class="text-warning"><?php echo $note; ?></span></strong></p>
<?php endif; ?>
                    </div>
                </div>
<?php endif; ?>
            </form>
