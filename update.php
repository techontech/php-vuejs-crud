<?php 

	if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email'])) {
		
		$id = $_POST['id'];
		$name = $_POST['name'];
		$email = $_POST['email'];

		include 'model.php';

		$model = new Model();

		if ($model->update($id, $name, $email)) {
			$data = array('res' => 'success');
		}else{
			$data = array('res' => 'error');
		}

		echo json_encode($data);
	}

 ?>