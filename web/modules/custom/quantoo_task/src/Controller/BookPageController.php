<?php

namespace Drupal\quantoo_task\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\views\Views;

/**
 * Controller for the Book page.
 */
class BookPageController extends ControllerBase {

  /**
   * Content method.
   */
  public function content($taxonomy, $node_title) {
    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(['name' => $taxonomy]);

    if (!$terms) {
      throw $this->createNotFoundException();
    }

    $term = reset($terms);

    $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties([
      'type' => 'ksiazka',
      'field_kategoria' => $term->id(),
      'title' => $node_title,
    ]);

    if (empty($nodes)) {
      throw $this->createNotFoundException();
    }

    $node = reset($nodes);

    $render_array = \Drupal::entityTypeManager()
      ->getViewBuilder('node')
      ->view($node, 'full');

    $view = Views::getView('trzy_ostatnie_ksiazki_z_tej_samej_kategorii');

    if (!$view) {
      throw $this->createNotFoundException();
    }

    $view->setArguments([$node->id()]);

    $view->execute();

    $render_array[] = [
      '#markup' => $this->t('Podobne tytuły:'),
      'view_output' => $view->buildRenderable('block_1'),
    ];

    return $render_array;
  }

}
