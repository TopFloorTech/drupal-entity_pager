<?php

namespace Drupal\entity_pager;

use Drupal\Core\Entity\EntityInterface;
use Drupal\views\ViewExecutable;

/**
 * Interface EntityPagerInterface.
 *
 * Provides a base Class setup for the EntityPagerOut Class.
 * This Class contains house keeping functions for EntityPager.
 * EntityPagerOut inherits this class and does the Business Logic.
 *
 * The main things that happening in this class:
 *
 * 1) the $view is used to automatically work out the Entity & Field of interest
 * e.g. it is a Node and the nid is the field of interest.
 * e.g. it is a User and the uid is the field of interest.
 *
 * 2) now the entity type and $field of interest is established, this
 * Entity record is pulled from the database.
 *
 * 3) the specific information of interest for the web-page is then gathered up
 * and made convenient to use & quick to access.  This is done so it is easy
 * to work with when constructing the Business Logic in the sub-class
 * EntityPagerOut.
 *
 * @package Drupal\entity_pager\EntityPager
 */
interface EntityPagerInterface {

  /**
   * Gets the view for the entity pager.
   *
   * @return ViewExecutable
   *   The view object.
   */
  public function getView();

  /**
   * Gets an array of entity pager links.
   *
   * @return array
   */
  public function getLinks();

  /**
   * Get result count word.
   *
   * Get the word associated with the count of results.
   * i.e. one, many
   * The number in the result converted to a summary word for privacy.
   *
   * @return string
   *   Get a text representation the number of records e.g. none, one or many.
   */
  public function getCountWord();

  /**
   * Returns the entity type that this pager is using.
   *
   * @return string
   */
  public function getEntityType();

  /**
   * Gets the entity object this entity pager is for.
   *
   * @return EntityInterface
   *   The entity object.
   */
  public function getEntity();

  /**
   * Returns the options this entity pager was created with.
   *
   * @return array
   */
  public function getOptions();
};
