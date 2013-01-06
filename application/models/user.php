<?php
class User extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	function login($username,$pwd)
	{
		$this->db->where(array('username' => $username,'password' => sha1($pwd)));
		$res = $this->db->get('users',array('name'));
		if ($res->num_rows() != 1) // should be only ONE matching row!!
		{ 
			return false;
		}
 
		// remember login
		$session_id = $this->session->userdata('session_id');
		// remember current login
		$row = $res->row_array();
		$this->db->insert('logins',array('name' => $row['name'],'session_id' => $session_id));
		return $res->row_array();
	}	
	
	function is_loggedin()
	{
		$session_id = $this->session->userdata('session_id');
		$res = $this->db->get_where('logins',array('session_id' => $session_id));
		if ($res->num_rows() == 1) 
		{
			$row = $res->row_array();
			return $row['name'];
		}
		else 
		{
			return false;
		}
	}
	
	function search_admin($firstname,$lastname,$dept,$jobtitle)
	{
			$this->db->select('employees.first_name, employees.last_name, employees.birth_date, employees.gender, departments.dept_name, departments.dept_no, titles.title, dept_manager.emp_no, salaries.salary, salaries.from_date');
			$this->db->from('employees');
			$this->db->where('first_name', $firstname);
			$this->db->where('last_name', $lastname);
			$this->db->join('dept_manager', 'dept_manager.emp_no = employees.emp_no', 'left');
			$this->db->join('dept_emp', 'dept_emp.emp_no = employees.emp_no', 'inner');
			$this->db->join('departments', 'departments.dept_no = dept_emp.dept_no', 'inner');
			$this->db->join('titles', 'titles.emp_no = employees.emp_no', 'inner');
			$this->db->join('salaries', 'salaries.emp_no = employees.emp_no', 'inner');
			$this->db->where('dept_name', $dept);
			$this->db->where('title', $jobtitle);
			$this->db->order_by("from_date", "desc");
			$this->db->limit(3);
			$query = $this->db->get();
			
			$data = array();
			$result = array();
			$count = 1;
			
			foreach($query->result() as $row)
			{
				$data['count'] = $count;
				$entry = array();
				$entry['firstname'] = $row->first_name;
				$entry['lastname'] = $row->last_name;
				$entry['birth_date'] = $row->birth_date;
				$entry['jobtitle'] = $row->title;
				$entry['dept'] = $row->dept_name;
				$entry['deptid'] = $row->dept_no;
				$entry['salary'] = $row->salary;
				$entry['gender'] = $row->gender;
				if($row->emp_no == null)
				{
					$entry['ismanager'] = 0;
				}
				else
				{
					$entry['ismanager'] = 1;
				}
				$result[] = $entry;
				$count++;
			}
			
			$data['results'] = $result;
			return $data;
	}
	
	function search($firstname,$lastname,$dept,$jobtitle)
	{
			if($firstname == '' || $firstname == null)
			{
				$this->db->select('employees.first_name, employees.last_name, departments.dept_name, departments.dept_no, titles.title, dept_manager.emp_no');
				$this->db->from('employees');
				$this->db->where('last_name', $lastname);
				$this->db->join('dept_manager', 'dept_manager.emp_no = employees.emp_no', 'left');
				$this->db->join('dept_emp', 'dept_emp.emp_no = employees.emp_no', 'inner');
				$this->db->join('departments', 'departments.dept_no = dept_emp.dept_no', 'inner');
				$this->db->join('titles', 'titles.emp_no = employees.emp_no', 'inner');
				$this->db->where('dept_name', $dept);
				$this->db->where('title', $jobtitle);
				$query = $this->db->get();
				
				$data = array();
				$result = array();
				$count = 1;
				
				foreach($query->result() as $row)
				{
					$data['count'] = $count;
					$entry = array();
					$entry['firstname'] = $row->first_name;
					$entry['lastname'] = $row->last_name;
					$entry['jobtitle'] = $row->title;
					$entry['dept'] = $row->dept_name;
					$entry['deptid'] = $row->dept_no;
					
					if($row->emp_no == null)
					{
						$entry['ismanager'] = 0;
					}
					else
					{
						$entry['ismanager'] = 1;
					}
					$result[] = $entry;
					$count++;
				}
				$data['results'] = $result;
				return $data;
			}
			
			$this->db->select('employees.first_name, employees.last_name, departments.dept_name, departments.dept_no, titles.title, dept_manager.emp_no');
			$this->db->from('employees');
			$this->db->where('first_name', $firstname);
			$this->db->where('last_name', $lastname);
			$this->db->join('dept_manager', 'dept_manager.emp_no = employees.emp_no', 'left');
			$this->db->join('dept_emp', 'dept_emp.emp_no = employees.emp_no', 'inner');
			$this->db->join('departments', 'departments.dept_no = dept_emp.dept_no', 'inner');
			$this->db->join('titles', 'titles.emp_no = employees.emp_no', 'inner');
			$this->db->where('dept_name', $dept);
			$this->db->where('title', $jobtitle);
			$query = $this->db->get();
			
			$data = array();
			$result = array();
			$count = 1;
			
			foreach($query->result() as $row)
			{
				$data['count'] = $count;
				$entry = array();
				$entry['firstname'] = $row->first_name;
				$entry['lastname'] = $row->last_name;
				$entry['jobtitle'] = $row->title;
				$entry['dept'] = $row->dept_name;
				$entry['deptid'] = $row->dept_no;
				if($row->emp_no == null)
				{
					$entry['ismanager'] = 0;
				}
				else
				{
					$entry['ismanager'] = 1;
				}
				$result[] = $entry;
				$count++;
			}
			
			$data['results'] = $result;
			return $data;
	}
	
	function add_emp($firstname,$lastname,$gender,$date_of_birth,$jobtitle,$dept,$hiredate)
	{
		
		$data = array(	'first_name' => $firstname, 
						'last_name' => $lastname,
						'gender' => $gender,
						'birth_date' => $date_of_birth,
						'hire_date' => $hiredate);
						
		$this->db->trans_start();
		$this->db->insert('employees', $data);
		$this->db->trans_complete();
	}
	
	function add_salary($firstname,$lastname,$gender,$date_of_birth,$jobtitle,$dept, $hiredate,$salary, $salary_from_date, $salary_to_date)
	{
		$this->db->select('emp_no');
		$this->db->from('employees');
		$this->db->where('first_name', $firstname);
		$this->db->where('last_name', $lastname);
		$this->db->where('gender', $gender);
		$this->db->where('hire_date', $hiredate);
		$this->db->where('birth_date', $date_of_birth);
		$this->db->limit(1);
		$selected_employee = $this->db->get();
		$result = $selected_employee->result();
		$emp_no = $result[0]->emp_no;
		
		$salarystuff = array('emp_no' => $emp_no, 'salary' => $salary, 'from_date' => $salary_from_date, 'to_date' => $salary_to_date);
		$this->db->trans_start();
		$this->db->insert('salaries', $salarystuff);
		$this->db->trans_complete();
	}
	
	function add_titles($firstname,$lastname,$gender,$date_of_birth,$jobtitle,$dept, $hiredate,$salary, $salary_from_date, $salary_to_date)
	{
		$this->db->select('emp_no');
		$this->db->from('employees');
		$this->db->where('first_name', $firstname);
		$this->db->where('last_name', $lastname);
		$this->db->where('gender', $gender);
		$this->db->where('hire_date', $hiredate);
		$this->db->where('birth_date', $date_of_birth);
		$this->db->limit(1);
		$selected_employee = $this->db->get();
		$result = $selected_employee->result();
		$emp_no = $result[0]->emp_no;
		
		$insert_to_titles = array('emp_no' => $emp_no, 'title' => $jobtitle, 'from_date' => $salary_from_date, 'to_date' => $salary_to_date);
		$this->db->trans_start();
		$this->db->insert('titles', $insert_to_titles);
		$this->db->trans_complete();
	}
	
	function add_dept_emp($firstname,$lastname,$gender,$date_of_birth,$jobtitle,$dept, $hiredate,$salary, $salary_from_date, $salary_to_date)
	{
		$this->db->select('emp_no');
		$this->db->from('employees');
		$this->db->where('first_name', $firstname);
		$this->db->where('last_name', $lastname);
		$this->db->where('gender', $gender);
		$this->db->where('hire_date', $hiredate);
		$this->db->where('birth_date', $date_of_birth);
		$this->db->limit(1);
		$selected_employee = $this->db->get();
		$result = $selected_employee->result();
		$emp_no = $result[0]->emp_no;
		
		$insert_to_dept_emp = array('emp_no' => $emp_no, 'dept_no' => $dept, 'from_date' => $salary_from_date, 'to_date' => '9999-01-01');
		$this->db->trans_start();
		$this->db->insert('dept_emp', $insert_to_dept_emp);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			$msg = "Adding the new employee failed.";
			return $msg;
		}
		else
		{
			$msg = "Successfully Added Employee.";
			return $msg;
		}
	}
	
	function delete_emp($firstname,$lastname,$gender,$date_of_birth)
	{
		/*$this->db->select('*');
		$this->db->from('employees');
		$this->db->where('first_name', $firstname);
		$this->db->where('last_name', $lastname);
		$this->db->where('gender', $gender);
		$this->db->where('birth_date', $date_of_birth);
		$this->db->limit(1);
		$selected_employee = $this->db->get();*/
		
		$delete_emp = array('first_name' => $firstname, 'last_name' => $lastname, 'gender' => $gender, 'birth_date' => $date_of_birth);
		$this->db->trans_start();
		$this->db->delete('employees', $delete_emp);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			$msg = "Deleting employee failed.";
			return $msg;
		}
		else
		{
			$msg = "Successfully Deleted Employee.";
			return $msg;
		}
	}
	
	function update_emp($firstname, $lastname, $dept, $jobtitle, $new_salary, $from_date, $to_date)
	{
		$this->db->select('employees.emp_no');
		$this->db->from('employees');
		$this->db->where('first_name', $firstname);
		$this->db->where('last_name', $lastname);
		$this->db->join('dept_emp', 'dept_emp.emp_no = employees.emp_no', 'inner');
		$this->db->join('departments', 'departments.dept_no = dept_emp.dept_no', 'inner');
		$this->db->join('titles', 'titles.emp_no = employees.emp_no', 'inner');
		$this->db->where('dept_name', $dept);
		$this->db->where('title', $jobtitle);
		$this->db->limit(1);
		$selected_employee = $this->db->get();
		$result = $selected_employee->result();
		$emp_no = $result[0]->emp_no;
		
		$insert_to_salaries = array('emp_no' => $emp_no, 'salary' => $new_salary, 'from_date' => $from_date, 'to_date' => $to_date);
		$this->db->trans_start();
		$this->db->insert('salaries', $insert_to_salaries);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			$msg = "Updating employee failed.";
			return $msg;
		}
		else
		{
			$msg = "Successfully Updated Employees Salary. Cha ching!";
			return $msg;
		}
	}
}