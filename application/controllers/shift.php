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
    * Adds new shift. Requires 'date', 'start', 'end' and 'note' in $_POST
    */
    function add()
    {
        if ($this->input->post() != false) {

            // grab user input
            $shift_info = array(
                'date' => $this->input->post('date'),
                'start' => $this->input->post('start'),
                'end' => $this->input->post('end'),
                'bonus' => $this->input->post('bonus'),
                'note' => $this->input->post('note')
            );

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
                $shift_info['user_id'] = $this->session->userdata('user_id');

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

        }

        $data['title'] = 'Add shift';
        $data['username'] = $this->session->userdata('username');
        $this->load->view('shift/header', $data);
        $this->load->view('shift/add', $data);
        $this->load->view('shift/footer');
    }

    /**
    * Display shift summary
    *
    * @param string $start Starting date or month (optional)
    * @param string $end Report end date (optional)
    */
    function report($start = false, $end = false)
    {
        // render view
        $data['title'] = 'Report';
        $data['username'] = $this->session->userdata('username');
        $this->load->view('shift/header', $data);
        $this->load->view('shift/report');
        $this->load->view('shift/footer');
    }
}
