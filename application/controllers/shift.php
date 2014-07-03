<?php
/**
* Shift management controller
*/
class Shift extends CI_Controller
{
    /**
    * Constructor
    *
    * Requires user to be logged in
    */
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('username') == false) {
            redirect('/user/login');
        }

        $this->lang->load('shift', $this->session->userdata('language'));
    }

    /**
    * Add shift action
    *
    * Add or update shift.
    * Requires 'start' and 'end' or 'bonus' and 'date', 'note' in $_POST
    * If 'shift_id' is set in $_POST it preforms db update
    */
    function add($ajax = false)
    {
        if ($this->input->post() != false) {

            // grab user input
            $shift_info = array(
                'shift_id' => $this->input->post('shift_id'),
                'date' => $this->input->post('date'),
                'start' => $this->input->post('start'),
                'end' => $this->input->post('end'),
                'bonus' => $this->input->post('bonus'),
                'note' => $this->input->post('note')
            );
            if ($shift_info['shift_id'] == false) {
                unset($shift_info['shift_id']);
            }

            // validate input
            if ($shift_info['date'] == false) {
                $data['notify'] = 'Date must be set';
            } else {
                $date = new DateTime($shift_info['date']);
                $shift_info['date'] = $date->format('Y-m-d');
            }
            $using_hours = ($shift_info['start'] != false
                && $shift_info['end'] != false) ? true : false;
            $using_bonus = ($shift_info['bonus'] != false) ? true : false;
            if ($using_hours == false && $using_bonus == false) {
                $data['notify'] = 'Set working hours or bonus';
            }

            // save shift info
            if (isset($data['notify']) == false) {
                $this->load->model('Shift_model');
                $shift_info['user_id_fk'] = $this->session->userdata('user_id');

                // bonus only
                if ($using_bonus == true) {
                    unset($shift_info['start']);
                    unset($shift_info['end']);
                    $shift_info['total'] = $shift_info['bonus'];

                    if ($this->Shift_model->save($shift_info) == false) {
                        $data['notify'] = 'Something went wrong';
                    } else {
                        $data['details'] = array('bonus' => $shift_info['bonus']);
                        $data['total'] = $shift_info['total'];
                        $data['note'] = $shift_info['note'];
                    }
                } else {
                    // using hours
                    unset($shift_info['bonus']);
                    $shift_details = $this->Shift_model->split($shift_info);
                    $total = $this->Shift_model->calculate(
                        $this->session->userdata('rate_id_fk'),
                        $shift_details);

                    $shift_info = array_merge($shift_info, $shift_details);
                    $shift_info['total'] = $total;
                    if ($this->Shift_model->save($shift_info) == false) {
                        $data['notify'] = 'Something went wrong';
                    } else {
                        $data['details'] = $shift_details;
                        $data['total'] = $total;
                        $data['note'] = $shift_info['note'];
                    }
                }
            }

            if (isset($shift_info['shift_id']) == true) {
                $url = $_SERVER['HTTP_REFERER']; // Ugly
                $url = str_replace($this->config->item('base_url'), '', $url);
                redirect($url);
            }

        }

        $data['canonical'] = 'shift/add';
        $data['title'] = 'Add shift';
        $data['ajax'] = $ajax;
        $data['username'] = $this->session->userdata('username');
        if ($ajax == false) $this->load->view('header', $data);
        $this->load->view('shift/add', $data);
        if ($ajax == false) $this->load->view('footer');
    }

    /**
    * Select period for report
    *
    * @param string $target Which action should be called afterwards
    * @param bool $ajax Render output without header and footer for ajax calls
    */
    function report_period($target, $ajax = false)
    {
        // generate report
        if ($this->input->post() != false) {
            $month = $this->input->post('month');
            redirect('/shift/report/' . $month);
        }

        // render view
        $data['canonical'] = 'shift/report';
        $data['title'] = lang('title_report_period');
        $data['username'] = $this->session->userdata('username');
        $data['target'] = $target;
        if ($ajax == false) $this->load->view('header', $data);
        $this->load->view('shift/period_select', $data);
        if ($ajax == false) $this->load->view('footer');
    }

    /**
    * PDF version of report()
    *
    * @param string $start Starting date or month (optional)
    * @param string $end Report end date (optional)
    */
    function pdf($start = false, $end = false)
    {
        // create report
        $this->load->model('Shift_model');
        $report = $this->Shift_model->generate_report(
            $start, $end,$this->session->userdata('user_id'));

        // render view
        $data['title'] = lang('title_report');;
        $data['username'] = $this->session->userdata('username');
        $data['report'] = $report;

        $html = $this->load->view('shift/pdf', $data, true);
        $this->load->helper('dompdf');
        pdf_create($html, '', true);
    }

    /**
    * Display shift summary
    *
    * @param string $start Starting date or month (optional)
    * @param string $end Report end date (optional)
    */
    function report($start = false, $end = false)
    {
        // create report
        $this->load->model('Shift_model');
        $report = $this->Shift_model->generate_report(
            $start, $end,$this->session->userdata('user_id'));

        // render view
        $data['canonical'] = 'shift/report';
        $data['title'] = lang('title_report');;
        $data['username'] = $this->session->userdata('username');
        $data['report'] = $report;
        $this->load->view('header', $data);
        $this->load->view('shift/report', $data);
        $this->load->view('footer');
    }

    /**
    * Delete shift
    *
    * Requires 'shift_id' in post
    */
    function delete()
    {
        if ($this->input->post() != false) {
            $id = $this->input->post('shift_id');

            if ($id != false) {
                $this->load->model('Shift_model');
                $this->Shift_model->delete($id);
            }
        }

        $url = $_SERVER['HTTP_REFERER']; // Ugly
        $url = str_replace($this->config->item('base_url'), '', $url);
        redirect($url);
    }

    /**
    * Display shift and user statistics
    */
    function stats()
    {
        $this->load->model('Shift_model');

        // grab data
        $id = $this->session->userdata('user_id');
        $data['summary_t'] = $this->Shift_model->summary_total($id);
        $data['summary_h'] = $this->Shift_model->summary_hours($id);
        $data['summary_a'] = $this->Shift_model->summary_avg_ph($id);

        // render view
        $data['canonical'] = 'shift/stats';
        $data['title'] = lang('title_report');;
        $data['username'] = $this->session->userdata('username');
        $this->load->view('header', $data);
        $this->load->view('shift/stats', $data);
        $this->load->view('footer');
    }
}
