        <script>jQuery('#menu-report').addClass('active');</script>
        <div class="container">            
            <div class="panel shift-list-panel">
                <div class="panel-heading"><?php echo lang('title_report'); ?></div>
                <div class="panel-body">
                    <table id="shift-list" class="table table-hover table-condensed shift-list">
                        <tbody>
<?php
    foreach ($report as $key => $shift):
        if ($key != 'total'):
            $date = new DateTime($shift['date']);
?>
                            <tr class="data" id="<?php echo $shift['shift_id']; ?>">
                                <td class="date text-center"><?php echo $date->format('d.m.Y'); ?></td>
<?php       if ($shift['start'] == '0' && $shift['end'] == '0'): ?>                                
                                <td class="time"></td>
<?php       else: ?>
                                <td class="time"><?php echo $shift['start']; ?> - <?php echo $shift['end']; ?></td>
<?php       endif; ?>
                                <td class="total hidden-xs"><?php echo $shift['total']; ?>Kn</td>
                                <td class="edit"><span class="edit"></span></td>
                                <td class="delete"><span class="delete"></span></td>
                            </tr>
                            <tr class="details">
                                <td colspan="5">
                                    <ul>
                                        <li class="visible-xs">
                                            <span class="title"><?php echo lang('lbl_total'); ?>:</span>
                                            <span class="value"><?php echo $shift['total']; ?>Kn</span>
                                        </li>
<?php 
            $keys = array('bonus', 'day', 'night',
                'sunday', 'sunday_night', 'holiday', 'holiday_night');
            foreach ($keys as $key): 
                if ($shift[$key] != 0):
?>
                                        <li class="<?php echo $key; ?>">
                                            <span class="title"><?php echo lang($key); ?>:</span>
                                            <span class="value"><?php echo $shift[$key]; ?></span>
                                        </li>
<?php 
                endif;
            endforeach; // END details loop
            if ($shift['note'] != ''):
?>
                                        <li class="comment">
                                            <span class="title"><?php echo lang('lbl_note'); ?>:</span>
                                            <span class="value"><?php echo $shift['note']; ?></span>
                                        </li>
<?php
            endif;
?>
                                    </ul>
                                </td>
                            </tr>
<?php
        endif;
    endforeach; // END main loop
?>
                        </tbody>
                        <tfoot>
<?php $total = $report['total']; ?>
                            <tr class="data">
                                <th colspan="2" class="total"><?php echo lang('lbl_total'); ?>:</th>
                                <th colspan="3" class="total"><?php echo $total['total']; ?>Kn</th>
                            </tr>
                            <tr class="details">
                                <td colspan="5">
                                    <ul>
<?php 
    $keys = array('bonus', 'day', 'night',
        'sunday', 'sunday_night', 'holiday', 'holiday_night');
    foreach ($keys as $key): 
        if ($total[$key] != 0):
?>
                                        <li>
                                            <span class="title"><?php echo lang($key); ?>:</span>
                                            <span class="value"><?php echo $total[$key]; ?></span>
                                        </li>
<?php 
        endif;
    endforeach;
?>
                                    </ul>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- dialog -->
        <div class="modal fade" id="edit">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-horizontal" role="form" action="<?php echo site_url('/shift/add/'); ?>" method="post" id="form-edit">
                        <input type="hidden" id="shift_id" name="shift_id" value="">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title"><?php echo lang('dlg_edit_title'); ?></h4>
                        </div>
                        <div class="modal-body">
                             <div class="form-group row">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                        <input type="text" class="form-control" id="date" name="date" placeholder="<?php echo lang('ph_date'); ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">        
                                <div class="col-sm-4">
                                    <div class="input-group multiple-form-row">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-step-backward"></span></span>
                                        <input type="text" class="form-control" id="start" name="start" placeholder="<?php echo lang('ph_start'); ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group multiple-form-row">
                                        <input type="text" class="form-control" id="end" name="end" placeholder="<?php echo lang('ph_end'); ?>" readonly>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-step-forward"></span></span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group multiple-form-row">
                                        <input type="text" class="form-control" id="bonus" name="bonus" placeholder="<?php echo lang('ph_bonus'); ?>">
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
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('dlg_btn_close'); ?></button>
                            <button type="submit" class="btn btn-warning"><?php echo lang('dlg_btn_save'); ?></button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <div class="modal fade" id="delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="form-horizontal" role="form" action="<?php echo site_url('/shift/delete/'); ?>" method="post" id="form-delete">
                        <input type="hidden" id="shift_id" name="shift_id" value="">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title"><?php echo lang('dlg_delete_title'); ?></h4>
                        </div>
                        <div class="modal-body">
                            <p><?php echo lang('dlg_delete_msg'); ?><span class="date"></span> (<span class="total"></span>)?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('dlg_btn_close'); ?></button>
                            <button type="submit" class="btn btn-danger"><?php echo lang('dlg_btn_delete'); ?></button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
