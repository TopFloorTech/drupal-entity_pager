<?php

namespace Drupal\entity_pager;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;
use Drupal\views\ResultRow;
use Drupal\views\ViewExecutable;

/**
 * Abstract class EntityPager.
 */
class EntityPager implements EntityPagerInterface {

  /** @var array */
  protected $options = [
    'link_next' => 'next >',
    'link_prev' => '< prev',
    'link_all_url' => '<front>',
    'link_all_text' => 'Home',
    'display_all' => TRUE,
    'display_count' => TRUE,
    'log_performance' => TRUE,
  ];

  /** @var ViewExecutable */
  protected $view;

  /**
   * EntityPager constructor.
   *
   * @param ViewExecutable $view
   *   The view object.
   * @param array $options
   *   An array of options for the EntityPager.
   */
  public function __construct(ViewExecutable $view, $options = []) {
    $this->view = $view;
    $this->options = $options + $this->options;
  }

  /**
   * {@inheritdoc}
   */
  public function getView() {
    return $this->view;
  }

  /**
   * {@inheritdoc}
   */
  public function getLinks() {
    $links = [
      'prev' => $this->getLink('link_prev', -1),
      'all' => $this->getAllLink(),
      'next' => $this->getLink('link_next', 1),
      'count' => $this->getCount(),
    ];

    return $links;
  }

  protected function getCurrentRow() {
    foreach ($this->getView()->result as $index => $result) {
      /** @var ResultRow $result */

      $resultEntity = $result->_entity;

      $entity = $this->getEntity();

      if (!is_null($entity) && $resultEntity->id() == $entity->id()) {
        return $index;
      }
    }

    return FALSE;
  }

  protected function getAllLink() {
    $link = [];

    if ($this->options['display_all']) {
      $url = $this->detokenize($this->options['link_all_url']);

      if (!in_array(substr($url, 0, 1), ['/', '#', '?'])) {
        $url = '/' . $url;
      }

      $link = [
        '#type' => 'link',
        '#title' => $this->detokenize($this->options['link_all_text']),
        '#url' => Url::fromUserInput($url),
      ];
    }

    return $link;
  }

  protected function getResultRow($index) {
    return isset($this->view->result[$index])
      ? $this->view->result[$index]
      : NULL;
  }

  protected function getLink($name, $offset = 0) {
    $link = new EntityPagerLink($this->options[$name], $this->getResultRow($this->getCurrentRow() + $offset));

    return $link->getLink();
  }

  protected function getCount() {
    $count = [];

    if ($this->options['display_count']) {
      $current = $this->getCurrentRow();

      $count = [
        '#type' => 'markup',
        '#markup' => t('@cnt of <span class="total">@count</span>', [
          '@cnt' => number_format($current + 1),
          '@count' => number_format($this->view->total_rows),
        ]),
      ];
    }

    return $count;
  }

  /**
   * Replace all tokens in provided string, supporting the current entity from
   * the request object.
   *
   * @param string $string
   *   The string to detokenize.
   *
   * @return string
   *   The detokenized string.
   */
  protected function detokenize($string) {
    $data = [$this->getEntityType() => $this->getEntity()];

    return \Drupal::token()->replace($string, $data);
  }

  /**
   * {@inheritdoc}
   */
  public function getCountWord() {
    $count = 'invalid';

    if (isset($this->getView()->total_rows)) {
      switch ($this->getView()->total_rows) {
        case 0:
          $count = 'none';
          break;
        case 1:
          $count = 'one';
          break;
        default:
          $count = 'many';
      };
    }

    return $count;
  }

  /**
   * Returns the entity type that this pager is using.
   *
   * @return string
   */
  public function getEntityType() {
    return $this->getView()->getBaseEntityType()->id();
  }

  /**
   * Gets the entity object this entity pager is for.
   *
   * @return EntityInterface
   *   The entity object.
   */
  public function getEntity() {
    return \Drupal::routeMatch()->getParameter($this->getEntityType());
  }

  /**
   * {@inheritdoc}
   */
  public function getOptions() {
    return $this->options;
  }
}
