<?php 

	class Users {
		public $username;
		public $password;

		public function check_empty_fields($username, $password) {
			if (!strlen($username) || !strlen($password)) {
				$message = "<strong>Login Failed!</strong> both fields are required";
			}
		}
	}

 ?>