<?php

use app\models\User;
use app\rbac\Migration;


/**
 * Class m190323113731_roles
 */
class m191003_120439_roles_migration extends Migration
{
    public function up()
    {
        $this->auth->removeAll();

        $user = $this->auth->createRole(User::ROLE_USER);
        $this->auth->add($user);

        $manager = $this->auth->createRole(User::ROLE_MANAGER);
        $this->auth->add($manager);
        $this->auth->addChild($manager, $user);

        $admin = $this->auth->createRole(User::ROLE_ADMINISTRATOR);
        $this->auth->add($admin);
        $this->auth->addChild($admin, $manager);
        $this->auth->addChild($admin, $user);

        $this->auth->assign($admin, 1);
        $this->auth->assign($manager, 2);
        $this->auth->assign($user, 3);
    }

    public function down()
    {
        $this->auth->remove($this->auth->getRole(User::ROLE_ADMINISTRATOR));
        $this->auth->remove($this->auth->getRole(User::ROLE_MANAGER));
        $this->auth->remove($this->auth->getRole(User::ROLE_USER));
    }
}
