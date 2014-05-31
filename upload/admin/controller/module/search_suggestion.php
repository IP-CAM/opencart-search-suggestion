<?php
class ControllerModuleSearchSuggestion extends Controller {
	private $error = array(); 
		
	public function index() {   
		$this->load->language('module/search_suggestion');

		$this->document->setTitle = $this->language->get('heading_title');
		$this->load->model('setting/setting');
                $this->load->model('design/layout');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('search_suggestion', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			//$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
                $this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
                
		$this->data['text_left'] = $this->language->get('text_left');
		$this->data['text_right'] = $this->language->get('text_right');
		$this->data['text_display'] = $this->language->get('text_display');
		
                $this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
                $this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();
                
                $this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
                
                $this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/search_suggestion', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
                $this->data['action'] = $this->url->link('module/search_suggestion&token', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['modules'] = array();

                if (isset($this->request->post['search_suggestion_module'])) {
			$this->data['modules'] = $this->request->post['search_suggestion_module'];
		} elseif ($this->config->get('search_suggestion_module')) { 
			$this->data['modules'] = $this->config->get('search_suggestion_module');
		}
                
		if (isset($this->request->post['search_suggestion_position'])) {
			$this->data['search_suggestion_position'] = $this->request->post['search_suggestion_position'];
		} else {
			$this->data['search_suggestion_position'] = $this->config->get('search_suggestion_position');
		}
		
		if (isset($this->request->post['search_suggestion_status'])) {
			$this->data['search_suggestion_status'] = $this->request->post['search_suggestion_status'];
		} else {
			$this->data['search_suggestion_status'] = $this->config->get('search_suggestion_status');
		}
		
		if (isset($this->request->post['search_suggestion_sort_order'])) {
			$this->data['search_suggestion_sort_order'] = $this->request->post['search_suggestion_sort_order'];
		} else {
			$this->data['search_suggestion_sort_order'] = $this->config->get('search_suggestion_sort_order');
		}				
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		$this->template = 'module/search_suggestion.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/search_suggestion')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}

        
}