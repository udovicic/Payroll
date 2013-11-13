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
    }

    /**
    * Add shift action
    *
    * Adds new shift. Requires 'date', 'start', 'end' and 'note' in $_POST
    */
    function add()
    {
        $data['title'] = 'Add shift';
        $data['username'] = $this->session->userdata('username');
        $this->load->view('shift/header', $data);
        $this->load->view('shift/add');
        $this->load->view('shift/footer');
    }

    /**
    * Display shift summary
    *
    * @param string $start Starting date or month (required)
    * @param string $end Report end date. Optional
    */
    function report()
    {
        // render view
        $data['title'] = 'Report';
        $data['username'] = $this->session->userdata('username');
        $this->load->view('shift/header', $data);
        $this->load->view('shift/report');
        $this->load->view('shift/footer');
    }
}
