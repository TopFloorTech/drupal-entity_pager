<?php

namespace Drupal\entity_pager;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\TypedData\TranslatableInterface;
use Drupal\views\ResultRow;

/**
 * A class representing a single Entity Pager link.
 */
class EntityPagerLink implements EntityPagerLinkInterface {

  use StringTranslationTrait;

  /**
   * @var \Drupal\views\ResultRow|NULL
   */
  var $resultRow;

  /**
   * @var string
   */
  var $text;

  /**
   * EntityPagerLink constructor.
   *
   * @param string $text
   *   The text of the link
   * @param \Drupal\views\ResultRow|NULL $resultRow
   *   The result row in the view to link to.
   */
  public function __construct($text, ResultRow $resultRow = NULL) {
    $this->text = $text;
    $this->resultRow = $resultRow;
  }

  /**
   * {@inheritdoc}
   */
  public function getLink() {
    if (empty($this->resultRow)) {
      return $this->noResult();
    }

    $langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();
    $text = $this->t($this->text, [], ['langcode' => $langcode]);
    $entity = $this->resultRow->_entity;
    if ($entity instanceof TranslatableInterface && $entity->hasTranslation($langcode)) {
      $entity = $entity->getTranslation($langcode);
    }

    return [
      '#type' => 'link',
      '#title' => ['#markup' => $text],
      '#url' => $entity->toUrl('canonical'),
    ];
  }

  /**
   * Returns a render array for an entity pager link with no results.
   *
   * @return array
   *   The render array for the link with no results.
   */
  protected function noResult() {
    return [
      '#type' => 'markup',
      '#markup' => '<span class="inactive">' . $this->t($this->text) . '</span>',
    ];
  }
}
