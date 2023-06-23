<?php

namespace Drupal\customtax\Controller;
use Drupal\Core\Controller\ControllerBase;


/**
 * Class vocabcontroller.
 *
 * @package Drupal\customtax\Controller
 */




class vocabcontroller extends ControllerBase
{

/**
     * Summary of display
     * @param mixed $listid
     * @param mixed $vocabid
     * @return void
     */




    // SORTING FUNCTION 
    //first we store all the 'keys' into key_array and then we sort it into asc order or desc order.

    public function sortBy($arr, $key)
    {
        $key_arr = array_column($arr, $key);
        $_GET['sort'] == "asc" ? array_multisort($key_arr, SORT_ASC, $arr) : array_multisort($key_arr, SORT_DESC, $arr);
        return $arr;
    }   


//Function to print the error if wrong path or description is found!
    public function get_error() {
            return ['#type' => 'markup',    
                   '#markup' => t('No records found'),
               ];
           }





//Default Display() method by drupal to display data
    public function display($vocabid, $listid)
    {
       
    //We are using service getStorage() of entityTypeManager()  to fetch data of specific entity type we want(i.e Here taxonomy_term) and we want to load all the data inside it so 'MUltiple' is used
     $taxtermsdata = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadMultiple();





//Condition to search for specific term inside a specific vocabulary!
           if ($listid != NULL && $vocabid != NULL) {

            foreach ($taxtermsdata as $term) {
                if ($term->vid->target_id == $vocabid && $term->tid->value == $listid) {
                    $term_res[] = array(
                        'tid' => $term->tid->value,
                        'name' => $term->name->value,
                        'description' => $term->description->processed == NULL ? 'NO Description' : $term->description->processed,
                        'vocabid' => $term->vid->target_id,
                    );
                }
            }
          
            
            if (!$term_res) {
                return get_error();
              }

        } 






       // Search for a specific vocabulary group!  
        else if ($vocabid != NULL) {
            foreach ($taxtermsdata as $term) {
                if ($term->vid->target_id != $vocabid) continue;
                $term_res[] = array(
                    'tid' => $term->tid->value,
                    'name' => $term->name->value,
                    'description' => $term->description->processed == NULL ? 'No description' : $term->description->processed,
                    'vocabid' => $term->vid->target_id,
                );
            }
        
              if (!$term_res) {
                return get_error();
              }

        }







   // shows all the vocabulary data
        else {
            foreach ($taxtermsdata as $term) {
                    $term_res[] = array(
                    'tid' => $term->tid->value,
                    'name' => $term->name->value,
                    'description' => $term->description->processed == NULL ? 'No description' : $term->description->processed,
                    'vocabid' => $term->vid->target_id,
                );
            }

           if (!$term_res) {
                return get_error();
              }

            }  




       
        


    //SORTING condition that we are sorting our term_res array  on the basis of 'NAME' key.
     if ($_GET['sort'] != NULL) $term_res = $this->sortBy($term_res, 'name');


    //TABLE headers array is all heading titles of the resultant table that we are going to have.
        $table_headers = array(
            'tid' => 'Term ID',
            'name' => 'Term Name',
            'description' => ("Description"),
            'vocabid' => "Vocabulary Name",
        );

     //This is the table that is finally displayed as ouput in drupal website!
        $res['table'] = [
            '#type' => 'table',
            '#title' => 'Taxonomy',
            '#header' => $table_headers,
            '#rows' => $term_res,
        ];

        return $res;
        
             
    }
    
}




















