<?php
/**
* Database model for user management
*
* Used in User controller
*/
class User_model extends CI_Model
{
	/**
	* Check user data in database
	*
	* @param array $user_data Array containing 'username' and hashed 'password'.
	* @return mixed Array containing sser data on success, otherwise false.
	*/
    function check_credentials($user_data)
    {
        $user_data['active'] = 1;
        $query = $this->db->get_where('users', $user_data);
        
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }

        return false;
    }

    /**
    * Write new account to databse
    *
    * @param array @user_data Array containing 'username', 'email' and 'password'
    * @return mixed Activation code on success, otherwise false
    */
    function create($user_data)
    {
    	$this->load->helper('string');
    	$user_data['active'] = 0;
    	$user_data['code'] = random_string('alnum', 10);
    	$this->db->insert('users', $user_data);

 		if ($this->db->affected_rows() == 1) {
            return $user_data['code'];
        }

        return false;
    }

    /**
    * Activate user
    *
    * @param array @user_data Arry containing 'username' and 'code'
    * @return bool True on success, false otherwise
    */
	function activate($user_data)
	{
		$this->db->where($user_data);
		$this->db->update('users', array('active' => 1));

		if ($this->db->affected_rows() == 1) {
			return true;
		}

		return false;
	}

    /**
    * Password generation and update in database
    *
    * @param array $user_data Array with 'email' field.
    * @return mixed Password string on success, otherwise false.
    */
    function reset_pwd($user_data)
    {
        $this->load->helper('string');
        $pwd = random_string('alnum', 10);
        $info = array(
            'password' => sha1($pwd)
        );

        $this->db->where($user_data);
        $this->db->update('users', $info);

        if ($this->db->affected_rows() == 1) {
            return $pwd;
        }

        return false;
    }
}
