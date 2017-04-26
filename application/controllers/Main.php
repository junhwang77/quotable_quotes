<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler();
	}
    public function index()
    {
        $this->load->helper(array('form', 'url'));
        if(isset($this->session->userdata['logged_in'])){
			session_destroy();
		}
        $this->load->view('index');
    }
    public function login()
    {
        $email = $this->input->post('email');
        $this->load->model('User');
        $user = $this->User->get_user_by_email($email);
        $password = md5($this->input->post('login_pass').''.            $user['salt']);
        if ($user && $user['password'] == $password)
        {
            $logged_in = array(
                'log_id' => $user['id'],
                'email' => $user['email'],
                'alias' => $user['alias'],
                'is_logged_in' => true
            );
            $this->session->set_userdata('logged_in', $logged_in);
            redirect('/quotes');
        }
        else
        {
            $this->session->set_flashdata("login", "Invalid username or password");
            redirect(base_url());
        }
    }
    public function validate()
    {
		$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('alias', 'Alias', 'required|is_unique[users.alias]', array('is_unique' => '%s is already being used.'));
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]', array('is_unique' => '%s is already being used.'));
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]', array('required' => 'You must provide a %s.'));
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');
		$this->form_validation->set_rules('date_birth', 'Date of Birth ', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('index');
        }
        else
        {
            $this->register();
            redirect(base_url());
        }
    }
    public function register()
    {
        $this->load->model('User');
		$name = $this->input->post('name');
        $alias = $this->input->post('alias');
		$email = $this->input->post('email');
		$date_birth = $this->input->post('date_birth');
        $salt = bin2hex(openssl_random_pseudo_bytes(22));
        $password = md5($this->input->post('password').''.$salt);
        $user_info = array(
            "name" => $name,
            "alias" => $alias,
			"email" => $email,
            "password" => $password,
            "salt" => $salt,
			"date_birth" => $date_birth
        );
        $this->User->add_user($user_info);
        $this->session->set_flashdata('registration', 'Registration successful!');
    }
}
