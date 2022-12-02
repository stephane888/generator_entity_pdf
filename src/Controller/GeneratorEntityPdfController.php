<?php

namespace Drupal\generator_entity_pdf\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for generator_entity_pdf routes.
 */
class GeneratorEntityPdfController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
