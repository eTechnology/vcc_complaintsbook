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
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/

document.getElementById('mod-contact-form').addEventListener('submit', (e) => {
  e.preventDefault();

  const firstname = document.getElementById('comFirstname').value;
  const lastname = document.getElementById('comLastname').value;
  const docType = document.getElementById('comDocType').value;
  const docNumber = document.getElementById('comDocNumber').value;
  const mobile = document.getElementById('comMobile').value;
  const email = document.getElementById('email').value;
  const subject = document.getElementById('subject').value;
  const message = document.getElementById('message').value;
  const request = document.getElementById('request').value;

  document.getElementById('wrapperErrorNotificacions').style.display = "none";
  document.getElementById('generateComplaintsDispatch').disabled = true;
  document.getElementById('submitLoading').style.display = "block";
  document.getElementById('submitDefault').style.display = "none";

  grecaptcha.ready(() => {
    grecaptcha.execute('6LdyD_0UAAAAAD0hbj0PiU4cfvDBQfEoHxTWegY9', {action: 'submit'})
      .then((token) => {
        return validateCaptcha(token);
      })
      .then((resCaptcha) => {
        if (resCaptcha.success) {
            return generateComplaint({
              firstname,
              lastname,
              docType,
              docNumber,
              mobile,
              email,
              subject,
              message,
              request
            })
        }
      })
      .then(res => {
        window.location.href = urlSuccessComplaintsBook+'&thread='+res.id_customer_thread;
      })
      .catch(e => {
        console.log('catch');
        document.getElementById('wrapperErrorNotificacions').style.display = "block";
        document.getElementById('textErrorNotificacion').outerHTML = e.responseJSON.error.message;
        $(window).scrollTop(0);

      })
      .finally(() => {
        console.log('finally');
        document.getElementById('submitLoading').style.display = "none";
        document.getElementById('submitDefault').style.display = "block";
        document.getElementById('generateComplaintsDispatch').disabled = false;
      })
  });


});

function validateCaptcha(token) {
  return new Promise((resolve, reject) => {
    $.ajax({
      type: 'POST',
      url: urlAjaxComplaintsCaptcha,
      data : {token},
      success : function(data) {
        resolve(data);
      },
      error: function (error) {
        reject(error)
      }
    });
  });
}

function generateComplaint(params) {
  return new Promise((resolve, reject) => {
    $.ajax({
      type: 'POST',
      url: urlAjaxComplaintsBook,
      data : params,
      success : function(data) {
        resolve(data);
      },
      error: function (error) {
        reject(error)
      }
    });
  });
}
