<?php

namespace Drupal\erhardt;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\erhardt\SlugifyServiceInterface;
use Cocur\Slugify\Slugify;

/**
 * Provides Slugify library as a service.
 */
class SlugifyService implements SlugifyServiceInterface {

  /**
   * {@inheritdoc}
   */
  public function convert(string $string, string $separator = '-') :string {
    $slugify = new Slugify();
    return $slugify->slugify($string, $separator);
  }

}
