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
    }
    /**
    * Login attempt
    *
    * Handles input from HTML form, checks records in database.
    * Requires 'username' and 'password' inside $_POST.
    */
    function login()
    {
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
                    'label' => 'Username',
                    'rules' => 'trim|required|max_length[30]|min_length[3]'
                ), array(
                    'field' => 'password',
                    'label' => 'Password',
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
                	$data['notify'] = 'Wrong username or password';
                }
            }

            // perform login action
            if (isset($data['notify']) == false) {
                $this->session->set_userdata($user_info);
                redirect(site_url()); // redirect do default controller/action
            }
        }

        // render view
        $data['title'] = 'Login';
        $this->load->view('user/header', $data);
        $this->load->view('user/login', $data);
        $this->load->view('user/footer');
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
    function register()
    {
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
                    'label' => 'Username',
                    'rules' => 'trim|required|max_length[30]|min_length[3]|is_unique[users.username]'
                ), array(
                	'field' => 'email',
                	'label' => 'Email',
                	'rules' => 'trim|required|valid_email|is_unique[users.email]'
                ), array(
                    'field' => 'password',
                    'label' => 'Password',
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
    				$data['notify'] = 'User account has been created. '
    					. 'Check your email for activation code';

    				// send email notification
                    $msg = 'Activate your account by visiting this link: '
                    		. site_url('/user/activate/'
                    			. $code . '/'
                    			. $user_info['username']);

                    $this->load->library('email');

                    $this->email->from('system@payroll');
                    $this->email->to($user_info['email']);
                    $this->email->subject('User activation');
                    $this->email->message($msg);
                    $this->email->send();
    			} else {
    				$data['notify'] = 'Something went wrong';
    			}
    		}
    	}

        $data['title'] = 'Register new account';
        $this->load->view('user/header', $data);
        $this->load->view('user/register');
        $this->load->view('user/footer');
    }

    /**
    * Activate registerd user
    *
    * @param string @code Activation code from database
    * @param string @username Username
    */
    function activate($code = false, $username = false)
    {
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
    function reset()
    {
        if ($this->input->post() != false) {

            $user_info = array(
                'email' => $this->input->post('email')
            );

            // validate form input
            $config = array(
                array(
                    'field' => 'email',
                    'label' => 'Email',
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
                    $data['notify'] = 'Unknown email address';
                } else {
                    // send email notification
                    $msg = 'Your new password is: '
                    		. $pwd . '. You can login at '
                    		. site_url('user/login');

                    $this->load->library('email');

                    $this->email->from('system@payroll');
                    $this->email->to($user_info['email']);
                    $this->email->subject('Password reset');
                    $this->email->message($msg);
                    $this->email->send();
                }
            }
        }

        // render view
        $data['title'] = 'Password reset';
        $this->load->view('user/header', $data);
        $this->load->view('user/reset', $data);
        $this->load->view('user/footer');
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

        // parse input
        if ($this->input->post()) {
            $user_info = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'rate_id_fk' => $this->input->post('rate')
            );

            // validate form input
            $config = array(
                array(
                    'field' => 'username',
                    'label' => 'Username',
                    'rules' => 'trim|required|max_length[30]|min_length[3]'
                ), array(
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'trim|required|valid_email'
                ), array(
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'trim|min_length[4]'
                ), array(
                    'field' => 'rate',
                    'label' => 'Rate',
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
                    $this->session->set_userdata($user_info);
                } else {
                    $data['notify'] = 'Profile update failed';
                }
            }
        }

        // render view
        $data['title'] = 'User profile';
        $data['username'] = $this->session->userdata('username');
        $data['email'] = $this->session->userdata('email');
        $data['rate_id'] = $this->session->userdata('rate_id_fk');
        $data['rates'] = $this->User_model->get_rate_list();

        $this->load->view('shift/header', $data);
        $this->load->view('user/profile', $data);
        $this->load->view('shift/footer');
    }
}
