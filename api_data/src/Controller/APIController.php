<?php

namespace Drupal\api_data\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Component\Serialization\Json;
use Drupal\node\Entity\Node;


class APIController extends ControllerBase {

  


  
  public function getFact() {
 
    //existing code to fetch the API data goes here.
    $client = \Drupal::httpClient();
    $request = $client->get(
      "https://api.coindesk.com/v1/bpi/currentprice.json"  
    );
    $response = $request->getBody()->getContents();
    return $result = json::decode($response);






    //The echo "<pre>"; statement is used to format the output in a more readable way by wrapping it in <pre> tags. This is commonly done when using print_r() to display an array or object. The <pre> tags preserve whitespace and line breaks, making the output easier to read.
    // echo "<pre>";
    // print_r($result);
    // exit;    
      }
  }




