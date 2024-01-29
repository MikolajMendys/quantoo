<?php

namespace Drupal\quantoo_task\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\views\Views;

/**
 * Controller for the Author page.
 */
class PublisherPageController extends ControllerBase {

  /**
   * Content method.
   */
  public function content($title) {

    $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties([
      'type' => 'wydawnictwo',
      'title' => $title,
    ]);

    if (empty($nodes)) {
      throw $this->createNotFoundException();
    }

    $node = reset($nodes);

    $render_array = \Drupal::entityTypeManager()
      ->getViewBuilder('node')
      ->view($node, 'full');

    return $render_array;
  }

}
