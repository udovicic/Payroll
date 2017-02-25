            <script>//jQuery('#menu-report').addClass('active');</script>
            <script>
                <?php if (lang('shortcode') == 'hr') echo 'Globalize.culture( "hr-HR" );'; ?>
                
                // totals per month
                var summary_t = [
<?php foreach ($summary_t as $month => $value): if ($value == NULL) $value = 0; ?>
                    { month: "<?php echo lang($month); ?>", total: <?php echo $value; ?> },
<?php endforeach; ?>
                ];

                // hour distribution per month
                var summary_h = [
<?php
    foreach ($summary_h as $month => $hours):
        $hr = '';
        foreach ($hours as $key => $value){
            if ($value == NULL) $value = 0;
            $hr .= $key . ':' . $value . ', ';
        }
        ?>
                    { month: "<?php echo lang($month); ?>", <?php echo $hr; ?>},
<?php endforeach; ?>
                ];

                // average per hour
                var summary_a = [
<?php foreach ($summary_a as $month => $avg): ?>
                    { month: "<?php echo lang($month); ?>", avg: <?php echo $avg; ?> },
<?php endforeach; ?>
                ];
            </script>

            <div class="graph-container"><div class="graph" id="chart_totals"></div></div>
            <div class="graph-container"><div class="graph" id="chart_hours"></div></div>
            <div class="graph-container"><div class="graph" id="chart_avg_ph"></div></div>

            <script>
                $("#chart_totals").dxChart({
                    dataSource: summary_t,
                    series: {
                        argumentField: "month",
                        valueField: "total",
                        name: "<?php echo lang('stats_totals_series'); ?>",
                        type: "bar",
                        color: '#6596a1'
                    },
                    legend: { visible: false },
                    title: "<?php echo lang('stats_totals_t'); ?>",
                    tooltip: {
                        enabled: true,
                        customizeText: function () { return this.valueText + ' Kn'; }
                    }
                });

                $("#chart_hours").dxChart({
                    dataSource: summary_h,
                    commonSeriesSettings: {
                        argumentField: "month",
                        type: "fullStackedBar"
                    },
                    series: [
                        { valueField: "day", name: "<?php echo lang('day'); ?>" },
                        { valueField: "night", name: "<?php echo lang('night'); ?>" },
                        { valueField: "sunday", name: "<?php echo lang('sunday'); ?>" },
                        { valueField: "sunday_night", name: "<?php echo lang('sunday_night'); ?>" },
                        { valueField: "holiday", name: "<?php echo lang('holiday'); ?>" },
                        { valueField: "holiday_night", name: "<?php echo lang('holiday_night'); ?>" }
                    ],
                    legend: {
                        verticalAlignment: "top",
                        horizontalAlignment: "center",
                        itemTextPosition: "right"
                    },
                    title: "<?php echo lang('stats_hours_t'); ?>",
                    tooltip: {
                        enabled: true,
                        customizeText: function () {
                            return this.seriesName + " - " + this.percentText;
                        }
                    }
                });

                $("#chart_avg_ph").dxChart({
                    dataSource: summary_a,
                    commonSeriesSettings: {
                        type: "stackedLine",
                        argumentField: "month"
                    },
                    series: [
                        { valueField: "avg", name: "<?php echo lang('stats_avg_series'); ?>" },
                    ],
                    title: "<?php echo lang('stats_avg_t'); ?>",
                    legend: { visible: false },
                    tooltip:{
                        enabled: true,
                        customizeText: function () { return this.valueText + " Kn"; }
                    }
                });
            </script>
<script>
    dataLayer.push({
        'eventCategory' : 'pageview',
        'eventAction'   : 'pageview',
        'eventLabel'    : 'shift-stats',
        'event'         : 'UAevent',
        'eventValue'    : 1
    });
</script>
