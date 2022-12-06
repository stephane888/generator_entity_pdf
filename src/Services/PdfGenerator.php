<?php

namespace Drupal\generator_entity_pdf\Services;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\File\FileSystem;
use TCPDF;

class PdfGenerator extends ControllerBase {
  protected $creator = 'TCPDF';
  protected $config;
  protected $Pdf;
  protected $FileSystem;
  
  // function __construct(FileSystem $FileSystem) {
  // $this->FileSystem = $FileSystem;
  // }
  
  /**
   * On initialise le PDF.
   * Doit etre la premiere function à appeler.
   */
  function PdfInit() {
    $confs = $this->getConfig();
    if (!$this->Pdf)
      $this->Pdf = new TCPDF($confs['orientation'], $confs['unit'], $confs['format']);
  }
  
  function saveFile() {
    $this->Pdf->Output("text.pdf", 'D');
  }
  
  function setHeader() {
    $confs = $this->getConfig();
    $this->Pdf->setPrintHeader($confs['header']['show']);
  }
  
  function setFooter() {
    $confs = $this->getConfig();
    $this->Pdf->setPrintFooter($confs['footer']['show']);
  }
  
  protected function getConfig() {
    if (!$this->config) {
      $this->config = $this->config('generator_entity_pdf.settings')->getRawData();
    }
    return $this->config;
  }
  
}
