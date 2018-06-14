<?php

/* Make names pace of the controller */

namespace Drupal\siteapikey\Controller;

/* Use class */
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Access\AccessResult; 
use Drupal\node\Entity\Node;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Create controller.
 */
class ApiPageController extends ControllerBase{

/**
* {@inheritdoc}
*/
public function ApiPage(){
    $parameters = \Drupal::request()->getpathInfo();
    $arg  = explode('/',$parameters); 
    $node_exist = \Drupal::entityQuery('node')->condition('nid',$arg[3])->execute();
    $node_load = isset($node_exist) ? Node::load($arg[3]): null;
    $it_is_page_node = isset($node_load) ? $node_load->get('type')->getValue()[0]['target_id'] == 'page' : false;
    $api_key_check = $arg[2];
    $db_api_key = \Drupal::state()->get('siteapikey');
    if($node_exist && $it_is_page_node && ($api_key_check === $db_api_key)) {
      $field_defs = $node_load->getFieldDefinitions();
      $node_fields = array();
      foreach ($field_defs as $field_name => $val) {
        $node_fields[$field_name] = trim($node_load->get($field_name)->getValue()[0]['value']);
      }
      $node_fields[site_api_key] = $db_api_key;
      /* */
      $newArray = array_map(function($v){
        return trim(strip_tags($v));
      }, $node_fields);
      header("Content-type: application/json"); 
      $res = json_encode($newArray);
      return array(
        '#markup' => $res
      );
    }
    else{
      throw new AccessDeniedHttpException();
    }
	}
}
