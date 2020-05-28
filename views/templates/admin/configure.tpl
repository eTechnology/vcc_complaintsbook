{*
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
*}

<div class="panel">
	<h3><i class="icon icon-tags"></i> {l s='Documentation' mod='vcc_complaintsbook'}</h3>
  <h4>{l s='IMPORTANT!' mod='vcc_complaintsbook'}</h4>
  <p>{l s='Run this code to modify table %ps_%customer' mod='vcc_complaintsbook' sprintf=['%ps_%' => $prefix]} :</p>
  <code>
    <input style="width: 100%; padding: 10px" value="ALTER TABLE `{$prefix}customer` ADD `mobile` VARCHAR(12) NULL AFTER `email`, ADD `document_type` CHAR(3) NULL AFTER `mobile`, ADD `document_number` VARCHAR(12) NULL AFTER `document_type`;">
  </code>
  <br><br>
  <h4>{l s='Pages' mod='vcc_complaintsbook'}</h4>
  <ul>
    <li><a href="{$urlForm}" target="_blank">{l s='Formulario de Registro' mod='vcc_complaintsbook'}</a></li>
  </ul>
</div>
