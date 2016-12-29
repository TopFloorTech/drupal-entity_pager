<?php

namespace Drupal\entity_pager;

interface EntityPagerLinkInterface {
  /**
   * @return array
   *   A render array for the link
   */
  public function getLink();
}
