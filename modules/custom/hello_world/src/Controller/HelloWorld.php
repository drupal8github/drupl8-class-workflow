<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;
use \Drupal\node\Entity\Node;


/**
 * Class HelloWorld.
 *
 * @package Drupal\hello_world\Controller
 */
class HelloWorld extends ControllerBase {

  /**
   * Hello.
   *
   * @return string
   *   Return Hello string.
   */
  public function hello($nid) {
    $node = Node::load($nid);
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Node Title: ' . $node->getTitle() . '<br>Node Type: ' . $node->getType()),
    ];
  }

}
