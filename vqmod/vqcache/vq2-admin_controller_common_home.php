<?php   
class ControllerCommonHome extends Controller {   


			public function installTheme(){
				$this->language->load('common/home');

				$this->data['success_install_theme'] = $this->language->get('success_install_theme');
				// check if theme is installed then install if not

				// Call the model that checks the table for the enabled widgets
				$this->load->model('common/admin_circloid_dashboard_editor');

				$tables_exist = $this->model_common_admin_circloid_dashboard_editor->tablesExist();

				if($tables_exist['color_preset'] && $tables_exist['widget_layout']){
					// Redirect to homepage
					$this->redirect($this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'));
				}else{
					// Install Theme
					$theme_installed = $this->model_common_admin_circloid_dashboard_editor->installTheme();

					if($theme_installed){
						// delete sql install folder

						$install_path = substr_replace(DIR_SYSTEM, '/admin/base5builder_circloid_install/', -8);

						$install_folder_deleted = $this->delete_folder($install_path);

						$this->session->data['success'] = $this->data['success_install_theme'];
					}else{
						$this->session->data['error_warning'] = $this->data['error_install_theme'];
					}
					$this->redirect($this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'));
				}
			}

			private function delete_folder($path){
				if (is_dir($path) === true){
					$files = array_diff(scandir($path), array('.', '..'));

					foreach ($files as $file){
						$this->delete_folder(realpath($path) . '/' . $file);
					}

					return rmdir($path);
				}else if (is_file($path) === true){
					return unlink($path);
				}
			}
			
	public function index() {
		$this->language->load('common/home');

		$this->document->setTitle($this->language->get('heading_title'));

			$this->data['heading_almost_done'] = $this->language->get('heading_almost_done');
			$this->data['text_front'] = $this->language->get('text_front');
			$this->data['text_logout'] = $this->language->get('text_logout');
			$this->data['text_total_sales_previous_years'] = $this->language->get('text_total_sales_previous_years');
			$this->data['text_other_stats'] = $this->language->get('text_other_stats');
			$this->data['text_statistics_day'] = $this->language->get('text_statistics_day');
			$this->data['text_statistics_week'] = $this->language->get('text_statistics_week');
			$this->data['text_statistics_month'] = $this->language->get('text_statistics_month');
			$this->data['text_statistics_year'] = $this->language->get('text_statistics_year');
			$this->data['text_statistics_sales'] = $this->language->get('text_statistics_sales');
			$this->data['text_sales_value_short_description'] = $this->language->get('text_sales_value_short_description');
			$this->data['text_sales_value_timeframe_day'] = $this->language->get('text_sales_value_timeframe_day');
			$this->data['text_sales_value_timeframe_week'] = $this->language->get('text_sales_value_timeframe_week');
			$this->data['text_sales_value_timeframe_month'] = $this->language->get('text_sales_value_timeframe_month');
			$this->data['text_total_review'] = $this->language->get('text_total_review');
			$this->data['text_other_stats'] = $this->language->get('text_other_stats');
			$this->data['text_total_newsletter_subscribers'] = $this->language->get('text_total_newsletter_subscribers');
			$this->data['text_top_customers'] = $this->language->get('text_top_customers');
			$this->data['text_top_products'] = $this->language->get('text_top_products');
			$this->data['text_top_customers_description'] = $this->language->get('text_top_customers_description');
			$this->data['text_top_products_description'] = $this->language->get('text_top_products_description');
			$this->data['text_view'] = $this->language->get('text_view');
			$this->data['text_sold'] = $this->language->get('text_sold');
			$this->data['text_no_data'] = $this->language->get('text_no_data');
			$this->data['text_error_chart'] = $this->language->get('text_error_chart');
			$this->data['text_custom_range'] = $this->language->get('text_custom_range');
			$this->data['entry_status_label'] = $this->language->get('entry_status_label');
			$this->data['text_all_status'] = $this->language->get('text_all_status');

			$this->data['button_edit_dashboard'] = $this->language->get('button_edit_dashboard');

			$this->data['edit_dashboard'] = $this->url->link('common/admin_circloid_dashboard_editor', 'token=' . $this->session->data['token'], 'SSL');

			$this->data['install_theme'] = $this->url->link('common/home/installtheme', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['import_extension_menu'] = $this->url->link('common/admin_circloid_dashboard_editor/importextensionmenu', 'token=' . $this->session->data['token'], 'SSL');

			$vqmod_path = substr_replace(DIR_SYSTEM, '/vqmod/xml/', -8);
			$menu_imported = is_file($vqmod_path . "b5b_admintheme_circloid_menu_fix.xml");

			$this->data['menu_imported'] = $menu_imported;

			$this->data['text_install_step_1'] = $this->language->get('text_install_step_1');
			$this->data['text_install_step_info'] = $this->language->get('text_install_step_info');
			$this->data['text_install_step_2'] = sprintf($this->language->get('text_install_step_2'), $this->data['import_extension_menu']);
			$this->data['text_install_step_2_after'] = $this->language->get('text_install_step_2_after');
			$this->data['text_install_step_3'] = sprintf($this->language->get('text_install_step_3'), $this->data['install_theme']);
			$this->data['text_install_step_3_before'] = $this->language->get('text_install_step_3_before');

			if($this->data['text_install_step_1'] == 'text_install_step_1'){
			
				// This section creates a new Circloid Language xml file for other languages if the current installation is not English

				$path = 'language';
				$filenames = scandir($path);

				foreach ($filenames as $file_language) {
					if ($file_language === '.' or $file_language === '..') continue;

					if (is_dir($path . '/' . $file_language)) {
						if($file_language != 'english'){
							$filename = '../vqmod/xml/b5b_admintheme_circloid_languages.xml';
							$filename_new = '../vqmod/xml/b5b_admintheme_circloid_languages_' . trim($file_language) . '.xml';
							$contents = file_get_contents($filename);
							$new_contents = str_replace('English', ucfirst($file_language), str_replace('english', $file_language, $contents));
							file_put_contents($filename_new, $new_contents);
						}	
					}
				}
			}
			

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_overview'] = $this->language->get('text_overview');
		$this->data['text_statistics'] = $this->language->get('text_statistics');
		$this->data['text_latest_10_orders'] = $this->language->get('text_latest_10_orders');
		$this->data['text_total_sale'] = $this->language->get('text_total_sale');
		$this->data['text_total_sale_year'] = $this->language->get('text_total_sale_year');
		$this->data['text_total_order'] = $this->language->get('text_total_order');
		$this->data['text_total_customer'] = $this->language->get('text_total_customer');
		$this->data['text_total_customer_approval'] = $this->language->get('text_total_customer_approval');
		$this->data['text_total_review_approval'] = $this->language->get('text_total_review_approval');
		$this->data['text_total_affiliate'] = $this->language->get('text_total_affiliate');
		$this->data['text_total_affiliate_approval'] = $this->language->get('text_total_affiliate_approval');
		$this->data['text_day'] = $this->language->get('text_day');
		$this->data['text_week'] = $this->language->get('text_week');
		$this->data['text_month'] = $this->language->get('text_month');
		$this->data['text_year'] = $this->language->get('text_year');
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_order'] = $this->language->get('column_order');
		$this->data['column_customer'] = $this->language->get('column_customer');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_firstname'] = $this->language->get('column_firstname');
		$this->data['column_lastname'] = $this->language->get('column_lastname');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['entry_range'] = $this->language->get('entry_range');

		// Check install directory exists
		if (is_dir(dirname(DIR_APPLICATION) . '/install')) {
			$this->data['error_install'] = $this->language->get('error_install');
		} else {
			$this->data['error_install'] = '';
		}

		// Check image directory is writable
		$file = DIR_IMAGE . 'test';

		$handle = fopen($file, 'a+'); 

		fwrite($handle, '');

		fclose($handle); 		

		if (!file_exists($file)) {
			$this->data['error_image'] = sprintf($this->language->get('error_image'), DIR_IMAGE);
		} else {
			$this->data['error_image'] = '';

			unlink($file);
		}

		// Check image cache directory is writable
		$file = DIR_IMAGE . 'cache/test';

		$handle = fopen($file, 'a+'); 

		fwrite($handle, '');

		fclose($handle); 		

		if (!file_exists($file)) {
			$this->data['error_image_cache'] = sprintf($this->language->get('error_image_cache'), DIR_IMAGE . 'cache/');
		} else {
			$this->data['error_image_cache'] = '';

			unlink($file);
		}

		// Check cache directory is writable
		$file = DIR_CACHE . 'test';

		$handle = fopen($file, 'a+'); 

		fwrite($handle, '');

		fclose($handle); 		

		if (!file_exists($file)) {
			$this->data['error_cache'] = sprintf($this->language->get('error_image_cache'), DIR_CACHE);
		} else {
			$this->data['error_cache'] = '';

			unlink($file);
		}

		// Check download directory is writable
		$file = DIR_DOWNLOAD . 'test';

		$handle = fopen($file, 'a+'); 

		fwrite($handle, '');

		fclose($handle); 		

		if (!file_exists($file)) {
			$this->data['error_download'] = sprintf($this->language->get('error_download'), DIR_DOWNLOAD);
		} else {
			$this->data['error_download'] = '';

			unlink($file);
		}

		// Check logs directory is writable
		$file = DIR_LOGS . 'test';

		$handle = fopen($file, 'a+'); 

		fwrite($handle, '');

		fclose($handle); 		

		if (!file_exists($file)) {
			$this->data['error_logs'] = sprintf($this->language->get('error_logs'), DIR_LOGS);
		} else {
			$this->data['error_logs'] = '';

			unlink($file);
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['token'] = $this->session->data['token'];

		$this->load->model('sale/order');

		$this->data['total_sale'] = $this->currency->format($this->model_sale_order->getTotalSales(), $this->config->get('config_currency'));
		$this->data['total_sale_year'] = $this->currency->format($this->model_sale_order->getTotalSalesByYear(date('Y')), $this->config->get('config_currency'));

			// Set Success/Error Messages
			if(isset($this->session->data['success'])){
				$this->data['success'] = $this->session->data['success'];
				unset($this->session->data['success']);
			}

			if(isset($this->session->data['error_warning'])){
				$this->data['error_warning'] = $this->session->data['error_warning'];
				unset($this->session->data['error_warning']);
			}


			$this->data['total_sale_raw'] = $this->model_sale_order->getTotalSales();
			$this->data['total_sale_year_raw'] = $this->model_sale_order->getTotalSalesByYear(date('Y'));
			$this->data['total_sales_previous_years_raw'] = $this->data['total_sale_raw'] - $this->data['total_sale_year_raw'];
			$this->data['total_sales_previous_years'] = $this->currency->format($this->data['total_sale_raw'] - $this->data['total_sale_year_raw'], $this->config->get('config_currency'));


			$this->data['total_sales_today'] = $this->currency->format($this->model_sale_order->getTotalSalesToday());
			$this->data['total_sales_week'] = $this->currency->format($this->model_sale_order->getTotalSalesThisWeek());
			$this->data['total_sales_month'] = $this->currency->format($this->model_sale_order->getTotalSalesThisMonth());

			$this_day = date("z"); // Get today's number of the year (From 1 to 365. 366 on leap years)
			$this_week = date("W"); // Get this week's number of the year (From 1 to 52)
			$this_month = date("m"); // Get this month's number of the year (From 1 to 12)

			$this->data['average_sales_day'] = $this->currency->format($this->data['total_sale_year_raw'] / $this_day, $this->config->get('config_currency')); // Divide the total sales this year by the day number
			$this->data['average_sales_week'] = $this->currency->format($this->data['total_sale_year_raw'] / $this_week, $this->config->get('config_currency')); // Divide the total sales this year by the week number
			$this->data['average_sales_month'] = $this->currency->format($this->data['total_sale_year_raw'] / $this_month, $this->config->get('config_currency')); // Divide the total sales this year by the month number

			// Display Order Statuses
			$this->data['all_order_statuses'] = $this->model_sale_order->getAllStatuses();
			
			// Check if theme tables have been installed

			$this->load->model('common/admin_circloid_dashboard_editor');
			$tables_exist = $this->model_common_admin_circloid_dashboard_editor->tablesExist();

			if($tables_exist['color_preset'] && $tables_exist['widget_layout']){

				// Call the model that checks the table for the enabled widgets
				$this->load->model('common/admin_circloid_dashboard_editor');

				// Get Widget Data
				$this->data['widget_data'] = $this->model_common_admin_circloid_dashboard_editor->getWidgets();

				// Get Colors Profiles for theme
				$this->data['color_profile'] = $this->model_common_admin_circloid_dashboard_editor->getColorProfile();
			
			}else{
				// Display Message and "Install" button that will install the tables
				$this->data['theme_not_installed'] = TRUE;
			}
			
		$this->data['total_order'] = $this->model_sale_order->getTotalOrders();

		$this->load->model('sale/customer');

		$this->data['total_customer'] = $this->model_sale_customer->getTotalCustomers();
		$this->data['total_customer_approval'] = $this->model_sale_customer->getTotalCustomersAwaitingApproval();

		$this->load->model('catalog/review');

		$this->data['total_review'] = $this->model_catalog_review->getTotalReviews();
		$this->data['total_review_approval'] = $this->model_catalog_review->getTotalReviewsAwaitingApproval();

		$this->load->model('sale/affiliate');

		$this->data['total_affiliate'] = $this->model_sale_affiliate->getTotalAffiliates();
		$this->data['total_affiliate_approval'] = $this->model_sale_affiliate->getTotalAffiliatesAwaitingApproval();

		$this->data['orders'] = array(); 

		$data = array(
			'sort'  => 'o.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => 10
		);

		$results = $this->model_sale_order->getOrders($data);


				$this->load->model('common/admin_circloid_dashboard_editor');

				$this->data['total_newsletter_subscribers'] = $this->model_common_admin_circloid_dashboard_editor->getNewsletterSubscribers();

				$this->data['other_stats_links'] = array(
					'total_order'         => $this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL'),
					'total_customer'      => $this->url->link('sale/customer', 'token=' . $this->session->data['token'], 'SSL'),
					'total_review'      => $this->url->link('catalog/review', 'token=' . $this->session->data['token'], 'SSL'),
					'total_customer_approval'      => $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&filter_approved=0', 'SSL'),
					'total_review_approval'      => $this->url->link('catalog/review', 'token=' . $this->session->data['token'] . '&sort=r.status&order=ASC', 'SSL'),
					'total_affiliate'      => $this->url->link('sale/affiliate', 'token=' . $this->session->data['token'], 'SSL'),
					'total_affiliate_approval'      => $this->url->link('sale/affiliate', 'token=' . $this->session->data['token'] . '&filter_approved=0', 'SSL'),
					'total_newsletter_subscribers'         => $this->url->link('sale/contact', 'token=' . $this->session->data['token'], 'SSL')
				);

		   		$edit_dashboard = $this->url->link('common/admin_circloid_dashboard_editor', 'token=' . $this->session->data['token'], 'SSL');
			

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_view'),
				'href' => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'], 'SSL')
			);

			$this->data['orders'][] = array(
				'order_id'   => $result['order_id'],
				'customer'   => $result['customer'],
				'status'     => $result['status'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'total'      => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'action'     => $action
			);
		}
		
		$this->load->model('user/user');
		$groups = $this->model_user_user->getUserGroup($_SESSION['user_id']);
		$this->data['group_user'] = $groups['user_group_id'];
		
		//var_dump($this->data['group_user']);
		if($groups['user_group_id'] == 1 OR $groups['user_group_id'] == 16){
			$vendedores_db = $this->model_sale_order->getVendedores();
		
			foreach($vendedores_db as $vendedor){
				$this->data['vendedores'][] = array(
					'nombre' => $vendedor['firstname'],
					'apellido' => $vendedor['lastname'],
					'meta'	=> $vendedor['meta'],
					'actual' => $vendedor['total']
				);
			}
		}else{
			$vendedor = $this->model_sale_order->getVendedor($_SESSION['user_id']);			
			if(count($vendedor) != 0){
				$this->data['vendedores'] = array(
				'nombre' => $vendedor['firstname'],
				'apellido' => $vendedor['lastname'],
				'meta'	=> $vendedor['meta'],
				'actual' => $vendedor['total']
				);
			}
		}
		
		/*$vendedores_db = $this->model_sale_order->getVendedores();
		
		foreach($vendedores_db as $vendedor){
			$this->data['vendedores'][] = array(
				'nombre' => $vendedor['firstname'],
				'apellido' => $vendedor['lastname'],
				'meta'	=> $vendedor['meta'],
				'actual' => $vendedor['total']
			);
		}*/
		
		//var_dump($this->data['vendedores']);

		if ($this->config->get('config_currency_auto')) {
			$this->load->model('localisation/currency');

			$this->model_localisation_currency->updateCurrencies();
		}

		
			$this->template = 'admin_theme/base5builder_circloid/common/home.tpl';
			
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render());
	}
	
	//Jorge
	public function excel(){
	
		$this->load->model('sale/order');
	
		$this->data['datas'] = array(); 

		$result = $this->model_sale_order->getDatosOrderProcesadas();

		$this->data['datas'] = array(
			'order_id'   => $result['order_id'],
			'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
			'firstname'  => $result['firstname'],
			'rut'     	 => $result['rut'],
			'address'    => $result['address_1'],
			'city'       => $result['city'],
			'city_name'  => $result['name'],
			'payment' 	 => $result['payment_method']
		);
		
		//var_dump($this->data['datas']['order_id']);
		
		$this->data['orders'] = array(); 
		
		$orders = $this->model_sale_order->getOrderProcesadas($this->data['datas']['order_id']);
		
		foreach ($orders as $order){
			$this->data['orders'][] = array(
				'order_product_id' 	=> $order['order_product_id'],
				'order_id'			=> $order['order_id'],
				'product_id'		=> $order['product_id'],
				'name'				=> $order['name'],
				'quantity'			=> $order['quantity'],
				'price'				=> $order['price'],
				'total'				=> $order['total']
				);
		}
		//var_dump($this->data['orders']);
		//$this->load->view('common/excel_produccion', $this->data['orders']);
		//$this->redirect($this->url->link('common/excel_orders', 'token=' . $this->session->data['token'], 'SSL'));
		//$this->redirect($this->url->link('common/excel_orders.php'));
		//var_dump($this->url->link('common/excel_orders', 'token=' . $this->session->data['token'], 'SSL'));
		//header($this->url->link('common/excel_orders.php'));
	}

	public function chart() {
		$this->language->load('common/home');

		$data = array();

		$data['order'] = array();
		$data['customer'] = array();
		$data['xaxis'] = array();

		$data['order']['label'] = $this->language->get('text_order');
		$data['customer']['label'] = $this->language->get('text_customer');

		if (isset($this->request->get['range'])) {
			$range = $this->request->get['range'];
		} else {
			$range = 'month';
		}


				// Get Status
				$chart_order_status = $this->request->get['chart_order_status'];

			
		switch ($range) {


			case 'custom':

				// Get date ranges
				$raw_date_start = $this->request->get['range_custom_start'];
				$raw_date_end = $this->request->get['range_custom_end'];

				$set_date_range_start = strtotime($raw_date_start);
				$set_date_range_end = strtotime($raw_date_end);

				$date_range_time_diff = abs($set_date_range_end - $set_date_range_start);
				$date_range_time_diff_days = $date_range_time_diff/86400;

				$number_days = intval($date_range_time_diff_days);

				for ($i = 1; $i <= $number_days; $i++) {

					if($chart_order_status == "all"){
						$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND date_added BETWEEN '" . $raw_date_start . "' AND DATE_ADD('" . $raw_date_start . "', INTERVAL 1 DAY)");
					}else{
						$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . $chart_order_status . "' AND date_added BETWEEN '" . $raw_date_start . "' AND DATE_ADD('" . $raw_date_start . "', INTERVAL 1 DAY)");
					}

					$raw_date_start = strtotime("{$raw_date_start} + 1 day");
					$raw_date_start = date("Y-m-d 00:00:00",$raw_date_start);
					
					if ($query->num_rows){
						$data['order']['data'][] = array($i, (int)$query->row['total']);
					}
					
					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE date_added BETWEEN '" . $raw_date_start . "' AND DATE_ADD('" . $raw_date_start . "', INTERVAL 1 DAY)");
					
					if ($query->num_rows) { 
						$data['customer']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['customer']['data'][] = array($i, 0);
					}
					
					$data['xaxis'][] = array($i, date("d-m-Y" ,strtotime($raw_date_start)));
				}
				break;

			
			case 'day':
				for ($i = 0; $i < 24; $i++) {
					

			if($chart_order_status == "all"){
				$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND (DATE(date_added) = DATE(NOW()) AND HOUR(date_added) = '" . (int)$i . "') GROUP BY HOUR(date_added) ORDER BY date_added ASC");

		// madimar mod
		if ($this->user->getUserSalesRepId() != 0) {
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE salesrep_id = '" . $this->user->getUserSalesRepId() . "' AND order_status_id > '0' AND (DATE(date_added) = DATE(NOW()) AND HOUR(date_added) = '" . (int)$i . "') GROUP BY HOUR(date_added) ORDER BY date_added ASC");		
		}
		// madimar mod end
            
			}else{
				$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . $chart_order_status . "'  AND (DATE(date_added) = DATE(NOW()) AND HOUR(date_added) = '" . (int)$i . "') GROUP BY HOUR(date_added) ORDER BY date_added ASC");
			}

			

					if ($query->num_rows) {
						$data['order']['data'][]  = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data'][]  = array($i, 0);
					}

					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE DATE(date_added) = DATE(NOW()) AND HOUR(date_added) = '" . (int)$i . "' GROUP BY HOUR(date_added) ORDER BY date_added ASC");

		// madimar mod
		if ($this->user->getUserSalesRepId() != 0) {
					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE salesrep_id = '" . $this->user->getUserSalesRepId() . "' AND DATE(date_added) = DATE(NOW()) AND HOUR(date_added) = '" . (int)$i . "' GROUP BY HOUR(date_added) ORDER BY date_added ASC");	
		}	
		// madimar mod end
            

					if ($query->num_rows) {
						$data['customer']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['customer']['data'][] = array($i, 0);
					}

					$data['xaxis'][] = array($i, date('H', mktime($i, 0, 0, date('n'), date('j'), date('Y'))));
				}					
				break;
			case 'week':
				$date_start = strtotime('-' . date('w') . ' days'); 

				for ($i = 0; $i < 7; $i++) {
					$date = date('Y-m-d', $date_start + ($i * 86400));

					

			if($chart_order_status == "all"){
				$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND DATE(date_added) = '" . $this->db->escape($date) . "' GROUP BY DATE(date_added)");

		// madimar mod
		if ($this->user->getUserSalesRepId() != 0) {
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND DATE(date_added) = '" . $this->db->escape($date) . " AND salesrep_id = '" . $this->user->getUserSalesRepId() . "'" . " GROUP BY DATE(date_added)");		
		}	
		// madimar mod end
            
			}else{
				$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . $chart_order_status . "' AND DATE(date_added) = '" . $this->db->escape($date) . "' GROUP BY DATE(date_added)");
			}

			

					if ($query->num_rows) {
						$data['order']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data'][] = array($i, 0);
					}

					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "customer` WHERE DATE(date_added) = '" . $this->db->escape($date) . "' GROUP BY DATE(date_added)");

		// madimar mod
		if ($this->user->getUserSalesRepId() != 0) {
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "customer` WHERE DATE(date_added) = '" . $this->db->escape($date) . " AND salesrep_id = '" . $this->user->getUserSalesRepId() . "'" . " GROUP BY DATE(date_added)");		
		}	
		// madimar mod end
            

					if ($query->num_rows) {
						$data['customer']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['customer']['data'][] = array($i, 0);
					}

					$data['xaxis'][] = array($i, date('D', strtotime($date)));
				}

				break;
			default:
			case 'month':
				for ($i = 1; $i <= date('t'); $i++) {
					$date = date('Y') . '-' . date('m') . '-' . $i;

					

			if($chart_order_status == "all"){
				$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND (DATE(date_added) = '" . $this->db->escape($date) . "') GROUP BY DAY(date_added)");

		// madimar mod
		if ($this->user->getUserSalesRepId() != 0) {
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND (DATE(date_added) = '" . $this->db->escape($date) . "') AND salesrep_id = '" . $this->user->getUserSalesRepId() . "' GROUP BY DAY(date_added)");		
		}	
		// madimar mod end
            
			}else{
				$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . $chart_order_status . "' AND (DATE(date_added) = '" . $this->db->escape($date) . "') GROUP BY DAY(date_added)");
			}

			

					if ($query->num_rows) {
						$data['order']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data'][] = array($i, 0);
					}	

					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE DATE(date_added) = '" . $this->db->escape($date) . "' GROUP BY DAY(date_added)");

		// madimar mod
		if ($this->user->getUserSalesRepId() != 0) {
					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE DATE(date_added) = '" . $this->db->escape($date) . "'" . "AND salesrep_id = '" . $this->user->getUserSalesRepId() . "'" . " GROUP BY DAY(date_added)");	
		}	
		// madimar mod end
            

					if ($query->num_rows) {
						$data['customer']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['customer']['data'][] = array($i, 0);
					}	

					$data['xaxis'][] = array($i, date('j', strtotime($date)));
				}
				break;
			case 'year':
				for ($i = 1; $i <= 12; $i++) {
					

			if($chart_order_status == "all"){
				$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND YEAR(date_added) = '" . date('Y') . "' AND MONTH(date_added) = '" . $i . "' GROUP BY MONTH(date_added)");

		// madimar mod
		if ($this->user->getUserSalesRepId() != 0) {
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE salesrep_id = '" . $this->user->getUserSalesRepId() . "' AND order_status_id > '0' AND YEAR(date_added) = '" . date('Y') . "' AND MONTH(date_added) = '" . $i . "' GROUP BY MONTH(date_added)");
		}	
		// madimar mod end
            
			}else{
				$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . $chart_order_status . "' AND YEAR(date_added) = '" . date('Y') . "' AND MONTH(date_added) = '" . $i . "' GROUP BY MONTH(date_added)");
			}

			

					if ($query->num_rows) {
						$data['order']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data'][] = array($i, 0);
					}

					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE YEAR(date_added) = '" . date('Y') . "' AND MONTH(date_added) = '" . $i . "' GROUP BY MONTH(date_added)");

		// madimar mod
		if ($this->user->getUserSalesRepId() != 0) {
					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE  salesrep_id = '" . $this->user->getUserSalesRepId() . "' AND YEAR(date_added) = '" . date('Y') . "' AND MONTH(date_added) = '" . $i . "' GROUP BY MONTH(date_added)");
		}	
		// madimar mod end
            

					if ($query->num_rows) { 
						$data['customer']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['customer']['data'][] = array($i, 0);
					}

					$data['xaxis'][] = array($i, date('M', mktime(0, 0, 0, $i, 1, date('Y'))));
				}			
				break;	
		} 

		$this->response->setOutput(json_encode($data));
	}

	public function login() {
		$route = '';

		if (isset($this->request->get['route'])) {
			$part = explode('/', $this->request->get['route']);

			if (isset($part[0])) {
				$route .= $part[0];
			}

			if (isset($part[1])) {
				$route .= '/' . $part[1];
			}
		}

		$ignore = array(
			'common/login',
			'common/forgotten',
			'common/reset'
		);	

		if (!$this->user->isLogged() && !in_array($route, $ignore)) {
			return $this->forward('common/login');
		}

		if (isset($this->request->get['route'])) {
			$ignore = array(
				'common/login',
				'common/logout',
				'common/forgotten',
				'common/reset',
				'error/not_found',
				'error/permission'
			);

			$config_ignore = array();

			if ($this->config->get('config_token_ignore')) {
				$config_ignore = unserialize($this->config->get('config_token_ignore'));
			}

			$ignore = array_merge($ignore, $config_ignore);

			if (!in_array($route, $ignore) && (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token']))) {
				return $this->forward('common/login');
			}
		} else {
			if (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
				return $this->forward('common/login');
			}
		}
	}

	public function permission() {

		// madimar mod
		//if ($this->user->getUserSalesRepId() == 0) {
		if ($this->user->getUserSalesRepId()) {
			if (isset($this->request->get['customer_id'])) {
				$customer_id = $this->request->get['customer_id'];
				$this->load->model('sale/customer');
				//$cust_salesrep_id = $this->model_sale_customer->getSalesRepId($customer_id);
				$user_salesrep_id = $this->user->getUserSalesRepId();
						
				/*if ($cust_salesrep_id != $user_salesrep_id) {
					return $this->forward('error/permission');
				}*/
			} elseif (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
				$this->load->model('sale/order');
				//$ord_salesrep_id = $this->model_sale_order->getSalesRepId($order_id);
				$user_salesrep_id = $this->user->getUserSalesRepId();
						
				/*if ($ord_salesrep_id != $user_salesrep_id) {
					return $this->forward('error/permission');
				}*/
			} elseif (isset($this->request->get['salesrep_id'])) {
				$sr_salesrep_id = $this->request->get['salesrep_id'];
				$user_salesrep_id = $this->user->getUserSalesRepId();
						
				if ($sr_salesrep_id != $user_salesrep_id) {
					return $this->forward('error/permission');
				}
			}
		}
		// madimar mod end
            
		if (isset($this->request->get['route'])) {
			$route = '';

			$part = explode('/', $this->request->get['route']);

			if (isset($part[0])) {
				$route .= $part[0];
			}

			if (isset($part[1])) {
				$route .= '/' . $part[1];
			}

			$ignore = array(
				'common/home',
				'common/login',
				'common/logout',
				'common/forgotten',
				'common/reset',
				'error/not_found',		
			);			

			if (!in_array($route, $ignore) && !$this->user->hasPermission('access', $route)) {
				return $this->forward('error/permission');
			}
		}
	}	
}
?>