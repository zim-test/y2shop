<?php
namespace common\models;

/**
 * Interface UserInterface
 * @package common\models
 */
interface UserInterface
{

    const PERM_USER_CAN_VIEW_LIST = 'PERM_USER_CAN_VIEW_LIST';
    const PERM_USER_CAN_UPDATE = 'PERM_USER_CAN_UPDATE';
    const PERM_LANGUAGE_CAN_VIEW_LIST = 'PERM_LANGUAGE_CAN_VIEW_LIST';
    const PERM_LANGUAGE_CAN_UPDATE = 'PERM_LANGUAGE_CAN_UPDATE';
    const PERM_TRANSLATE_CAN_VIEW_LIST = 'PERM_TRANSLATE_CAN_VIEW_LIST';
    const PERM_TRANSLATE_CAN_UPDATE = 'PERM_TRANSLATE_CAN_UPDATE';

    const ROLE_ROOT = 'ROLE_ROOT';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_MANAGER = 'ROLE_MANAGER';
    const ROLE_SELLER = 'ROLE_SELLER';
    const ROLE_CUSTOMER = 'ROLE_CUSTOMER';

    const STATUS_DELETED = -1;
    const STATUS_ON_HOLD = 0;
    const STATUS_ACTIVE = 1;

    const PASSWORD_LENGTH_MIN = 4;
    const PASSWORD_LENGTH_MAX = 32;

}
