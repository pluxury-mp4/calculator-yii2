<?php

namespace app\commands;

use app\rbac\SnapshotOwnerRule;
use yii\console\Controller;

class RoleController extends Controller
{
    public function actionCreate()
    {
        $auth = \Yii::$app->authManager;
        $auth->removeAll();

        $rule = new SnapshotOwnerRule();
        $auth->add($rule);

        $administrator = $auth->createRole('administrator');
        $administrator->description = 'Администратор';
        $auth->add($administrator);
        echo 'Администратор создан' . PHP_EOL;

        $user = $auth->createRole('user');
        $user->description = 'Пользователь';
        $auth->add($user);
        echo 'Пользователь создан' . PHP_EOL;

        $editUser = $auth->createPermission('editUser');
        $saveHistory = $auth->createPermission('saveHistory');
        $deleteSnapshot = $auth->createPermission('deleteSnapshot');
        $adminPanelAccess = $auth->createPermission('/admin/*');
        $readSnapshot = $auth->createPermission('readSnapshot');
        $readOwnSnapshot = $auth->createPermission('readOwnSnapshot');
        $readOwnSnapshot->ruleName = $rule->name;

        $auth->add($editUser);
        $auth->add($saveHistory);
        $auth->add($deleteSnapshot);
        $auth->add($adminPanelAccess);
        $auth->add($readSnapshot);
        $auth->add($readOwnSnapshot);

        $auth->addChild($user,$saveHistory);
        $auth->addChild($administrator,$user);
        $auth->addChild($administrator,$editUser);
        $auth->addChild($administrator,$deleteSnapshot);
        $auth->addChild($administrator,$adminPanelAccess);
        $auth->addChild($administrator,$readSnapshot);
        $auth->addChild($user,$readOwnSnapshot);
        $auth->addChild($readOwnSnapshot,$readSnapshot);

        $userRoutes = [
            '/site/*',

            '/calculate/index',
            '/calculate/view',

            '/site/profile',
            '/login/logout',
        ];

        foreach ($userRoutes as $route) {
            $permission = $auth->createPermission($route);
            $auth->add($permission);
            $auth->addChild($user, $permission);
        }

        $adminRoutes = $auth->createPermission('/*');
        $auth->add($adminRoutes);
        $auth->addChild($administrator, $adminRoutes);

        $auth->assign($administrator,1);
        $auth->assign($user,2);

//        $canAdmin = $auth->createPermission('canAdmin');
//        $canAdmin->description = 'Доступ к админ-панели';
//        $auth->add($canAdmin);
//        echo 'Право canAdmin создано' . PHP_EOL;
//
//        $canSaveHistory = $auth->createPermission('canSaveHistory');
//        $canSaveHistory->description = 'Право на сохранение истории расчетов';
//        $auth->add($canSaveHistory);
//        echo 'Право на сохранение истории расчетов создано' . PHP_EOL;
//
//        $canManageUser = $auth->createPermission('canManageUser');
//        $canManageUser->description = 'Право на изменение данных пользователей';
//        $auth->add($canManageUser);
//        echo 'Право на изменение данных пользователей создано' . PHP_EOL;
//
//        $auth->addChild($user,$canSaveHistory);
//        $auth->addChild($administrator,$user);
//        $auth->addChild($administrator,$canManageUser);
//        $auth->addChild($administrator,$canAdmin);
//        echo 'Наследование...' . PHP_EOL;
//        echo 'Готово!' . PHP_EOL;
    }
}