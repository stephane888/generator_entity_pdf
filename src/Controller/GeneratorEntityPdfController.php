<?php

namespace Drupal\generator_entity_pdf\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\generator_entity_pdf\Services\PdfEntity;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Render\Renderer;
use Dompdf\Dompdf;

/**
 * Returns responses for generator_entity_pdf routes.
 */
class GeneratorEntityPdfController extends ControllerBase {
  protected $PdfEntity;
  protected $Renderer;
  
  /**
   *
   * @param PdfEntity $PdfEntity
   * @param Renderer $Renderer
   */
  function __construct(PdfEntity $PdfEntity, Renderer $Renderer) {
    $this->PdfEntity = $PdfEntity;
    $this->Renderer = $Renderer;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('generator_entity_pdf.entity'), $container->get('renderer'));
  }
  
  /**
   * Builds the response.
   */
  public function build($entity_type_id, $id) {
    try {
      $build['content'] = [
        '#type' => 'item',
        '#markup' => $this->t(' Generate PDF. ')
      ];
      $entity = $this->entityTypeManager()->getStorage($entity_type_id)->load($id);
      if ($entity) {
        // dump($entity->getEntityTypeId());
        $view_site_type_datas = $this->entityTypeManager()->getViewBuilder($entity_type_id);
        $entityView = $view_site_type_datas->view($entity);
        $renderEntity = $this->Renderer->renderRoot($entityView);
        $htmlP = $renderEntity->__toString();
        $html = $this->importStyle();
        $html .= $htmlP;
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        // Render the HTML as PDF
        $dompdf->render();
        
        // Output the generated PDF to Browser
        $dompdf->stream();
      }
    }
    catch (\Exception $e) {
      //
    }
    return $build;
  }
  
  public function importStyle() {
    $style = '<style>';
    $style .= file_get_contents('http://wb-horizon.kksa/themes/custom/wb_horizon_kksa/css/vendor-style.css?rmfcje');
    $style .= file_get_contents('http://wb-horizon.kksa/themes/custom/wb_horizon_kksa/css/global-style.css?rmfcje');
    $style .= '</style>';
    return $style;
  }
  
  /**
   * Builds the response.
   */
  public function buildOld($entity_type_id, $id) {
    try {
      $build['content'] = [
        '#type' => 'item',
        '#markup' => $this->t(' Generate PDF. ')
      ];
      $entity = $this->entityTypeManager()->getStorage($entity_type_id)->load($id);
      if ($entity) {
        // dump($entity->getEntityTypeId());
        // $view_site_type_datas =
        // $this->entityTypeManager()->getViewBuilder($entity_type_id);
        // $entity = $view_site_type_datas->view($entity);
        // $renderEntity = $this->Renderer->renderRoot($entity);
        $this->PdfEntity->buildPdf($entity);
      }
    }
    catch (\Exception $e) {
      //
    }
    return $build;
  }
  
}
