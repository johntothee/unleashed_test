<?php

namespace Drupal\erhardt;

/**
 * Defines an interface for Slugify service.
 */
interface SlugifyServiceInterface {

  /**
   * Convert spaces in a string to special character.
   *
   * @param string $string
   *   The string to be converted.
   * @param string $character
   *   Slug character to use between words.
   *
   * @return string
   *   The slugified string.
   */
  public function convert(string $string, string $character);

}
