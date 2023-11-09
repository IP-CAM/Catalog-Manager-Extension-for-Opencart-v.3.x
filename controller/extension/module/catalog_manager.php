<?php

/**
 * Catalog Manager
 * @author Antonis Kazantzis
 * @link https://github.com/AntonisKazantzis/Catalog-Manager-Opencart3
 * @version 1.0
 */

class ControllerExtensionModuleCatalogManager extends Controller
{
    private $error = [];

    public function index(): void
    {
        $this->load->language('extension/module/catalog_manager');

        $this->load->model('setting/setting');

        $this->document->setTitle($this->language->get('heading_title'));

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('module_catalog_manager', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/module/catalog_manager', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }

        // Errors
        $data['error_warning'] = $this->error['warning'] ?? '';
        $data['error_status'] = $this->error['error_status'] ?? '';

        // Breadcrumbs
        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true),
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true),
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/catalog_manager', 'user_token=' . $this->session->data['user_token'], true),
        ];

        // Buttons
        $data['action'] = $this->url->link('extension/module/catalog_manager', 'user_token=' . $this->session->data['user_token'], true);
        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        $data['user_token'] = $this->session->data['user_token'];

        // Fields
        $data['module_catalog_manager_status'] = $this->request->post['module_catalog_manager_status'] ?? $this->config->get('module_catalog_manager_status');
        $data['module_catalog_manager_categories_clear'] = $this->request->post['module_catalog_manager_categories_clear'] ?? $this->config->get('module_catalog_manager_categories_clear');
        $data['module_catalog_manager_products_clear'] = $this->request->post['module_catalog_manager_products_clear'] ?? $this->config->get('module_catalog_manager_products_clear');
        $data['module_catalog_manager_filters_clear'] = $this->request->post['module_catalog_manager_filters_clear'] ?? $this->config->get('module_catalog_manager_filters_clear');
        $data['module_catalog_manager_attributes_clear'] = $this->request->post['module_catalog_manager_attributes_clear'] ?? $this->config->get('module_catalog_manager_attributes_clear');
        $data['module_catalog_manager_options_clear'] = $this->request->post['module_catalog_manager_options_clear'] ?? $this->config->get('module_catalog_manager_options_clear');
        $data['module_catalog_manager_manufacturers_clear'] = $this->request->post['module_catalog_manager_manufacturers_clear'] ?? $this->config->get('module_catalog_manager_manufacturers_clear');
        $data['module_catalog_manager_categories_fill'] = $this->request->post['module_catalog_manager_categories_fill'] ?? $this->config->get('module_catalog_manager_categories_fill');
        $data['module_catalog_manager_products_fill'] = $this->request->post['module_catalog_manager_products_fill'] ?? $this->config->get('module_catalog_manager_products_fill');
        $data['module_catalog_manager_filters_fill'] = $this->request->post['module_catalog_manager_filters_fill'] ?? $this->config->get('module_catalog_manager_filters_fill');
        $data['module_catalog_manager_attributes_fill'] = $this->request->post['module_catalog_manager_attributes_fill'] ?? $this->config->get('module_catalog_manager_attributes_fill');
        $data['module_catalog_manager_options_fill'] = $this->request->post['module_catalog_manager_options_fill'] ?? $this->config->get('module_catalog_manager_options_fill');
        $data['module_catalog_manager_manufacturers_fill'] = $this->request->post['module_catalog_manager_manufacturers_fill'] ?? $this->config->get('module_catalog_manager_manufacturers_fill');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/catalog_manager', $data));
    }

    protected function validate(): bool
    {
        if (!$this->user->hasPermission('modify', 'extension/module/catalog_manager')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function manager(): void
    {
        if ($this->config->get('module_catalog_manager_status')) {

            $this->load->model('extension/module/catalog_manager');
            $this->load->language('extension/module/catalog_manager');
            
            if ($this->config->get('module_catalog_manager_categories_clear')) {
                $this->model_extension_module_catalog_manager->clearCategories();
            }
            if ($this->config->get('module_catalog_manager_products_clear')) {
                $this->model_extension_module_catalog_manager->clearProducts();
            }
            if ($this->config->get('module_catalog_manager_filters_clear')) {
                $this->model_extension_module_catalog_manager->clearFilters();
            }
            if ($this->config->get('module_catalog_manager_attributes_clear')) {
                $this->model_extension_module_catalog_manager->clearAttributes();
            }
            if ($this->config->get('module_catalog_manager_options_clear')) {
                $this->model_extension_module_catalog_manager->clearOptions();
            }
            if ($this->config->get('module_catalog_manager_manufacturers_clear')) {
                $this->model_extension_module_catalog_manager->clearManufacturers();
            }
            if ($this->config->get('module_catalog_manager_categories_fill')) {
                $this->model_extension_module_catalog_manager->fillCategories();
            }
            if ($this->config->get('module_catalog_manager_products_fill')) {
                $this->model_extension_module_catalog_manager->fillProducts();
            }
            if ($this->config->get('module_catalog_manager_filters_fill')) {
                $this->model_extension_module_catalog_manager->fillFilters();
            }
            if ($this->config->get('module_catalog_manager_attributes_fill')) {
                $this->model_extension_module_catalog_manager->fillAttributes();
            }
            if ($this->config->get('module_catalog_manager_options_fill')) {
                $this->model_extension_module_catalog_manager->fillOptions();
            }
            if ($this->config->get('module_catalog_manager_manufacturers_fill')) {
                $this->model_extension_module_catalog_manager->fillManufacturers();
            }
        }
    }

    public function install(): void
    {
        $this->load->model('setting/event');

        $this->model_setting_event->deleteEventByCode('module_catalog_manager');

        $this->model_setting_event->addEvent('module_catalog_manager', 'admin/view', 'extension/module/catalog_manager/manager');
    }

    public function uninstall(): void
    {
        $this->load->model('setting/event');

        $this->model_setting_event->deleteEventByCode('module_catalog_manager');
    }
}
