<?php

namespace Drupal\entity_pager;

use Drupal\Core\Utility\Token;
use Drupal\views\ViewExecutable;

class EntityPagerFactory {

  /** @var Token The token service. */
  protected $token;

  /** @var array */
  protected $default_options = [
    'link_next' => 'next >',
    'link_prev' => '< prev',
    'link_all_url' => '<front>',
    'link_all_text' => 'Home',
    'display_all' => TRUE,
    'display_count' => TRUE,
    'log_performance' => TRUE,
  ];

  /**
   * EntityPagerFactory constructor.
   *
   * @param \Drupal\Core\Utility\Token $token
   *   The token service.
   */
  public function __construct(Token $token) {
    $this->token = $token;
  }

  public function get(ViewExecutable $view, $options = []) {
    return new EntityPager($view, $options + $this->default_options, $this->token);
  }

}
