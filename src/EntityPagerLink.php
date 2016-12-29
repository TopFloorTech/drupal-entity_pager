<?php

namespace Drupal\entity_pager;

use Drupal\views\ResultRow;

class EntityPagerLink implements EntityPagerLinkInterface {

  var $resultRow;

  var $text;

  public function __construct($text, ResultRow $resultRow = NULL) {
    $this->text = $text;
    $this->resultRow = $resultRow;
  }

  /**
   * @return array
   *   A render array for the link
   */
  public function getLink() {
    if (empty($this->resultRow)) {
      return $this->noResult();
    }

    return [
      '#type' => 'link',
      '#title' => $this->text,
      '#url' => $this->resultRow->_entity->toUrl('canonical'),
    ];
  }

  protected function noResult() {
    return [
      '#type' => 'markup',
      '#markup' => '<span class="inactive">' . $this->text . '</span>',
    ];
  }
}
