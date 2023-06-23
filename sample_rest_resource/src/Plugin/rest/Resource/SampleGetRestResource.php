<?php

namespace Drupal\sample_rest_resource\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

//PLugin annotations used to provude endpoints
/**
 * 
 * 
 * Provides a resource for custom get
 * @RestResource(
 *  id = "custom_get_rest_resource",
 *  label = @Translation("Custom get REST resource"),
 *  uri_paths = {
 *      "canonical" = "/customtax-restdata"
 *
 *  }
 * 
 * )
 * 
 * 
 * 
 */

class SampleGetRestResource extends ResourceBase
{
   
    public function get()
    {
        // Implementing our custom REST Resource here.
        // $car_id = 'car';
        // $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($car_id);


       
        $taxtermsdata = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadMultiple();
        $response = new ResourceResponse($taxtermsdata);
        return $response;
    }
}
