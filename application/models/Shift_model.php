<?php
/**
* Shift model
*
* Used in Shift controller
*/
class Shift_model extends CI_Model
{
    /**
    * Insert new record into 'shifts'
    *
    * @param array @info Data to be inserted
    * @return bool True on success
    */
    function save($info)
    {
        if (isset($info['shift_id']) == true) {
            $id = $info['shift_id'];
            unset($info['shift_id']);
            $this->db->where('shift_id', $id);
            $this->db->update('shifts', $info);
        } else {
            $this->db->insert('shifts', $info);
        }

        if ($this->db->affected_rows() == 1) {
            return true;
        }

        return false;
    }

    /**
    * Creates detaild listing of working hours
    *
    * @param array $shift_data Array containing 'date', 'start' and 'end'
    * @return array Detaild hour listing
    */
    function split($shift_data)
    {
        // List of holidays
        $holidays = array(
            "01.01." => "Nova Godina",
            "06.01." => "Bogojavljanje ili Sveta tri kralja",
            "01.05." => "Praznik rada",
            "22.06." => "Dan antifašističke borbe",
            "25.06." => "Dan državnosti",
            "05.08." => "Dan domovinske zahvalnosti",
            "15.08." => "Velika Gospa",
            "08.10." => "Dan neovisnosti",
            "01.11." => "Dan svih svetih",
            "25.12." => "Božić",
            "26.12." => "Sveti Stjepan",
            date("d.m.", easter_date()) => "Uskrs",
            date("d.m.", strtotime('+1 day', easter_date())) => "Uskršnji ponedjeljak",
            date("d.m.", strtotime('+60 days', easter_date())) => "Tijelovo"
        );

        // Beginning and ending timestamp
        $shift = new DateTime($shift_data['date'] . ' ' . $shift_data['start'] . ':00');
        $shift_end = new DateTime($shift_data['date'] . ' ' . $shift_data['end'] . ':00');
        if ($shift >= $shift_end) { // ended on next day
            $shift_end->modify('+1 day');
        }

        // Reset shift details
        $shift_data = array(
            'day' => 0,
            'night' => 0,
            'sunday' => 0,
            'sunday_night' => 0,
            'holiday' => 0,
            'holiday_night' => 0,
        );

        while ($shift < $shift_end) { // iterate through shift
            $hour = intval($shift->format('H')); // grab current hour

            if ($hour < 6 || $hour >= 22) {
                // night hour
                if (array_key_exists($shift->format('d.m.'), $holidays)) {
                    $shift_data['holiday_night']++;
                } else if ($shift->format('N') == '7') {
                    $shift_data['sunday_night']++;
                } else {
                    $shift_data['night']++;
                }
            } else {
                // day hour
                if (array_key_exists($shift->format('d.m.'), $holidays)) {
                    $shift_data['holiday']++;
                } else if ($shift->format('N') == '7') {
                    $shift_data['sunday']++;
                } else {
                    $shift_data['day']++;
                }
            }

            $shift->modify('+1 hour'); // move to next hour
        }

        return $shift_data;  
    }

    /**
    * Retrieve rates from database
    *
    * @param int $rate_id ID of rate in database
    * @return array Rate values from database
    */
    function get_rates($rate_id)
    {
        $query = $this->db->get_where('rates', array('rate_id' => $rate_id));
        
        return $query->row_array();
    }

    /**
     * Calculates total income
     *
     * @param array $user_rate Array returned by get_rates()
     * @param array $shift_data Array returned by split()
     * @return string Number formated to 2 decimal places
     */
    function calculate($user_rate, $shift_data)
    {
        $rates = $this->get_rates($user_rate);

        $total = 0;
        foreach ($shift_data as $key => $value) {
            $total += $rates[$key] * $value;
        }

        return number_format($total, 2);
    }

    /**
    * Generate report
    *
    * @param string $start Starting date or month (optional)
    * @param string $end Report end date (optional)
    * @return array report in form of array
    */
    function generate_report($start, $end, $user_id)
    {
        // parse input
        if ($start == false && $end == false) {
            $start = new DateTime('first day of this month');
            $end = new DateTime('first day of next month');
            $end->modify('-1 day');
        } else if ($start != false && $end == false) {
            $end = new Datetime;
            $start = new DateTime('1.' . $start . '.' . $end->format('Y'));
            $end = clone $start;
            $end->modify('+1 month -1 day');
        } else {
            $start = new DateTime($start);
            $end = new DateTime($end);
        }

        // format date
        $start = $start->format('Y-m-d');
        $end = $end->format('Y-m-d');

        // get shift details
        $this->db->where("`date` BETWEEN '{$start}' AND '{$end}'");
        $this->db->where('user_id_fk', $user_id);
        $this->db->order_by('date', 'asc');
        $query = $this->db->get('shifts');
        $shifts = $query->result_array();

        // get totals
        $this->db->select_sum('total')->select_sum('bonus')
            ->select_sum('day')->select_sum('night')
            ->select_sum('sunday')->select_sum('sunday_night')
            ->select_sum('holiday')->select_sum('holiday_night');
        $this->db->where("`date` BETWEEN '{$start}' AND '{$end}'");
        $this->db->where('user_id_fk', $user_id);
        $query = $this->db->get('shifts');
        $totals = $query->row_array();

        $shifts['total'] = $totals;

        return $shifts;
    }

    /**
    * Delete shift from db
    *
    * @param int $id Shift ID number
    * @return bool True on success, otherwise false
    */
    function delete($shift_id)
    {
        $this->db->where('shift_id', $shift_id);
        $this->db->delete('shifts');

        if ($this->db->affected_rows() == 1) {
            return true;
        }

        return false;
    }

    /**
    * Generate summary of totals for past year
    *
    * @param int $user_id User id in database
    * @return array Month => Total pairs
    */
    function summary_total($user_id)
    {
        $d_start = new Datetime('first day of this month');
        $d_end = clone $d_start;
        $d_end->modify('+1 month -1 day');

        $summary = array();

        for ($i=0; $i < 12; $i++) { 
            // format date
            $start = $d_start->format('Y-m-d');
            $end = $d_end->format('Y-m-d');

            // get from db
            $this->db->select_sum('total');
            $this->db->where('user_id_fk', $user_id);
            $this->db->where("`date` BETWEEN '{$start}' AND '{$end}'");
            $query = $this->db->get('shifts');
            $total = $query->row_array();

            // store in array
            $summary['month_' . $d_start->format('m')] = $total['total'];

            // correct date
            $d_start->modify('-1 month');
            $d_end = clone $d_start;
            $d_end->modify('+1 month -1 day');
        }

        return array_reverse($summary);
    }

    /**
    * Generate summary of averages per hour on monthly basis
    *
    * @param int $user_id User id in database
    * @return array Month => (Hour => sum) pairs
    */
    function summary_hours($user_id)
    {
        $d_start = new Datetime('first day of this month');
        $d_end = clone $d_start;
        $d_end->modify('+1 month -1 day');

        $summary = array();

        for ($i=0; $i < 12; $i++) { 
            // format date
            $start = $d_start->format('Y-m-d');
            $end = $d_end->format('Y-m-d');

            // get from db
            $this->db->select_sum('day')->select_sum('night')
                ->select_sum('sunday')->select_sum('sunday_night')
                ->select_sum('holiday')->select_sum('holiday_night');
            $this->db->where('user_id_fk', $user_id);
            $this->db->where("`date` BETWEEN '{$start}' AND '{$end}'");
            $query = $this->db->get('shifts');
            $total = $query->row_array();

            // store in array
            $summary['month_' . $d_start->format('m')] = $total;

            // correct date
            $d_start->modify('-1 month');
            $d_end = clone $d_start;
            $d_end->modify('+1 month -1 day');
        }

        return array_reverse($summary);
    }

    /**
    * Generate summary of averages per hour on monthly basis
    *
    * @param int $user_id User id in database
    * @param array $sum_total Array returned by summary_total
    * @param array $sum_hour Array returned by summary_hours
    * @return array Month => avg pairs
    */
    function summary_avg_ph($user_id, $sum_total='', $sum_hour='')
    {
        $totals = array();
        $hours = array();
        $summary = array();

        // get totals
        if ($sum_total == '') {
            $totals = $this->summary_total($user_id);
        } else {
            $totals = $sum_total;
        }
        if ($sum_hour == '') {
            $hours = $this->summary_hours($user_id);
        } else {
            $hours = $sum_hour;
        }

        $hour_i = array('day', 'night', 'sunday', 'sunday_night', 'holiday', 'holiday_night');


        // generate sum
        foreach ($totals as $month => $total) {
            $working_h = array_sum($hours[$month]);
            
            if ($working_h > 0) {
                $avg = floatval($total) / floatval($working_h);
            } else {
                $avg = 0;
            }
            $summary[$month] = number_format($avg, 2);
        }

        return $summary;
    }
}
