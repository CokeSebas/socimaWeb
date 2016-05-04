<?php    
class ControllerSaleSalesRep extends Controller { 
	private $error = array();
  
  	public function index() {
		$this->load->language('sale/salesrep');
		 
		$this->document->setTitle = $this->language->get('heading_title');
		
		$this->load->model('sale/salesrep');
		
    	$this->getList();
  	}
  
  	public function insert() {
		$this->load->language('sale/salesrep');

    	$this->document->setTitle = $this->language->get('heading_title');
		
		$this->load->model('sale/salesrep');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
      	  	$this->model_sale_salesrep->addSalesRep($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
		  
			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			
			if (isset($this->request->get['filter_area'])) {
				$url .= '&filter_area=' . $this->request->get['filter_area'];
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

// v1.2
			if (isset($this->request->get['filter_public'])) {
				$url .= '&filter_public=' . $this->request->get['filter_public'];
			}
			
			if (isset($this->request->get['filter_alert'])) {
				$url .= '&filter_alert=' . $this->request->get['filter_alert'];
			}
// v1.2 end				
			
			if (isset($this->request->get['filter_telephone'])) {
				$url .= '&filter_telephone=' . $this->request->get['filter_telephone'];
			}
		
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}
							
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->link('sale/salesrep', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
    	
    	$this->getForm();
  	} 
   
  	public function update() {
		$this->load->language('sale/salesrep');

    	$this->document->setTitle = $this->language->get('heading_title');
		
		$this->load->model('sale/salesrep');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_salesrep->editSalesRep($this->request->get['salesrep_id'], $this->request->post);
	  		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			
			if (isset($this->request->get['filter_area'])) {
				$url .= '&filter_area=' . $this->request->get['filter_area'];
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

// v1.2
			if (isset($this->request->get['filter_public'])) {
				$url .= '&filter_public=' . $this->request->get['filter_public'];
			}
			
			if (isset($this->request->get['filter_alert'])) {
				$url .= '&filter_alert=' . $this->request->get['filter_alert'];
			}
// v1.2 end					
			
			if (isset($this->request->get['filter_telephone'])) {
				$url .= '&filter_telephone=' . $this->request->get['filter_telephone'];
			}
		
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}
						
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->link('sale/salesrep', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
    
    	$this->getForm();
  	}   

  	public function delete() {
		$this->load->language('sale/salesrep');

    	$this->document->setTitle = $this->language->get('heading_title');
		
		$this->load->model('sale/salesrep');
			
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $salesrep_id) {
				$this->model_sale_salesrep->deleteSalesRep($salesrep_id);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			
			if (isset($this->request->get['filter_area'])) {
				$url .= '&filter_area=' . $this->request->get['filter_area'];
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

// v1.2
			if (isset($this->request->get['filter_public'])) {
				$url .= '&filter_public=' . $this->request->get['filter_public'];
			}
			
			if (isset($this->request->get['filter_alert'])) {
				$url .= '&filter_alert=' . $this->request->get['filter_alert'];
			}
// v1.2 end		
			
			if (isset($this->request->get['filter_telephone'])) {
				$url .= '&filter_telephone=' . $this->request->get['filter_telephone'];
			}		
		
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}
						
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->link('sale/salesrep', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
    
    	$this->getList();
  	}  
    
  	private function getList() {
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name'; 
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = NULL;
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = NULL;
		}
		
		if (isset($this->request->get['filter_area'])) {
			$filter_area = $this->request->get['filter_area'];
		} else {
			$filter_area = NULL;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = NULL;
		}
		
// v1.2

		if (isset($this->request->get['filter_public'])) {
			$filter_public = $this->request->get['filter_public'];
		} else {
			$filter_public = NULL;
		}

		if (isset($this->request->get['filter_alert'])) {
			$filter_alert = $this->request->get['filter_alert'];
		} else {
			$filter_alert = NULL;
		}		

// v1.2 end
		
		if (isset($this->request->get['filter_telephone'])) {
			$filter_telephone = $this->request->get['filter_telephone'];
		} else {
			$filter_telephone = NULL;
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = NULL;
		}		
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		
		if (isset($this->request->get['filter_area'])) {
			$url .= '&filter_area=' . $this->request->get['filter_area'];
		}
			
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

// 1.2
			if (isset($this->request->get['filter_public'])) {
				$url .= '&filter_public=' . $this->request->get['filter_public'];
			}
			
			if (isset($this->request->get['filter_alert'])) {
				$url .= '&filter_alert=' . $this->request->get['filter_alert'];
			}
// 1.2 end		
		
		if (isset($this->request->get['filter_telephone'])) {
			$url .= '&filter_telephone=' . $this->request->get['filter_telephone'];
		}	
			
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
						
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('sale/salesrep', 'token=' . $this->session->data['token'] . $url, 'SSL'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] = $this->url->link('sale/salesrep/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('sale/salesrep/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

// v1.2
		$this->data['public'] = $this->url->link('sale/salesrep/setAsPublic', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['alert'] = $this->url->link('sale/salesrep/satAlert', 'token=' . $this->session->data['token'] . $url, 'SSL');
// v1.2 end		
		
		$this->data['salesreps'] = array();

		$data = array(
			'filter_name'              => $filter_name, 
			'filter_email'             => $filter_email, 
			'filter_area' => $filter_area, 
			'filter_status'            => $filter_status, 
// v1.2
			'filter_public'            => $filter_public, 
			'filter_alert'            => $filter_alert, 
// v1.2 end			
			'filter_telephone'          => $filter_telephone, 
			'filter_date_added'        => $filter_date_added,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                    => $this->config->get('config_admin_limit')
		);
		
		$salesrep_total = $this->model_sale_salesrep->getTotalSalesReps($data, 1);
	
		$results = $this->model_sale_salesrep->getSalesReps($data, 1);
 
    	foreach ($results as $result) {
			$action = array();
		
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/salesrep/update', 'token=' . $this->session->data['token'] . '&salesrep_id=' . $result['salesrep_id'] . $url, 'SSL')
			);
			
			$this->data['salesreps'][] = array(
				'salesrep_id'    => $result['salesrep_id'],
				'name'           => $result['name'],
				'email'          => $result['email'],
				'area' => $result['area'],
				'status'         => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
// v1.2
				'public'         => ($result['public'] ? $this->language->get('text_yes') : $this->language->get('text_no')),
				'alert'         => ($result['alert'] ? $this->language->get('text_yes') : $this->language->get('text_no')),				
// v1.2 end
				'telephone'       => $result['telephone'],
				'date_added'     => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'selected'       => isset($this->request->post['selected']) && in_array($result['salesrep_id'], $this->request->post['selected']),
				'action'         => $action
			);
		}	
					
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_area'] = $this->language->get('column_area');
		$this->data['column_status'] = $this->language->get('column_status');
// v1.2
		$this->data['column_public'] = $this->language->get('column_public');
		$this->data['column_alert'] = $this->language->get('column_alert');
// v1.2 end		
		$this->data['column_telephone'] = $this->language->get('column_telephone');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_filter'] = $this->language->get('button_filter');
// v1.2
		$this->data['button_public'] = $this->language->get('button_public');
		$this->data['button_alert'] = $this->language->get('button_alert');		
// v1.2
		$this->data['token'] = $this->session->data['token'];

		if (isset($this->session->data['error'])) {
			$this->data['error_warning'] = $this->session->data['error'];
			
			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		
		if (isset($this->request->get['filter_area'])) {
			$url .= '&filter_area=' . $this->request->get['filter_area'];
		}
			
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

// 1.2
			if (isset($this->request->get['filter_public'])) {
				$url .= '&filter_public=' . $this->request->get['filter_public'];
			}
			
			if (isset($this->request->get['filter_alert'])) {
				$url .= '&filter_alert=' . $this->request->get['filter_alert'];
			}
// 1.2 end		
		
		if (isset($this->request->get['filter_telephone'])) {
			$url .= '&filter_telephone=' . $this->request->get['filter_telephone'];
		}	
		
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
			
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$this->data['sort_name'] = $this->url->link('sale/salesrep', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');		
		$this->data['sort_email'] = $this->url->link('sale/salesrep', 'token=' . $this->session->data['token'] . '&sort=email' . $url, 'SSL');			
		$this->data['sort_area'] = $this->url->link('sale/salesrep', 'token=' . $this->session->data['token'] . '&sort=area' . $url, 'SSL');	
		$this->data['sort_status'] = $this->url->link('sale/salesrep', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');	
// v1.2
		$this->data['sort_public'] = $this->url->link('sale/salesrep', 'token=' . $this->session->data['token'] . '&sort=public' . $url, 'SSL');	
		$this->data['sort_alert'] = $this->url->link('sale/salesrep', 'token=' . $this->session->data['token'] . '&sort=alert' . $url, 'SSL');	
// v1.2 end		

		$this->data['sort_telephone'] = $this->url->link('sale/salesrep', 'token=' . $this->session->data['token'] . '&sort=telephone' . $url, 'SSL');	
		$this->data['sort_date_added'] = $this->url->link('sale/salesrep', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');	
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		
		if (isset($this->request->get['filter_area'])) {
			$url .= '&filter_area=' . $this->request->get['filter_area'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

// 1.2
			if (isset($this->request->get['filter_public'])) {
				$url .= '&filter_public=' . $this->request->get['filter_public'];
			}
			
			if (isset($this->request->get['filter_alert'])) {
				$url .= '&filter_alert=' . $this->request->get['filter_alert'];
			}
// 1.2 end		
		
		if (isset($this->request->get['filter_telephone'])) {
			$url .= '&filter_telephone=' . $this->request->get['filter_telephone'];
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		$pagination = new Pagination();
		$pagination->total = $salesrep_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/salesrep', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['filter_name'] = $filter_name;
		$this->data['filter_email'] = $filter_email;
		$this->data['filter_area'] = $filter_area;
		$this->data['filter_status'] = $filter_status;
// v1.2
		$this->data['filter_public'] = $filter_public;
		$this->data['filter_alert'] = $filter_alert;
// v1.2 end		
		$this->data['filter_telephone'] = $filter_telephone;
		$this->data['filter_date_added'] = $filter_date_added;
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'sale/salesrep_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
  	}
  
  	private function getForm() {
    	$this->data['heading_title'] = $this->language->get('heading_title');
 
    	$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
// v1.2
    	$this->data['text_yes'] = $this->language->get('text_yes');
    	$this->data['text_no'] = $this->language->get('text_no');
// v1.2 end		
		$this->data['text_select'] = $this->language->get('text_select');
    	
    	$this->data['entry_email'] = $this->language->get('entry_email');
    	$this->data['entry_username'] = $this->language->get('entry_username');
    	$this->data['entry_password'] = $this->language->get('entry_password');		
    	$this->data['entry_telephone'] = $this->language->get('entry_telephone');
    	$this->data['entry_fax'] = $this->language->get('entry_fax');
    	$this->data['entry_area'] = $this->language->get('entry_area');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_code'] = $this->language->get('entry_code');
		$this->data['entry_commission'] = $this->language->get('entry_commission');
		$this->data['entry_tax'] = $this->language->get('entry_tax');	
		$this->data['entry_status'] = $this->language->get('entry_status');
// v1.2
    	$this->data['entry_public'] = $this->language->get('entry_public');
		$this->data['entry_alert'] = $this->language->get('entry_alert');
		$this->data['entry_additional_emails'] = $this->language->get('entry_additional_emails');		
		$this->data['entry_cargo'] = $this->language->get('entry_cargo');
		$this->data['entry_id'] = $this->language->get('entry_id');
// v1.2 end		

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_address'] = $this->language->get('entry_address');
 
		$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');
    	$this->data['button_add'] = $this->language->get('button_add');
    	$this->data['button_remove'] = $this->language->get('button_remove');
	
		$this->data['tab_general'] = $this->language->get('tab_general');

		$this->data['token'] = $this->session->data['token'];

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}		
		
 		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}

 		if (isset($this->error['area'])) {
			$this->data['error_area'] = $this->error['area'];
		} else {
			$this->data['error_area'] = '';
		}

 		if (isset($this->error['address'])) {
			$this->data['error_address'] = $this->error['address'];
		} else {
			$this->data['error_address'] = '';
		}
		
 		if (isset($this->error['telephone'])) {
			$this->data['error_telephone'] = $this->error['telephone'];
		} else {
			$this->data['error_telephone'] = '';
		}

 		if (isset($this->error['fax'])) {
			$this->data['error_fax'] = $this->error['fax'];
		} else {
			$this->data['error_fax'] = '';
		}

		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
		}
		
		$url = '';
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		
		if (isset($this->request->get['filter_area'])) {
			$url .= '&filter_area=' . $this->request->get['filter_area'];
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
// 1.2
			if (isset($this->request->get['filter_public'])) {
				$url .= '&filter_public=' . $this->request->get['filter_public'];
			}
			
			if (isset($this->request->get['filter_alert'])) {
				$url .= '&filter_alert=' . $this->request->get['filter_alert'];
			}
// 1.2 end		
		
		if (isset($this->request->get['filter_telephone'])) {
			$url .= '&filter_telephone=' . $this->request->get['filter_telephone'];
		}	
		
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
						
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('sale/salesrep', 'token=' . $this->session->data['token'] . $url, 'SSL'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);

		if (!isset($this->request->get['salesrep_id'])) {
			$this->data['action'] = $this->url->link('sale/salesrep/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('sale/salesrep/update', 'token=' . $this->session->data['token'] . '&salesrep_id=' . $this->request->get['salesrep_id'] . $url, 'SSL');
		}
		  
    	$this->data['cancel'] = $this->url->link('sale/salesrep', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['statuses'] = $this->model_sale_salesrep->getCargo();
		
    	if (isset($this->request->get['salesrep_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$salesrep_info = $this->model_sale_salesrep->getSalesRep($this->request->get['salesrep_id']);
    	}
		
		if (isset($this->request->post['id'])) {
      		$this->data['id'] = $this->request->post['id'];
    	} elseif (isset($salesrep_info)) { 
			$this->data['id'] = $salesrep_info['salesrep_id'];
		} else {
      		$this->data['id'] = '';
    	}

    	if (isset($this->request->post['name'])) {
      		$this->data['name'] = $this->request->post['name'];
    	} elseif (isset($salesrep_info)) { 
			$this->data['name'] = $salesrep_info['name'];
		} else {
      		$this->data['name'] = '';
    	}		

    	if (isset($this->request->post['area'])) {
      		$this->data['area'] = $this->request->post['area'];
    	} elseif (isset($salesrep_info)) { 
			$this->data['area'] = $salesrep_info['area'];
		} else {
      		$this->data['area'] = '';
    	}		
		
    	if (isset($this->request->post['email'])) {
      		$this->data['email'] = $this->request->post['email'];
    	} elseif (isset($salesrep_info)) { 
			$this->data['email'] = $salesrep_info['email'];
		} else {
      		$this->data['email'] = '';
    	}

    	if (isset($this->request->post['telephone'])) {
      		$this->data['telephone'] = $this->request->post['telephone'];
    	} elseif (isset($salesrep_info)) { 
			$this->data['telephone'] = $salesrep_info['telephone'];
		} else {
      		$this->data['telephone'] = '';
    	}

    	if (isset($this->request->post['fax'])) {
      		$this->data['fax'] = $this->request->post['fax'];
    	} elseif (isset($salesrep_info)) { 
			$this->data['fax'] = $salesrep_info['fax'];
		} else {
      		$this->data['fax'] = '';
    	}

    	if (isset($this->request->post['status'])) {
      		$this->data['status'] = $this->request->post['status'];
    	} elseif (isset($salesrep_info)) { 
			$this->data['status'] = $salesrep_info['status'];
		} else {
      		$this->data['status'] = 1;
    	}

// v1.2		
    	if (isset($this->request->post['public'])) {
      		$this->data['public'] = $this->request->post['public'];
    	} elseif (isset($salesrep_info)) { 
			$this->data['public'] = $salesrep_info['public'];
		} else {
      		$this->data['public'] = 1;
    	}

    	if (isset($this->request->post['alert'])) {
      		$this->data['alert'] = $this->request->post['alert'];
    	} elseif (isset($salesrep_info)) { 
			$this->data['alert'] = $salesrep_info['alert'];
		} else {
      		$this->data['alert'] = 1;
    	}

    	if (isset($this->request->post['additional_emails'])) {
      		$this->data['additional_emails'] = $this->request->post['additional_emails'];
    	} elseif (isset($salesrep_info)) { 
			$this->data['additional_emails'] = $salesrep_info['additional_emails'];
		} else {
      		$this->data['additional_emails'] = '';
    	}
		
// v1.2 end		
		
    	if (isset($this->request->post['address'])) {
      		$this->data['address'] = $this->request->post['address'];
    	} elseif (isset($salesrep_info)) { 
			$this->data['address'] = $salesrep_info['address'];
		} else {
      		$this->data['address'] = '';
    	}

		if (isset($this->request->post['code'])) {
      		$this->data['code'] = $this->request->post['code'];
    	} elseif (!empty($salesrep_info)) { 
			$this->data['code'] = $salesrep_info['code'];
		} else {
      		$this->data['code'] = uniqid();
    	}

		if (isset($this->request->post['commission'])) {
      		$this->data['commission'] = $this->request->post['commission'];
    	} elseif (!empty($salesrep_info)) { 
			$this->data['commission'] = $salesrep_info['commission'];
		} else {
      		$this->data['commission'] = $this->config->get('config_commission');
    	}
		
		if (isset($this->request->post['tax'])) {
      		$this->data['tax'] = $this->request->post['tax'];
    	} elseif (!empty($salesrep_info)) { 
			$this->data['tax'] = $salesrep_info['tax'];
		} else {
      		$this->data['tax'] = '';
    	}
		
		if (isset($this->request->post['cargo'])) {
      		$this->data['cargo'] = $this->request->post['cargo'];
    	} elseif (isset($salesrep_info)) { 
			$this->data['cargo'] = $salesrep_info['cargo'];
		} else {
      		$this->data['cargo'] = '';
    	}		

		$this->template = 'sale/salesrep_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'sale/salesrep')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	if ((strlen(utf8_decode($this->request->post['name'])) < 1) || (strlen(utf8_decode($this->request->post['name'])) > 32)) {
      		$this->error['name'] = $this->language->get('error_name');
    	}

    	if ((strlen(utf8_decode($this->request->post['area'])) < 0) || (strlen(utf8_decode($this->request->post['area'])) > 32)) {
      		$this->error['area'] = $this->language->get('error_area');
    	}		
    	
		if ((strlen(utf8_decode($this->request->post['email'])) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$this->error['email'] = $this->language->get('error_email');
    	}

    	if ((strlen(utf8_decode($this->request->post['telephone'])) < 0) || (strlen(utf8_decode($this->request->post['telephone'])) > 32)) {
      		$this->error['telephone'] = $this->language->get('error_telephone');
    	}

    	if ((strlen(utf8_decode($this->request->post['address'])) < 0) || (strlen(utf8_decode($this->request->post['address'])) > 128)) {
      		$this->error['address'] = $this->language->get('error_address');
    	}

    	if ((strlen(utf8_decode($this->request->post['fax'])) < 0) || (strlen(utf8_decode($this->request->post['fax'])) > 32)) {
      		$this->error['fax'] = $this->language->get('error_fax');
    	}		

    	if (!$this->request->post['code']) {
      		$this->error['code'] = $this->language->get('error_code');
    	}
		
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}    

  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'sale/salesrep')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}	
	  	 
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}  
  	} 	

	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_name'])) {
			$this->load->model('sale/salesrep');
			
			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);
		
			$results = $this->model_sale_salesrep->getSalesReps($data, 1);
			
			foreach ($results as $result) {
				$json[] = array(
					'salesrep_id'    => $result['salesrep_id'], 
					'name'           => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
					'email'          => $result['email'],
					'telephone'      => $result['telephone'],
					'fax'            => $result['fax'],
					'address'        => $result['address']
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
	
	
}
?>
