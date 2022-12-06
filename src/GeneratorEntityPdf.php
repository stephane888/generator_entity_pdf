<?php

namespace Drupal\generator_entity_pdf;

use TCPDF;
use Drupal\Core\Entity\EntityInterface;

class GeneratorEntityPdf {
  
  static function PdfEntityHeader(TCPDF $Pdf, EntityInterface $entity) {
    //
  }
  
  static function PdfEntityFooter(TCPDF $Pdf, EntityInterface $entity) {
    //
  }
  
}