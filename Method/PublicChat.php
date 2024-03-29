<?php
namespace GDO\DogWebsite\Method;

use GDO\Core\GDO_DBException;
use GDO\Core\GDT;
use GDO\Core\GDT_Response;
use GDO\Core\GDT_String;
use GDO\Core\GDT_Tuple;
use GDO\Dog\DOG_Room;
use GDO\Dog\DOG_Server;
use GDO\DogWebsite\GDO_WebMessage;
use GDO\DogWebsite\GDT_DogChat;
use GDO\DogWebsite\Module_DogWebsite;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\User\GDO_User;

/**
 * Implements a simple public chat.
 */
class PublicChat extends MethodForm
{

    public function hasPermission(GDO_User $user, string &$error, array &$args): bool
    {
        if (!Module_DogWebsite::instance()->cfgAllowPublic())
        {
            $error = 'err_method_disabled';
            return false;
        }
        return true;
    }

    protected function createForm(GDT_Form $form): void
    {
        $form->addFields(
            GDT_String::make('message')->notNull(),
            GDT_AntiCSRF::make(),
        );
        $form->actions()->addField(GDT_Submit::make());
    }

    /**
     * @throws GDO_DBException
     */
    public function getRoom(): DOG_Room
    {
        $mod = Module_DogWebsite::instance();
        return $mod->getPublicRoom();
    }

    /**
     * @throws GDO_DBException
     */
    public function getServer(): DOG_Server
    {
        return DOG_Server::getByConnector('Web');
    }

    /**
     * @throws GDO_DBException
     */
    public function execute(): GDT
    {
        return GDT_Tuple::make()->addFields(
            GDT_DogChat::make()->room($this->getRoom()),
            parent::execute(),
        );
    }

    /**
     * @throws GDO_DBException
     */
    public function formValidated(GDT_Form $form): GDT
    {
        GDO_WebMessage::blank([
            'dw_text' => $form->getFormVar('message'),
            'dw_room' => $this->getRoom()->getID(),
        ])->insert();
        $this->resetForm(true);
        return $this->getForm(true);
    }

}
