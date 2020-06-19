<?php

namespace Drupal\example;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\node\NodeInterface;

/**
 * Class ExampleController.
 *
 * @package Drupal\example
 */
class ExampleController implements ControllerBase {

  /**
   * The EntityTypeManager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * ExampleController constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManager $entity_type_manager
   *   The EntityTypeManager to use.
   */
  public function __construct(EntityTypeManager $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * Check if node has changed after updating fields.
   */
  public function isNodeChanged(NodeInterface $node) {
    $original_node = $this->entityTypeManager->getStorage('node')
      ->loadUnchanged($node->id());

    $fields = $this->getFields();
    $node_fields = array_intersect_key($node->toArray(), array_flip($fields));
    $original_node_fields = array_intersect_key($original_node->toArray(), array_flip($fields));
    return $node_fields !== $original_node_fields;
  }

  /**
   * Return the fields to check against.
   */
  public function getFields() {
    return [
      'field_example_body',
      'field_example_title',
    ];
  }

}
