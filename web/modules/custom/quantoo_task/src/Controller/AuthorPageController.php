<?php

namespace Drupal\quantoo_task\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\views\Views;

/**
 * Controller for the Author page.
 */
class AuthorPageController extends ControllerBase {

  /**
   * Content method.
   */
  public function content($name_and_surname) {

    list($first_name, $last_name) = explode('-', $name_and_surname, 2);

    $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties([
      'type' => 'autor',
      'field_imie' => $first_name,
      'title' => $last_name,
    ]);

    if (empty($nodes)) {
      throw $this->createNotFoundException();
    }

    $node = reset($nodes);

    $render_array = \Drupal::entityTypeManager()
      ->getViewBuilder('node')
      ->view($node, 'full');

    $view = Views::getView('ksiazki_danego_autora');

    if (!$view) {
      throw $this->createNotFoundException();
    }

    $view->setArguments([$node->id()]);

    $view->execute();

    $render_array[] = [
      '#markup' => $this->t('Książki autora:'),
      'view_output' => $view->buildRenderable('block_1'),
    ];

    return $render_array;
  }

}
