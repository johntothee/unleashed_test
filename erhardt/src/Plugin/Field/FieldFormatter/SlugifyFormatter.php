<?php

namespace Drupal\erhardt\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\erhardt\SlugifyServiceInterface;

/**
 * Plugin implementation of the 'Slugify' formatter.
 *
 * @FieldFormatter(
 *   id = "slugify",
 *   label = @Translation("Slugify"),
 *   field_types = {
 *     "string",
 *     "text",
 *     "text_long",
 *     "text_with_summary"
 *   }
 * )
 */
class SlugifyFormatter extends FormatterBase implements ContainerFactoryPluginInterface {

  /**
   * The Slugify service.
   *
   * @var \Drupal\erhardt\SlugifyServiceInterface
   */
  protected $slugify;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('slugify.service')
    );
  }

  /**
   * Constructs a new SlugifyFormatter.
   *
   * @param string $plugin_id
   *   The plugin_id for the formatter.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the formatter is associated.
   * @param array $settings
   *   The formatter settings.
   * @param string $label
   *   The formatter label display setting.
   * @param string $view_mode
   *   The view mode.
   * @param array $third_party_settings
   *   Third party settings.
   * @param \Drupal\erhardt\SlugifyServiceInterface $slugify_service
   *   The slugify service.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, SlugifyServiceInterface $slugify_service) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);

    $this->slugify = $slugify_service;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary(): array {
    $summary = [];
    $summary[] = $this->t('Converts spaces to a special character.');
    $summary[] = $this->t('Using character: @character', [
      '@character' => $this->getSetting('slug_character'),
    ]);
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];

    foreach ($items as $delta => $item) {

      $element[$delta] = [
        '#type' => 'processed_text',
        '#text' => $this->slugify->convert($item->value, $this->getSetting('slug_character')),
        '#format' => $item->format,
        '#langcode' => $item->getLangcode(),
      ];
    }
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state): array {
    $form = parent::settingsForm($form, $form_state);

    $form['slug_character'] = [
      '#title' => $this->t('Slug character'),
      '#type' => 'select',
      '#options' => [
        '-' => $this->t('dash'),
        '_' => $this->t('underscore'),
        '.' => $this->t('period'),
      ],
      '#default_value' => $this->getSetting('slug_character'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    $settings = [];

    // Fall back to field settings by default.
    $settings['slug_character'] = '-';
    return $settings;
  }

}
