<?php


namespace Drupal\api_data\Plugin\Block;

use Drupal\Core\Block\Blockbase;
use Drupal\api_data\Controller\APIController;
use Drupal\Core\Session\AccountInterface;


/**
 * Provides an 'API Data' block.
 *
 * @Block(
 *   id = "api_data_block",
 *   admin_label = @Translation("Bitcoin Prices LIVE!"),
 *   category = @Translation("Custom Category"),
 * )
 */

class ApiDataBlock extends BlockBase
{

  /**
   * {@inheritdoc}
   */


  //build() method  builds and returns the renderable content for the block.
  public function build()
  {

  //Here we are restricting the data of custom block to administrator role only, if condition is true, it will run you rcode below otherwise it will run the empty array

  //So currentUser() service is called which implements Account interface class
  //userroles data->an array of roles associated with the current user account using the getRoles() is retrieved.
  //The in_array() function is used to check for the presence of the 'administrator' role in  userRoles array.
  $currentUser = \Drupal::currentUser();
  $userRoles = $currentUser->getRoles();
  if (!in_array('administrator', $userRoles)) {
    return [];
  }




    $catFactObj = new APIController;
    $factData = $catFactObj->getFact();
    $table = $this->generateTable($factData);
 


   

    return [
     
      '#type' => 'markup',
      '#markup' => $table,
      '#attached' => [
        'library' => [
          'api_data/apiblockcss',
          'api_data/apiblockjs',
        ],
      ],
      '#cache' => [
        'max-age' => 0,
      ],
    ];

  




  }

  /**
   * Generate an HTML table from the API response
   */
  private function generateTable($factData)
  {
    $table = '<table class="api-data-table">';

    // Add the "bpi" fields for USD, GBP, and EUR
    $table .= '<tr><th class = "table-header" colspan="6">Bitcoin Price Index</th></tr>';
    $table .= '<tr>
                    <th>Currency</th>
                    <th>Symbol</th>
                    <th>Rate</th>
                    <th>Description</th>
                    <th>Rate (Float)</th>
                    <th>Time</th>
              </tr>';

    $currencies = ['USD', 'GBP', 'EUR'];

    foreach ($currencies as $currency) {
      $currencyData = $factData['bpi'][$currency];
      $table .= '<tr>';
      $table .= '<td class="api-data-cell">' . $currencyData['code'] . '</td>';
      $table .= '<td class="api-data-cell">' . $currencyData['symbol'] . '</td>';
      $table .= '<td class="api-data-cell">' . $currencyData['rate'] . '</td>';
      $table .= '<td class="api-data-cell">' . $currencyData['description'] . '</td>';
      $table .= '<td class="api-data-cell">' . $currencyData['rate_float'] . '</td>';
      $table .= '<td class="api-data-cell">' . $factData['time']['updated'] . '</td>';

      $table .= '</tr>';
    }

    $table .= '</table>';

    return $table;
  }

}





