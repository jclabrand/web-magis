<?php

class MagisProjector extends MagisController
{
	public function __construct()
	{
		add_shortcode('magis_projector_index', array($this, 'index'));
		add_shortcode('magis_projector_create', array($this, 'create_form'));

		$this->projectorsModel = new MagisProjectorsModel();
	}

	public function install() {
		$this->projectorsModel->install();
	}

	function index() {
		$projectors = $this->projectorsModel->all_prety();
		require plugin_dir_path( __FILE__ ) . '../views/projector-index.php';
	}

	function create_form($params) {
		require plugin_dir_path( __FILE__ ) . '../views/projector-create.php';
	}

	function create_post() {
		$data = $this->_validate_post();
		
		if($data->is_valid) {
			$data->post['fecha_creacion'] = current_time('mysql');
			$data->post['fecha_modificacion'] = current_time('mysql');

			$this->projectorsModel->insert($data->post);

			wp_redirect('/lista-de-promotores');
		} else {
			
			$this->_show_error($data->validation_message);
		}
	}

	private function _validate_post() {
		$data = new projectorData();

		if(empty($_POST['projector-status'])) {
			$data->validation_message = 'Por favor ingrese el estado del promotor.';
			return $data;
		} else {
			$data->post['estado'] = $_POST['projector-status'];
		}

		if(empty($_POST['projector-ci'])) {
			$data->validation_message = 'Por favor ingrese CI del promotor.';
			return $data;
		} else {
			$data->post['ci'] = $_POST['projector-ci'];
		}

		if(empty($_POST['projector-name'])) {
			$data->validation_message = 'Por favor ingrese el nombre del promotor.';
			return $data;
		} else {
			$data->post['nombre'] = $_POST['projector-name'];
		}

		if(empty($_POST['projector-dir'])) {
			$data->validation_message = 'Por favor ingrese la dirección del promotor.';
			return $data;
		} else {
			$data->post['direccion'] = $_POST['projector-dir'];
		}

		if(empty($_POST['projector-telf'])) {
			$data->validation_message = 'Por favor ingrese el teléfono del promotor.';
			return $data;
		} else {
			$data->post['telefono'] = $_POST['projector-telf'];
		}

		if(empty($_POST['projectorg-ci'])) {
			$data->validation_message = 'Por favor ingrese CI del garante.';
			return $data;
		} else {
			$data->post['ci_garante'] = $_POST['projectorg-ci'];
		}

		if(empty($_POST['projectorg-name'])) {
			$data->validation_message = 'Por favor ingrese el nombre del garante.';
			return $data;
		} else {
			$data->post['nombre_garante'] = $_POST['projectorg-name'];
		}

		if(empty($_POST['projectorg-dir'])) {
			$data->validation_message = 'Por favor ingrese la dirección del garante.';
			return $data;
		} else {
			$data->post['direccion_garante'] = $_POST['projectorg-dir'];
		}

		if(empty($_POST['projectorg-telf'])) {
			$data->validation_message = 'Por favor ingrese el teléfono del garante.';
			return $data;
		} else {
			$data->post['telefono_garante'] = $_POST['projectorg-telf'];
		}

		$data->is_valid = true;
		return $data;
	}
}


class projectorData {
	public $is_valid = true;
	public $validation_message = '';
	public $post = array();
}
