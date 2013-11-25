<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Satnica</title>
    <style>
        body {
            font-size: 10pt;
        }
        table {
            text-align: center;
            border: 0;
        }
        td, th {
            padding: 5px;
        }

        .stamp {
            position: absolute;
            bottom: 0;
            left: 0;
            padding: 0 0 5px 5px;
            font-style: italic;
            font-size: 12px;
        }
        
        .hl { background-color: #dddddd; }
        .bt { border-top: 1px solid #888888; }
        .bb { border-bottom: 1px solid #888888; }
        .ct { text-align: center; }
    </style>
</head>
<body>
<?php 
    $heads = array('date', 'time', 'total', 'bonus',
        'day', 'night', 'sunday',
        'sunday_night', 'holiday', 'holiday_night');
    $this->load->helper('string');
?>
    <table cellspacing="0" >
        <tr>
<?php foreach ($heads as $key): ?>
            <th class="bb"><?php echo lang($key); ?></th>
<?php endforeach; ?>
        </tr>
<?php
    foreach($report as $type => $day):
        if (is_string($type) == false):
            $d = new DateTime($day['date']);
            $day['date'] = $d->format('d.m.');
            $day['time'] = $day['start'] . ' - ' . $day['end'];
            $class = alternator('', 'hl');
?>
        <tr>
<?php   foreach ($heads as $key): ?>
            <td class="<?php echo $class; ?>"><?php echo ($day[$key] == 0)? '-' : $day[$key]; ?></td>
<?php   endforeach; ?>
        </tr>
<?php
        endif;
    endforeach;
?>
        <tr>
<?php foreach ($heads as $key): ?>
            <th class="bt"><?php echo lang($key); ?></th>
<?php endforeach; ?>
        </tr>
        <tr>
<?php 
    $totals = $report['total'];
    foreach ($heads as $key):
?>
            <th class="bt"><?php if(isset($totals[$key]) == true) echo ($totals[$key] == 0 || $key == 'bonus')? '-' : $totals[$key]; ?></th>
<?php endforeach; ?>
        </tr>
    </table>
    <span class="stamp"><?php echo lang('generated_by') . base_url(); ?></span>
</body>
</html>
