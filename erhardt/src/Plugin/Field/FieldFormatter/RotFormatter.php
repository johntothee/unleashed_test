<?php

namespace Drupal\erhardt\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'Rot13' formatter.
 *
 * @FieldFormatter(
 *   id = "rot13",
 *   label = @Translation("Rot13"),
 *   field_types = {
 *     "string",
 *     "text",
 *     "text_long",
 *     "text_with_summary"
 *   }
 * )
 */
class RotFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Converts text to Rot13 encoding.');
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) : array {
    $element = [];
    $string = '';
    foreach ($items as $delta => $item) {
      foreach (str_split($item->value) as $index => $char) {
        $ascii = ord($char);
        if (($ascii >= 65  && $ascii <= 90) || ($ascii >= 97 && $ascii <= 122)) {
          // In ascii character range, add 13.
          $new_value = $ascii + 13;
          if ($new_value > 122 || ($new_value > 90 && ord($char) <= 90)) {
            // Should have wrapped, subtract 13 twice.
            $new_value = $ascii - 13;
          }
        }
        else {
          // Pass through non alpha characters.
          $new_value = $ascii;
        }
        $string[$index] = chr($new_value);
      }

      $element[$delta] = [
        '#type' => 'processed_text',
        '#text' => $string,
        '#format' => $item->format,
        '#langcode' => $item->getLangcode(),
      ];
    }
    return $element;
  }

}
