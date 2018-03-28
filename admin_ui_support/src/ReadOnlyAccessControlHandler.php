<?php

namespace Drupal\admin_ui_support;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Access\AccessResultForbidden;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Tests\Core\Access\AccessResultForbiddenTest;

/**
 * Access controller for the Read only entity types.
 *
 * @see \Drupal\admin_ui_support\Entity\WatchdogEntity.
 */
class ReadOnlyAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    if ($operation === 'view') {
      return AccessResult::allowedIfHasPermission($account, $entity->getEntityType()->getAdminPermission());
    }
    return $this->getForbiddenAccessResult();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return $this->getForbiddenAccessResult();
  }

  /**
   * Gets the forbidden access result with a reason.
   *
   * @return \Drupal\Core\Access\AccessResultForbidden
   *   The forbidden acess result.
   */
  protected function getForbiddenAccessResult() {
    return AccessResultForbidden::forbidden('Read only entity type: ' . $this->entityTypeId);
  }

}