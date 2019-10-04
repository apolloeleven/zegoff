<?php

use app\models\User;
use app\rbac\Migration;;

/**
 * Class m192323_113914_init_permissions
 */
class m192323_113914_init_permissions extends Migration
{
    public function up()
    {
        $managerRole = $this->auth->getRole(User::ROLE_MANAGER);
        $administratorRole = $this->auth->getRole(User::ROLE_ADMINISTRATOR);

        $loginToBackend = $this->auth->createPermission('loginToBackend');
        $this->auth->add($loginToBackend);

        $this->auth->addChild($managerRole, $loginToBackend);
        $this->auth->addChild($administratorRole, $loginToBackend);
    }

    public function down()
    {
        $this->auth->remove($this->auth->getPermission('loginToBackend'));
    }
}
