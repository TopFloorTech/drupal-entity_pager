<?php

namespace Drupal\entity_pager\EventSubscriber;

use Drupal\entity_pager\Event\EntityPagerAnalyzeEvent;
use Drupal\entity_pager\Event\EntityPagerEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ViewsPerformanceAnalyzerSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events = [];

    $events[EntityPagerEvents::ENTITY_PAGER_ANALYZE][] = ['onEntityPagerAnalyze'];

    return $events;
  }

  public function onEntityPagerAnalyze(EntityPagerAnalyzeEvent $event) {
    $options = $event->getEntityPager()->getOptions();

    if (!$options['log_performance']) {
      return;
    }

    // TODO: Log performance issues about the view
  }
}
