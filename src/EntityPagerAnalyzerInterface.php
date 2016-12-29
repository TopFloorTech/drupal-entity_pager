<?php

namespace Drupal\entity_pager;

interface EntityPagerAnalyzerInterface {

  /**
   * @param \Drupal\entity_pager\EntityPagerInterface $entityPager
   * @return null
   */
  function analyze(EntityPagerInterface $entityPager);
}
