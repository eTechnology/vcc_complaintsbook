 <?php
 /*
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
 */

 class Vcc_complaintsbookCaptchaModuleFrontController extends ModuleFrontController
 {
     public $ssl = true;

     public function initContent()
     {
        parent::initContent();
        $secretKeyCaptcha = '6LdyD_0UAAAAALY1YgUYjPF-tVKD34BbXg8yiEtk';

        if (!$this->module->isTokenValid(Tools::getValue('mToken'))) {
            $this->errorResponse(['message' => 'Sesión expirada, actuaiza la página por favor'], 403);
        }

        $resApiGoogleCatpcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKeyCaptcha.'&response='.Tools::getValue('token'));
        $response = json_decode($resApiGoogleCatpcha);

        $this->successResponse($response);
     }

     private function successResponse($data)
     {
         ob_end_clean();
         header('Content-Type: application/json');
         die(json_encode($data));
     }

     private function errorResponse($data, $errorCode = 500)
     {
         ob_end_clean();

         switch ($errorCode) {
             case 403:
                 header('HTTP/1.1 403 Forbidden');
                 break;

             default:
                 header('HTTP/1.1 500 Internal Server Error');
                 break;

         }

         header('Content-Type: application/json');
         die(json_encode(['error' => $data]));
     }
 }
