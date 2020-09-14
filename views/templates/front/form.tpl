{if !$oldVersion}
  {extends file='page.tpl'}

  {block name="page_content"}
{/if}
  <script src="https://www.google.com/recaptcha/api.js?render=6LdyD_0UAAAAAD0hbj0PiU4cfvDBQfEoHxTWegY9"></script>
  <div class="col-sm-8 offset-sm-2">
  <form id="mod-contact-form">
    <div style="height: 20px;"></div>
    <h1 class="title">Libro de Reclamaciones</h1>


    <div id="wrapperErrorNotificacions" style="display: none">
      <div class="alert alert-danger" role="alert">
        <p id="textErrorNotificacion"></p>
      </div>
    </div>
    <div style="height: 30px;"></div>

    <section class="form-fields">
      <div class="form-group row">
        <div class="col-md-9 col-md-offset-3">
          <h3>{l s='Identification' d='Shop.Theme.Global'}</h3>
        </div>
      </div>

      <div class="form-group row">
        <label for="comFirstname" class="col-md-3 form-control-label">{l s='Firstname' mod='vcc_complaintsbook'}</label>
        <div class="col-md-6">
          <input class="form-control" name="from" type="text" id="comFirstname" required>
        </div>
      </div>

      <div class="form-group row">
        <label for="comLastname" class="col-md-3 form-control-label">{l s='Lastname' mod='vcc_complaintsbook'}</label>
        <div class="col-md-6">
          <input class="form-control" name="from" type="text" id="comLastname" required>
        </div>
      </div>

      <div class="form-group row">
        <label for="comDocType" class="col-md-3 form-control-label">{l s='Document' mod='vcc_complaintsbook'}</label>
        <div class="col-md-2">
          <select name="comDocType" id="comDocType" class="form-control form-control-select">
            <option value="DNI">DNI</option>
            <option value="CE">CE</option>
            <option value="RUC">RUC</option>
          </select>
        </div>
        <div class="col-md-4">
          <input class="form-control" name="from" type="text" id="comDocNumber" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
        </div>
      </div>

      <div class="form-group row">
        <label for="comMobile" class="col-md-3 form-control-label">{l s='Mobile' mod='vcc_complaintsbook'}</label>
        <div class="col-md-6">
          <input class="form-control" name="from" type="number" id="comMobile" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
        </div>
      </div>

      <div class="form-group row">
        <label for="email" class="col-md-3 form-control-label">{l s='Email' mod='vcc_complaintsbook'}</label>
        <div class="col-md-6">
          <input class="form-control" name="from" type="email" id="email" required>
        </div>
      </div>
    </section>

    <section class="form-fields">
      <div class="form-group row">
        <div class="col-md-9 col-md-offset-3">
          <h3>{l s='About Complaints' d='Shop.Theme.Global'}</h3>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 form-control-label">{l s='Subject' mod='vcc_complaintsbook'}</label>
        <div class="col-md-6">
          <select name="subject" id="subject" class="form-control form-control-select">
            {foreach from=$contacts item=contact}
              <option value="{$contact.id_contact}">{$contact.name}</option>
            {/foreach}
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label for="message" class="col-md-3 form-control-label">{l s='Detail' mod='vcc_complaintsbook'}</label>
        <div class="col-md-9">
            <textarea
                    id="message"
                    name="message"
                    class="form-control"
                    placeholder="{l s='Describes the problem caused' d='Shop.Forms.Help'}"
                    rows="8"
                    required
            ></textarea>
        </div>
      </div>

      <div class="form-group row">
        <label for="request" class="col-md-3 form-control-label">{l s='Request' mod='vcc_complaintsbook'}</label>
        <div class="col-md-9">
            <textarea
                    id="request"
                    name="request"
                    class="form-control"
                    placeholder="{l s='Describes want you need to soled' mod='vcc_complaintsbook'}"
                    rows="8"
                    required
            ></textarea>
        </div>
      </div>
    </section>


    <footer class="form-footer text-sm-right">
      <style>
        input[name=url] {
          display: none !important;
        }
      </style>
      <input type="text" name="url" value=""/>
      <input type="hidden" name="token" value="{$token}" />
      <button type="submit" class="btn btn-primary g-recaptcha" id="generateComplaintsDispatch"
              data-sitekey="reCAPTCHA_site_key"
              data-callback='onSubmit'
              data-action='submit'>
        <div id="submitLoading" style="display: none">
          <span class="spinner-border" role="status" aria-hidden="true"></span> {l s='Loading...' mod='vcc_complaintsbook'}
        </div>
        <div id="submitDefault">
          <i class="fas fa-book"></i> {l s='Generate' mod='vcc_complaintsbook'}
        </div>
      </button>
    </footer>
    <div style="height: 40px;"></div>
    <small>
      <ul>
        <li><b>*Reclamo:</b> Disconformidad relacionada a los productos o servicios.</li>
        <li><b>*Queja:</b> Disconformidad no relacionada a los productos o servicios; o, malestar o descontento respecto a la atención al público.</li>
      </ul>
    </small>
  </form>
  </div>
{if !$oldVersion}
  {/block}
{/if}
