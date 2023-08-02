<?php

namespace app\rbac;

use yii\rbac\Rule;

class SnapshotOwnerRule extends Rule
{

    public $name = 'isOwner';

    public function execute($user, $item, $params)
    {
        return isset($params['ownerSnapshot']) ? $params['ownerSnapshot'] == $user : false;
    }
}