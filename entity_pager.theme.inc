<?php

use Drupal\entity_pager\EntityPager\EntityPager;

function template_preprocess_views_view_entity_pager(&$variables) {
  /** @var \Drupal\views\Entity\View */
  $view = $variables['view'];

  $options = $view->style_plugin->options;

  $entityPager = new EntityPager($view, $options);

  $variables['entity_pager'] = $entityPager;
  $variables['count_word'] = $entityPager->getCountWord();
  $variables['links'] = $entityPager->getLinks();

  $variables['#attached'] = [
    'library' => ['entity_pager/entity_pager']
  ];
}
