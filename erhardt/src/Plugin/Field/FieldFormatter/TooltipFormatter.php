<?php

namespace Drupal\erhardt\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'Tooltip' formatter.
 *
 * @FieldFormatter(
 *   id = "tooltip",
 *   label = @Translation("Tooltip"),
 *   field_types = {
 *     "string",
 *     "text",
 *     "text_long",
 *     "text_with_summary"
 *   }
 * )
 */
class TooltipFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Adds hardcoded tool tip to text field');
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) : array {
    $elements = [];
    $elements['#theme'] = 'tooltip_field_formatter';
    $elements['#attached']['library'][] = 'erhardt/erhardtcustom';

    foreach ($items as $delta => $item) {
      $elements['items'][] = $item;
    }
    return $elements;
  }

}
