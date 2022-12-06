<?php

namespace Drupal\generator_entity_pdf\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure generator_entity_pdf settings for this site.
 */
class SettingsForm extends ConfigFormBase {
  
  /**
   *
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'generator_entity_pdf_settings';
  }
  
  /**
   *
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'generator_entity_pdf.settings'
    ];
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $confs = $this->config('generator_entity_pdf.settings');
    $form['orientation'] = [
      '#type' => 'radios',
      '#title' => $this->t('Orientation'),
      '#default_value' => $confs->get('orientation'),
      '#options' => [
        'P' => 'Portrait'
      ]
    ];
    $form['unit'] = [
      '#type' => 'radios',
      '#title' => $this->t('Unit'),
      '#default_value' => $confs->get('unit'),
      '#options' => [
        'mm' => 'mm'
      ]
    ];
    $form['format'] = [
      '#type' => 'radios',
      '#title' => $this->t('Format'),
      '#default_value' => $confs->get('format'),
      '#options' => [
        'A5' => 'A5',
        'A4' => 'A4',
        'A3' => 'A3'
      ]
    ];
    $form['header'] = [
      '#type' => 'details',
      '#title' => $this->t('Display header'),
      '#open' => false
    ];
    $form['header']['show'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show header'),
      '#default_value' => $confs->get('header.show')
    ];
    $form['header']['class'] = [
      '#type' => 'textfield',
      '#title' => $this->t('header custom class'),
      '#default_value' => $confs->get('header.class'),
      '#decription' => " The class method will have two parameters, the object and the entity. The default class is: \Drupal\generator_entity_pdf\GeneratorEntityPdf\PdfEntityHeader "
    ];
    $form['footer'] = [
      '#type' => 'details',
      '#title' => $this->t('Display footer'),
      '#open' => false
    ];
    $form['footer']['show'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show footer'),
      '#default_value' => $confs->get('footer.show')
    ];
    $form['footer']['class'] = [
      '#type' => 'textfield',
      '#title' => $this->t('footer custom class'),
      '#default_value' => $confs->get('footer.class'),
      '#decription' => " The class method will have two parameters, the object and the entity. The default class is: \Drupal\generator_entity_pdf\GeneratorEntityPdf\PdfEntityFooter "
    ];
    return parent::buildForm($form, $form_state);
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $confs = $this->config('generator_entity_pdf.settings');
    $confs->set('orientation', $form_state->getValue('orientation'));
    $confs->set('unit', $form_state->getValue('unit'));
    $confs->set('format', $form_state->getValue('format'));
    $confs->set('header', $form_state->getValue('header'));
    $confs->set('footer', $form_state->getValue('footer'));
    $confs->save();
    parent::submitForm($form, $form_state);
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // validation here;
    parent::validateForm($form, $form_state);
  }
  
}
