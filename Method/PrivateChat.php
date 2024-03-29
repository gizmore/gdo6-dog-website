<?php
namespace GDO\DogWebsite\Method;

use GDO\Core\GDT;
use GDO\Core\GDT_Text;
use GDO\Core\GDT_Tuple;
use GDO\Dog\DOG_Room;
use GDO\DogWebsite\Module_DogWebsite;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\UI\GDT_Container;
use GDO\User\GDO_User;

class PrivateChat extends PublicChat
{

    public function hasPermission(GDO_User $user, string &$error, array &$args): bool
    {
        if (!Module_DogWebsite::instance()->cfgAllowPrivate())
        {
            $error = 'err_method_disabled';
            return false;
        }
        return true;
    }

    public function getRoom(): DOG_Room
    {
        $mod = Module_DogWebsite::instance();
        $user = GDO_User::current();
        return DOG_Room::getOrCreate($this->getServer(), $user->renderUserName());
    }

}
