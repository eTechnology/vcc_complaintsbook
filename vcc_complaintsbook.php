<?php
/**
* 2007-2020 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2020 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class Vcc_complaintsbook extends Module implements WidgetInterface
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'vcc_complaintsbook';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Victor Castro';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->tokenComplaintsBook = Tools::hash($this->name.date('YmdH'));
        $this->displayName = $this->l('Complaints book');
        $this->description = $this->l('Custom form complaints book');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => '1.8');
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        include(dirname(__FILE__).'/sql/alter.php');

        Configuration::updateValue('VCC_COMPLAINTSBOOK_LIVE_MODE', false);

        return parent::install() &&
            $this->registerHook('header');
    }

    public function uninstall()
    {
        Configuration::deleteByName('VCC_COMPLAINTSBOOK_LIVE_MODE');

        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitVcc_complaintsbookModule')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign([
            'module_dir' => $this->_path,
            'prefix' => _DB_PREFIX_,
            'urlForm' => $this->context->link->getModuleLink($this->name,'form', [], Configuration::get('PS_SSL_ENABLED'))
        ]);

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $output.$this->renderForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitVcc_complaintsbookModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        // return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Live mode'),
                        'name' => 'VCC_COMPLAINTSBOOK_LIVE_MODE',
                        'is_bool' => true,
                        'desc' => $this->l('Use this module in live mode'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-envelope"></i>',
                        'desc' => $this->l('Enter a valid email address'),
                        'name' => 'VCC_COMPLAINTSBOOK_ACCOUNT_EMAIL',
                        'label' => $this->l('Email'),
                    ),
                    array(
                        'type' => 'password',
                        'name' => 'VCC_COMPLAINTSBOOK_ACCOUNT_PASSWORD',
                        'label' => $this->l('Password'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'VCC_COMPLAINTSBOOK_LIVE_MODE' => Configuration::get('VCC_COMPLAINTSBOOK_LIVE_MODE', true),
            'VCC_COMPLAINTSBOOK_ACCOUNT_EMAIL' => Configuration::get('VCC_COMPLAINTSBOOK_ACCOUNT_EMAIL', 'contact@prestashop.com'),
            'VCC_COMPLAINTSBOOK_ACCOUNT_PASSWORD' => Configuration::get('VCC_COMPLAINTSBOOK_ACCOUNT_PASSWORD', null),
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookDisplayGDPRConsent()
    {
        $urlAjax = $this->context->link->getModuleLink($this->name,'ajax', ['mToken' => $this->tokenComplaintsBook], Configuration::get('PS_SSL_ENABLED'));
        $this->context->smarty->assign([
            'urlAjax' => $urlAjax,
        ]);
        return $this->display(__FILE__, './views/templates/hook/contact-form.tpl');
    }

    public function hookHeader()
    {
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    public function isTokenValid($token)
    {
        return strcasecmp($this->tokenComplaintsBook, $token) == 0;
    }

    public function renderWidget($hookName, array $configuration)
    {
        // TODO: Implement renderWidget() method.
    }

    public function getWidgetVariables($hookName, array $configuration)
    {
        // TODO: Implement getWidgetVariables() method.
    }

    public function generateComplaint($params)
    {
        $id_customer = $this->insertCustomer($params);
        $id_customer_thread = $this->insertNewThread($id_customer, $params);
        $id_customer_message = $this->insertCustomerMessage($id_customer_thread, $params);

        return ['id_customer' => $id_customer, 'id_customer_thread' => $id_customer_thread, 'id_customer_message' => $id_customer_message];
    }

    public function insertCustomer($params)
    {
        $id_customer = 0;
        $existCustomer = Customer::getCustomersByEmail($params['email']);
        if (count($existCustomer) > 0) {
            $id_customer = $existCustomer[0]['id_customer'];
        } else {
            $fields = [
                'id_gender' => 1,
                'active' => 1,
                'is_guest' => 1,
                'id_lang' => $this->context->language->id,
                'firstname' => $params['firstname'],
                'lastname' => $params['lastname'],
                'document_type' => $params['document_type'],
                'document_number' => $params['document_number'],
                'mobile' => $params['mobile'],
                'email' => $params['email'],
                'max_payment_days' => 0,
                'secure_key' => md5(uniqid(mt_rand(0, mt_getrandmax()), true)),
                'last_passwd_gen' => date('Y-m-d H:i:s', strtotime('-' . Configuration::get('PS_PASSWD_TIME_FRONT') . 'minutes')),
                'date_add' => date('Y-m-d H:m:s'),
                'date_upd' => date('Y-m-d H:m:s'),
            ];

            if (Db::getInstance()->insert('customer', $fields)) {
                $id_customer = Db::getInstance()->Insert_ID();
            }
        }
        return $id_customer;
    }

    public function insertNewThread($id_customer, $params)
    {
        $id_customer_thread = 0;
        $fields = [
            'id_shop' => $this->context->shop->id,
            'id_lang' => $this->context->language->id,
            'id_contact' => $params['id_contact'],
            'id_customer' => $id_customer,
            'id_order' => 0,
            'id_product' => isset($params['id_product']) ? $params['id_product'] : 0,
            'email' => $params['email'],
            'token' => Tools::passwdGen(12),
            'date_add' => date('Y-m-d H:m:s'),
            'date_upd' => date('Y-m-d H:m:s'),
        ];

        if (Db::getInstance()->insert('customer_thread', $fields)) {
            $id_customer_thread = Db::getInstance()->Insert_ID();
        }

        return $id_customer_thread;
    }

    public function insertCustomerMessage($id_customer_thread, $params)
    {
        $id_customer_message = 0;
        $message = "";

        if (isset($params['message']) && $params['message'] != "") {
            $message .= 'Detalle: \n'.$params['message'];
        }

        if (isset($params['request']) && $params['request'] != '') {
            $message .= '\n\n Pedido:\n'.$params['request'];
        }

        $fields = [
            'id_customer_thread' => $id_customer_thread,
            'id_employee' => 0,
            'message' => $message,
            'date_add' => date('Y-m-d H:m:s'),
            'date_upd' => date('Y-m-d H:m:s'),
        ];

        if (Db::getInstance()->insert('customer_message', $fields)) {
            $id_customer_message = Db::getInstance()->Insert_ID();
        }

        return $id_customer_message;
    }
}
