<?php
namespace GDO\DogWebsite;

use GDO\Core\GDO_DBException;
use GDO\Dog\DOG_Room;
use GDO\Dog\DOG_Server;
use GDO\Dog\DOG_User;
use GDO\Dog\Module_Dog;
use GDO\Language\Module_Language;

final class DOG_Install
{

    /**
     * @throws GDO_DBException
     */
    public static function onInstall(): void
    {
        Module_Language::instance()->saveConfigVar('languages', '["en","de"]');
        $mod = Module_Dog::instance();
        $botname = $mod->cfgDefaultNickname();
        if (!($server = DOG_Server::getBy('serv_connector', 'Web')))
        {
            $server = DOG_Server::blank([
                'serv_connector' => 'Web',
                'serv_username' => $botname,
            ])->insert();
        }
        $user = DOG_User::getOrCreateUser($server, $botname, $botname, false);
        $user->getGDOUser()->saveVar('user_name', $user->getName());
        if (!DOG_Room::getByName($server, 'PublicChat'))
        {
            DOG_Room::blank([
                'room_server' => $server->getID(),
                'room_name' => 'PublicChat',
                'room_displayname' => 'Dog Public Chat',
                'room_description' => 'Public Web Chatroom for Dog',
            ])->insert();
        }
    }

}
