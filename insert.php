<?php 

	if (isset($_POST['name']) && isset($_POST['email'])) {
		$name = $_POST['name'];
		$email = $_POST['email'];

		include 'model.php';

		$model = new Model();

		if ($model->insert($name, $email)) {
			$data = array('res' => 'success');
		}else{
			$data = array('res' => 'error');
		}

		echo json_encode($data);
	}

 ?>