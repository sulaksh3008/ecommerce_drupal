<?php

namespace Drupal\movie_directory\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class MovieAPI extends FormBase{

    const MOVIE_API_CONFIG_PAGE = 'movie_api_config_page::values';

    public function getFormId()
    {
        return 'movie-api-config-page';
    }
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form = [];
        $values = \Drupal::state()->get(self::MOVIE_API_CONFIG_PAGE);

        $form['api_base_url'] = [
            '#type' => 'textfield',
            '#title' => $this->t('API base URL'),
            '#description' => $this->t('This is the API base URL'),
            '#required' => TRUE,
            '#default_value' => $values['api_base_url'],
        ];

        $form['api_key'] = [
            '#type' => 'textfield',
            '#title' => $this->t('API KEY (v3 auth)'),
            '#description' => $this->t('This is the api key that will be used to access API'),
            '#default_value' => $values['api_key'],
        ];

        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Save'),
            '#button_type' => 'primary'
        ];

        return $form;
    }
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $submitted_values = $form_state->cleanValues()->getValues();

        \Drupal::state()->set(self::MOVIE_API_CONFIG_PAGE ,$submitted_values);
        $messenger = \Drupal::service('messenger');
        $messenger->addMessage($this->t('New Configuratin has been Saved'));
    }
}