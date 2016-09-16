<?php

namespace Drupal\downloads_widget\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class DownloadsWidgetForm.
 *
 * @package Drupal\downloads_widget\Form
 */
class DownloadsWidgetForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'downloads_widget';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
      
    $form['#attributes']['class'][] = 'redform';  
    $form['#attributes']['style'] = 'width: 300px; padding: 20px 35px 60px 35px; border:1px solid #ccc;>';

      
      
   $form['filename'] = [
      '#type' => 'select',
      '#title' => $this->t('Filename'),
       '#required' => TRUE,
      '#description' => $this->t('Select the file that you want to download.'),
      '#options' => $this->getDocuments(),
      '#size' => 1,
    ];



    $form['email'] = array(
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => FALSE,
      '#attributes' => array (
        'placeholder' => 'email@adress.com'
        ),
    );
        
        
    $form['pass_phrase'] = array(
    '#type' => 'textfield',
    '#title' => $this->t('Pass phrase'),
    '#size' => 60,
    '#required' => TRUE,
    /* '#attributes' => array (
           'onclick' => 'getElementById("edit-pass-phrase").classList.remove("error");',
           'onfocus' => '$(".messages--error").hide();'
        ),*/
    );    
      
    $form['submit'] = [
        '#type' => 'submit',
        '#value' => t('Download'),
        '#attributes' => array (
           'style' => 'border-radius: 2px; margin:12px 0; float: right;'
        ),
    ];
      
    return $form;
  }

  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    $uri = $form_state->getValue('filename');
    
   $pass_phrase = $form_state->getValue('pass_phrase');
    If ($pass_phrase != 'drupal') {
        $form_state->setErrorByName('pass_phrase', t('You entered the wrong pass phrase, please try again'));
    }
      
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    $uri = $form_state->getValue('filename');
    $response = new BinaryFileResponse($uri);
    $response->setContentDisposition('attachment');
    $form_state->setResponse($response);
  }

    /**
    * Helper functions that returns documents.
    */
  public function getDocuments() {
    $documents_query = \Drupal::database()->select('file_managed', 'f')
      ->condition('f.type', 'document')
      ->fields('f', array('filename', 'uri'))
      ->execute()
      ->fetchAll();
    $documents = array();
    foreach ($documents_query as $document) {
      $documents[$document->uri] = $document->filename;  
    }
    return $documents;
  }    
    
    
    
}





