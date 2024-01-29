<?php

namespace Drupal\custom_config_form\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class CustomConfigForm.
 *
 * @package Drupal\custom_config_form\Form
 */
class CustomConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['custom_config_form.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_config_form_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('custom_config_form.settings');
    $config_value = $config->get('custom_textfield');

    $form['custom_textfield'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Custom Textfield'),
      '#default_value' => $config_value,
      '#description' => $this->t('Enter your custom text.'),
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save Configuration'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->configFactory->getEditable('custom_config_form.settings');
    $config->set('custom_textfield', $form_state->getValue('custom_textfield'));
    $config->save();
  }

}
