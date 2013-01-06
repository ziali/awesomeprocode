<?php
class Find extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
        $this->load->library('authlib');
        $this->load->helper('url');
		$this->load->model('user');
    }
	
	public function index()
	{
		//$this->load->view('normal_search'); // url helper function
		$loggedin = $this->authlib->is_loggedin();
		if ($loggedin === false)
		{
			$this->load->view('normal_search');
		}
		else
		{
			$this->load->view('homepage');
		}
	}
	
	public function login()
	{
		$data['errmsg'] = '';
		$this->load->view('login_form',$data);
	}
 
	public function authenticate()
	{
		$username = $this->input->get('uname');
		$password = $this->input->get('pword');
		$user = $this->authlib->login($username,$password);
		if ($user !== false) 
		{
			$this->load->view('homepage',array('name' => $user['name']));
		}
		else 
		{
			$data['errmsg'] = 'Unable to login - please try again';
			$this->load->view('login_form',$data);
		}
 
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		$data['logout_message'] = 'Successfully logged out';
		$this->load->view('normal_search');
	}
	//search_admin returns the usual employee json object literal along with the date of birth of the employee
	//to help find the date of birth when you want to delete an employee.
	public function findemp_admin()
	{
		$firstname = $this->input->get('FIRSTNAME');
		$lastname = $this->input->get('LASTNAME');
		$dept = $this->input->get('DEPT');
		$jobtitle = $this->input->get('JOBTITLE');
		
		$employees = $this->user->search_admin($firstname,$lastname,$dept,$jobtitle);
		echo json_encode($employees);
	}
 
	public function findemp()
	{
		$firstname = $this->input->get('firstname');
		$lastname = $this->input->get('lastname');
		$dept = $this->input->get('dept');
		$jobtitle = $this->input->get('jobtitle');
		
		$employees = $this->user->search($firstname,$lastname,$dept,$jobtitle);
		echo json_encode($employees);
		
	}
	
	public function addemp()
	{
		$firstname = $this->input->get('firstnameadd');
		$lastname = $this->input->get('lastnameadd');
		$jobtitle = $this->input->get('jobtitleadd');
		$dept = $this->input->get('deptadd');
		$gender = $this->input->get('gender');
		$date_of_birth = $this->input->get('dateofbirth_add');
		$hiredate = $this->input->get('hiredate');
		$salary = $this->input->get('salaryadd');
		$salary_from_date = $this->input->get('salaryfrom_add');
		$salary_to_date = $this->input->get('salaryto_add');
		
		$emp_no = $this->user->add_emp($firstname,$lastname,$gender,$date_of_birth,
												$jobtitle,$dept, $hiredate);
												
		$salarythings = $this->user->add_salary($firstname,$lastname,$gender,$date_of_birth,
												$jobtitle,$dept, $hiredate, $salary, $salary_from_date,$salary_to_date);
		
		$add_to_titles = $this->user->add_titles($firstname,$lastname,$gender,$date_of_birth,
												$jobtitle,$dept, $hiredate, $salary, $salary_from_date,$salary_to_date);
		
		$add_dept_emp = $this->user->add_dept_emp($firstname,$lastname,$gender,$date_of_birth,
												$jobtitle,$dept, $hiredate, $salary, $salary_from_date,$salary_to_date);
		
		$data['success'] = $add_dept_emp;
		$this->load->view('homepage', $data);
	}
    
	public function delete()
	{
		$firstname = $this->input->get('firstnamedelete');
		$lastname = $this->input->get('lastnamedelete');
		$dept = $this->input->get('deptartmentdelete');
		$jobtitle = $this->input->get('jobtitledelete');
		$gender = $this->input->get('genderdelete');
		$date_of_birth = $this->input->get('dateofbirth_delete');
		
		$delete_employee = $this->user->delete_emp($firstname, $lastname, $gender, $date_of_birth);
		
		$data['deletes'] = $delete_employee;
		$this->load->view('homepage', $data);
	}
	
	public function update()
	{
		$firstname = $this->input->get('firstnameupdate');
		$lastname = $this->input->get('lastnameupdate');
		$dept = $this->input->get('deptartmentupdate');
		$jobtitle = $this->input->get('jobtitleupdate');
		$new_salary = $this->input->get('salaryupdate');
		$from_date = $this->input->get('fromdateupdate');
		$to_date = $this->input->get('todateupdate');
		
		$update_employee = $this->user->update_emp($firstname, $lastname, $dept, $jobtitle, $new_salary, $from_date, $to_date);
		
		$data['updates'] = $update_employee;
		$this->load->view('homepage', $data);
	}
}