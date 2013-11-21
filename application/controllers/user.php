<?php
/**
* User management controller
*
* Used for user authorization
*/
class User extends CI_Controller
{

    /**
    * User controller constructor
    */
    function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');

        $this->lang->load('user', $this->session->userdata('language'));
    }
    /**
    * Login attempt
    *
    * Handles input from HTML form, checks records in database.
    * Requires 'username' and 'password' inside $_POST.
    */
    function login($ajax = false)
    {
        // redirect if allready logged in
        if ($this->session->userdata('username') != false) {
            redirect(site_url());
        }

        // check user input
        if ($this->input->post() != false) {

            $user_info = array(
                'username' => $this->input->post('username'),
                'password' => sha1($this->input->post('password'))
            );

            // perform form validation
            $config = array(
                array(
                    'field' => 'username',
                    'label' => lang('ph_username'),
                    'rules' => 'trim|required|max_length[30]|min_length[3]'
                ), array(
                    'field' => 'password',
                    'label' => lang('ph_pwd'),
                    'rules' => 'trim|required|min_length[4]'
                )
            );
            $this->load->library('form_validation');
            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == false) {
                $data['notify'] = validation_errors();
            } else {
                // check database entry
                $user_info = $this->User_model->check_credentials($user_info);
                if ($user_info == false) {
                    $data['notify'] = lang('err_user_pwd');;
                }
            }

            // perform login action
            if (isset($data['notify']) == false) {
                // load data to session
                $this->session->set_userdata($user_info);

                // redirect do default controller/action
                if ($ajax == false) redirect(site_url(), 'location');
            }
        }

        // render view
        $data['title'] = lang('title_sign_in');
        $data['ajax'] = $ajax;
        if ($ajax == false) $this->load->view('user/header', $data);
        $this->load->view('user/login', $data);
        if ($ajax == false) $this->load->view('footer');
    }

    /**
    * Logout action
    *
    * Destroys session data containing user information.
    */
    function logout()
    {
        $this->session->sess_destroy();
        redirect(site_url('/user/login'));
    }

    /**
    * Creates new user
    *
    * Register new user in database.
    * Requires 'username', 'password' and 'email' inside $_POST.
    */
    function register($ajax = false)
    {
        // redirect if allready logged in
        if ($this->session->userdata('username') != false) {
            redirect(site_url());
        }

        if ($this->input->post() != false) {

            $user_info = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => sha1($this->input->post('password'))
            );

            // validate form input
            $config = array(
                array(
                    'field' => 'username',
                    'label' => lang('ph_username'),
                    'rules' => 'trim|required|max_length[30]|min_length[3]|is_unique[users.username]'
                ), array(
                    'field' => 'email',
                    'label' => lang('ph_email'),
                    'rules' => 'trim|required|valid_email|is_unique[users.email]'
                ), array(
                    'field' => 'password',
                    'label' => lang('ph_pwd'),
                    'rules' => 'trim|required|min_length[4]'
                )
            );
            $this->load->library('form_validation');
            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == false) {
                $data['notify'] = validation_errors();
            } else {
                $code = $this->User_model->create($user_info);
                if ($code != false) {
                    $data['notify'] = lang('notify_user_created');

                    // send email notification
                    $msg = sprintf(lang('email_activate_body'), 
                            site_url('/user/activate/'
                                . $code . '/' . $user_info['username']));

                    $this->load->library('email');
                    $this->load->config('email');

                    // send activation code
                    $this->email->from($this->config->item('admin_email'));
                    $this->email->to($user_info['email']);
                    $this->email->subject(lang('email_activate_subject'));
                    $this->email->message($msg);
                    $this->email->send();

                    // send info to admin
                    $msg = sprintf(lang('email_new_user_body'),
                        $user_info['username'], site_url());
                    $this->email->clear();
                    $this->email->from($this->config->item('admin_email'));
                    $this->email->to($this->config->item('admin_email'));
                    $this->email->subject(lang('email_new_user_subject'));
                    $this->email->message($msg);
                    $this->email->send();
                } else {
                    $data['notify'] = lang('err_unknown');
                }
            }
        }

        $data['title'] = lang('title_register');
        $data['ajax'] = $ajax;
        if ($ajax == false) $this->load->view('user/header', $data);
        $this->load->view('user/register', $data);
        if ($ajax == false) $this->load->view('footer');
    }

    /**
    * Activate registerd user
    *
    * @param string @code Activation code from database
    * @param string @username Username
    */
    function activate($code = false, $username = false)
    {
        // redirect if allready logged in
        if ($this->session->userdata('username') != false) {
            redirect(site_url());
        }

        if ($code == false || $username == false) {
            redirect(site_url('/user/register'));
        }

        $user_info = array(
            'code' => $code,
            'username' => $username
        );

        $this->User_model->activate($user_info);
        redirect(site_url('/user/login'));
    }

    /**
    * Reset user password
    *
    * Sends generated password to users email.
    * Requires 'email' inside $_POST.
    */
    function reset($ajax = false)
    {
        // redirect if allready logged in
        if ($this->session->userdata('username') != false) {
            redirect(site_url());
        }
        
        if ($this->input->post() != false) {

            $user_info = array(
                'email' => $this->input->post('email')
            );

            // validate form input
            $config = array(
                array(
                    'field' => 'email',
                    'label' => lang('ph_email'),
                    'rules' => 'trim|required|valid_email'
                )
            );
            $this->load->library('form_validation');
            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == false) {
                $data['notify'] = validation_errors();
            } else {
                // execute password reset
                $pwd = $this->User_model->reset_pwd($user_info);

                if ($pwd == false) {
                    // email not in database
                    $data['notify'] = lang('err_unknown_email');
                } else {
                    // send email notification
                    $msg = sprintf(lang('email_reset_body'),
                            $pwd,
                            site_url('user/login'));

                    $this->load->library('email');
                    $this->load->config('email');  

                    $this->email->from($this->config->item('admin_email'));
                    $this->email->to($user_info['email']);
                    $this->email->subject(lang('email_reset_subject'));
                    $this->email->message($msg);
                    $this->email->send();

                    $data['notify'] = lang('notify_pwd_reset');
                }
            }
        }

        // render view
        $data['title'] = lang('title_reset');
        $data['ajax'] = $ajax;
        if ($ajax == false) $this->load->view('user/header', $data);
        $this->load->view('user/reset', $data);
        if ($ajax == false) $this->load->view('footer');
    }

    /**
    * User profile editor
    *
    * Edit user data
    */
    function profile()
    {
        // require user to be logged in
        if ($this->session->userdata('username') == false) {
            redirect('user/login');
        }

        $this->lang->load('shift', $this->session->userdata('language'));

        // parse input
        if ($this->input->post() != false) {
            $user_info = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'language' => $this->input->post('language'),
                'rate_id_fk' => $this->input->post('rate')
            );

            // validate form input
            $config = array(
                array(
                    'field' => 'username',
                    'label' => lang('ph_username'),
                    'rules' => 'trim|required|max_length[30]|min_length[3]'
                ), array(
                    'field' => 'email',
                    'label' => lang('ph_email'),
                    'rules' => 'trim|required|valid_email'
                ), array(
                    'field' => 'password',
                    'label' => lang('ph_password'),
                    'rules' => 'trim|min_length[4]'
                ), array(
                    'field' => 'language',
                    'label' => lang('ph_language'),
                    'rules' => 'required'
                ), array(
                    'field' => 'rate',
                    'label' => lang('ph_rate'),
                    'rules' => 'required'
                )
            );
            $this->load->library('form_validation');
            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == false) {
                $data['notify'] = validation_errors();
            } else {
                // remove password from array if not set 
                if ($user_info['password'] == false) {
                    unset($user_info['password']);
                } else {
                    $user_info['password'] = sha1($user_info['password']);
                }

                $user_id = $this->session->userdata('user_id');
                $user_info = $this->User_model->update_profile($user_id, $user_info);

                if ($user_info != false) {
                    // reload session data with new info
                    $this->session->set_userdata($user_info);
                    
                    // refresh to reload language files
                    redirect('/user/profile');
                } else {
                    $data['notify'] = lang('err_unknown');
                }
            }
        }

        // grab current language
        if ($this->session->userdata('language') == 'croatian') {
            $data['sel_lang'] = 'hr';
        } else {
            $data['sel_lang'] = 'en';
        }

        // render view
        $data['title'] = lang('title_profile');
        $data['username'] = $this->session->userdata('username');
        $data['email'] = $this->session->userdata('email');
        $data['rate_id'] = $this->session->userdata('rate_id_fk');
        $data['rates'] = $this->User_model->get_rate_list();

        $this->load->view('header', $data);
        $this->load->view('user/profile', $data);
        $this->load->view('footer');
    }

    /**
    * Delete user account
    */
    function delete()
    {
        // TODO: Write this function
    }
}
