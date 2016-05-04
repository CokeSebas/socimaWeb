<?php
class ControllerBannersBanners extends Controller { 

	private $error = array();

	public function index() {
		$this->language->load('banners/banner');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/information');
		
		$this->getForm();
		
	}

	public function insert() {
		$this->language->load('banners/banner');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/information');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

			if($this->request->post['banner1'] != null && isset($_FILES['imagen1']['name'])){
				$domain = $_SERVER['SERVER_NAME'];
				$route = '/admin/view/image/noticias/';
				$nombre_img = 'banner_categoria.jpg';
				$route2 = 'http://'.$domain.$route.$nombre_img;
				move_uploaded_file($_FILES['imagen1']['tmp_name'],'../'.$route.$nombre_img);
				$this->model_catalog_information->save_banner($route2, $this->request->post['valueBanner1'], $this->request->post['idBanner1']);
				//var_dump('guardado el banner categoria');
				$this->session->data['banner1'] = 'correcto1';
			}else{
				$this->session->data['banner1'] = 'error1';
			}
			
			if($this->request->post['banner2'] != null && isset($_FILES['imagen2']['name'])){
				$domain = $_SERVER['SERVER_NAME'];
				$route = '/admin/view/image/noticias/';
				$nombre_img = 'banner_producto1.jpg';
				$route2 = 'http://'.$domain.$route.$nombre_img;
				move_uploaded_file($_FILES['imagen2']['tmp_name'],'../'.$route.$nombre_img);
				$this->model_catalog_information->save_banner($route2, $this->request->post['valueBanner2'], $this->request->post['idBanner2']);
				//var_dump('guardado el banner producto 1');
				$this->session->data['banner2'] = 'correcto2';
			}else{
				$this->session->data['banner2'] = 'error2';
			}
			
			if($this->request->post['banner3'] != null && isset($_FILES['imagen3']['name'])){
				$domain = $_SERVER['SERVER_NAME'];
				$route = '/admin/view/image/noticias/';
				$nombre_img = 'banner_producto2.jpg';
				$route2 = 'http://'.$domain.$route.$nombre_img;
				move_uploaded_file($_FILES['imagen3']['tmp_name'],'../'.$route.$nombre_img);
				$this->model_catalog_information->save_banner($route2, $this->request->post['valueBanner3'], $this->request->post['idBanner3']);
				//var_dump('guardado el banner producto 2');
				$this->session->data['banner3'] = 'correcto3';
			}else{
				$this->session->data['banner3'] = 'error3';
			}
			
			/*unset($_SESSION['banner1']);
			unset($_SESSION['banner2']);
			unset($_SESSION['banner3']);*/
		

			//$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('banners/banners', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			//$this->redirect($this->url->link('common/home', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();		
	}
		
	protected function getForm() {
	//var_dump($_SESSION);
	
		/*if(isset($this->session->data['banner1']) && $this->session->data['banner1'] == 'correcto1'){
			unset($_SESSION['banner1']);
		}
		
		if(isset($this->session->data['banner2']) && $this->session->data['banner2'] == 'correcto2'){
			unset($_SESSION['banner2']);
		}
	
		if(isset($this->session->data['banner3']) && $this->session->data['banner3'] == 'correcto3'){
			unset($_SESSION['banner3']);
		}*/
		
		if(isset($this->session->data['banner1'])){
			if($this->session->data['banner1'] == 'correcto1'){
				unset($_SESSION['banner1']);
				$this->session->data['success'] = $this->language->get('text_success');
			}
		}
		
		if(isset($this->session->data['banner2'])){
			if($this->session->data['banner2'] == 'correcto2'){
				unset($_SESSION['banner2']);
				$this->session->data['success'] = $this->language->get('text_success');
			}
		}
		
		if(isset($this->session->data['banner3'])){
			if($this->session->data['banner3'] == 'correcto3'){
				unset($_SESSION['banner3']);
				$this->session->data['success'] = $this->language->get('text_success');
			}
		}
	
		$this->load->model('catalog/information');
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');

		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_banner1'] = $this->language->get('entry_banner1');
		$this->data['entry_banner2'] = $this->language->get('entry_banner2');
		$this->data['entry_banner3'] = $this->language->get('entry_banner3');
		$this->data['button_subir'] = $this->language->get('button_subir');
		$this->data['button_limpiar'] = $this->language->get('button_limpiar');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['banner1'])) {
			$this->data['error_banner1'] = $this->error['banner1'];
		} else {
			$this->data['error_banner1'] = array();
		}
		
		if (isset($this->error['banner2'])) {
			$this->data['error_banner2'] = $this->error['banner2'];
		} else {
			$this->data['error_banner2'] = array();
		}
		
		if (isset($this->error['banner3'])) {
			$this->data['error_banner3'] = $this->error['banner3'];
		} else {
			$this->data['error_banner3'] = array();
		}
		
		if (isset($this->error['imagen1'])) {
			$this->data['error_imagen1'] = $this->error['imagen1'];
		} else {
			$this->data['error_imagen1'] = array();
		}
		
		if (isset($this->error['imagen2'])) {
			$this->data['error_imagen2'] = $this->error['imagen2'];
		} else {
			$this->data['error_imagen2'] = array();
		}
		
		if (isset($this->error['imagen3'])) {
			$this->data['error_imagen3'] = $this->error['imagen3'];
		} else {
			$this->data['error_imagen3'] = array();
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),     		
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('banners/banners', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['information_id'])) {
			$this->data['action'] = $this->url->link('banners/banners/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('noticias/noticias', 'token=' . $this->session->data['token'] . $url, 'SSL');


		$this->data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['banner1'])) {
			$this->data['banner1'] = $this->request->post['banner1'];
		} else {
			$this->data['banner1'] = '';
		}
		
		if (isset($this->request->post['banner2'])) {
			$this->data['banner2'] = $this->request->post['banner2'];
		} else {
			$this->data['banner2'] = '';
		}
		
		if (isset($this->request->post['banner3'])) {
			$this->data['banner3'] = $this->request->post['banner3'];
		} else {
			$this->data['banner3'] = '';
		}
		
		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'banners/banner_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
		
	function limpiar(){
		$json = array();
		
		if (isset($this->request->get['idBanner'])) {
			$bannerId = $this->request->get['idBanner'];
			$this->load->model('catalog/information');
				
			if($bannerId == 'limpiar1'){
				$id = 1;
			}
			if($bannerId == 'limpiar2'){
				$id = 2;
			}
			if($bannerId == 'limpiar3'){
				$id = 3;
			}
		}
		$result = $this->model_catalog_information->limpiarBanner($id);
		$this->response->setOutput(json_encode($id));	
	}
	
	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/category');

			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);

			$results = $this->model_catalog_category->getCategories2($data);

			foreach ($results as $result) {
				$json[] = array(
					'category_id' => $result['category_id'], 
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}		
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->setOutput(json_encode($json));
	}
	
	
	public function autocompleteProduct() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/category');

			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);

			$results = $this->model_catalog_category->getProduct2($data);

			foreach ($results as $result) {
				$json[] = array(
					'product_id' => $result['product_id'], 
					//'model'        => strip_tags(html_entity_decode($result['model'], ENT_QUOTES, 'UTF-8'))
					'model'        => $result['model']
				);
			}		
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['model'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->setOutput(json_encode($json));
	}

}
?>