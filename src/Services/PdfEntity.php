<?php

namespace Drupal\generator_entity_pdf\Services;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\File\FileSystem;
use Drupal\Core\Render\Renderer;

/**
 * Permet de generer les PDF pour les entitées.
 *
 * @author stephane
 *        
 */
class PdfEntity extends PdfGenerator {
  
  function __construct(Renderer $Renderer) {
    // $this->FileSystem = $FileSystem;
    $this->Renderer = $Renderer;
  }
  
  /**
   *
   * @param EntityInterface $entity
   */
  function buildPdf(EntityInterface $entity) {
    $this->PdfInit();
    $this->setEntityInformation($entity);
    $this->setHeader();
    $this->setFooter();
    $this->setContent($entity);
    $this->saveFile();
  }
  
  /**
   * Add entity content in PDF.
   *
   * @param EntityInterface $entity
   */
  function setContent(EntityInterface $entity) {
    $this->Pdf->AddPage();
    $view_site_type_datas = $this->entityTypeManager()->getViewBuilder($entity->getEntityTypeId());
    $entityView = $view_site_type_datas->view($entity);
    $style = $this->importStyle();
    /**
     *
     * @var \Drupal\Component\Render\MarkupInterface $renderEntity
     */
    $renderEntity = $this->Renderer->renderRoot($entityView);
    $htmlP = $renderEntity->__toString();
    $htmlP = \str_replace("\n", "", $htmlP);
    $htmlP = \str_replace("\t", "", $htmlP);
    $html = $style;
    $html .= $htmlP;
    // dd($html);
    // print a block of text using Write()
    $this->Pdf->writeHTML($html, true, false, true, false, '');
  }
  
  public function importStyle() {
    $style = '<style>';
    $style .= file_get_contents('http://wb-horizon.kksa/themes/custom/wb_horizon_kksa/css/vendor-style.css?rmfcje');
    // $style .=
    // file_get_contents('http://wb-horizon.kksa/themes/custom/wb_horizon_kksa/css/global-style.css?rmfcje');
    $style .= '</style>';
    return $style;
  }
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\generator_entity_pdf\Services\PdfGenerator::setHeader()
   */
  function setHeader() {
    parent::setHeader();
    $confs = $this->getConfig();
    if ($confs['header']['show']) {
      // apply constom header.
    }
  }
  
  function setFooter() {
    parent::setFooter();
    $confs = $this->getConfig();
    if ($confs['footer']['show']) {
      // apply constom footer.
    }
  }
  
  function saveFile() {
    $this->Pdf->Output("text.pdf", 'D');
  }
  
  /**
   * set document information.
   * On recupere si possible les informations sur le createur du contenu.
   */
  protected function setEntityInformation(EntityInterface $entity) {
    $this->Pdf->setCreator($this->creator);
    $this->Pdf->setTitle($entity->label());
    $this->Pdf->setSubject($entity->label());
    $keywords = [
      'Drupal',
      'generator_entity_pdf',
      $entity->getEntityTypeId()
    ];
    $this->Pdf->setKeywords(implode(",", $keywords));
    if (method_exists($entity, 'getOwnerId')) {
      /**
       *
       * @var \Drupal\Core\Entity\ContentEntityInterface $content
       */
      $content = $entity;
      /**
       *
       * @var \Drupal\user\Entity\User $user
       */
      $user = $content->getOwner();
      if (!$user->isAnonymous()) {
        $this->Pdf->setAuthor($user->label());
      }
    }
  }
  
}