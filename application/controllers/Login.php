<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('auth/login');
	}
    public function Validate()
    {
        $this->form_validation->set_rules('username','Username','trim|required');
        $this->form_validation->set_rules('password','Password','trim|required');

        if($this->form_validation->run()==true)
        {
            //Success
            $username = $this->input->post('username');
            $admin = $this->admin_model->getByUsername($username);
           
            if(!empty($admin))
            {
                $password = $this->input->post('password');
                if(password_verify($password,$admin['password'])==true)
                {
                    $adminArray['admin_id'] = $admin['id'];
                    $adminArray['username'] = $admin['username'];
                    $this->session->set_userdata('admin',$adminArray);
                        $Sessions = array(
                        'MUserId' =>  $admin['id'],
                        'MEmail' => $admin['username'],
                        'MName' => $admin['name'],
                        'MContact' => $admin['contact'],
                        'MLogo' => $admin['logo'],
                        'MLogin' => true);
                    $this->session->set_userdata($Sessions);
                    redirect(base_url('dashboard'));
                }
                else
                {
                    $this->session->set_flashdata('msg','Either email or password is incorrect');
                    redirect(base_url().'login/index');
                }
            }
            else
            {
                $this->session->set_flashdata('msg','Either email or password is incorrect');
                redirect(base_url().'login/index');
            }
        }
        else
        {
            // Form Error
            $this->load->view('login/index');
        }
    }
    function logout()
    {
        unset($this->session->MLogin);
		session_destroy();
        redirect(base_url().'login/index');
    }
}
