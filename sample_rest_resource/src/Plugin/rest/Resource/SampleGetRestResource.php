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
        // Use currently logged user after passing authentication and validating the access of term list.
        // if (!$this->loggedUser->hasPermission('access content')) throw new AccessDeniedHttpException();

        // $car_id = 'car';
        // $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($car_id);
        $taxtermsdata = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadMultiple();
        // foreach ($terms as $term) {
        //     $term_res[] = array(
        //         'id' => $term->tid,
        //         'name' => $term->name,
        //     );
        // }

        $response = new ResourceResponse($taxtermsdata);
     
        return $response;
    }
}