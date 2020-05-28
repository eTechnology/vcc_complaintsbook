{*
* 2007-2015 PrestaShop
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div id="mod-contact-form">
  <h1 class="title">Libro de Reclamaciones</h1>


  <input type="hidden" id="complaints_ajax" value="{$urlAjax}">

  <section class="form-fields">

    <div class="form-group row">
      <div class="col-md-9 col-md-offset-3">
        <h3>{l s='Identification' d='Shop.Theme.Global'}</h3>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-3 form-control-label">{l s='Firstname' d='Shop.Forms.Labels'}</label>
      <div class="col-md-6">
        <input class="form-control" name="from" type="text" id="comFirstname">
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-3 form-control-label">{l s='Lastname' d='Shop.Forms.Labels'}</label>
      <div class="col-md-6">
        <input class="form-control" name="from" type="text" id="comLastname">
      </div>
    </div>

    <div class="form-group row">

      <label class="col-md-3 form-control-label">{l s='Document' d='Shop.Forms.Labels'}</label>
      <div class="col-md-2">
        <select name="comDocType" id="comDocType" class="form-control form-control-select">
          <option value="DNI">DNI</option>
          <option value="CE">CE</option>
          <option value="RUC">RUC</option>
        </select>
      </div>
      <div class="col-md-4">
        <input class="form-control" name="from" type="text" id="comDocNumber">
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-3 form-control-label">{l s='Mobile' d='Shop.Forms.Labels'}</label>
      <div class="col-md-6">
        <input class="form-control" name="from" type="number" id="comMobile">
      </div>
    </div>

  </section>
</div>
