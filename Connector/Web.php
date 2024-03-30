<?php
namespace GDO\DogWebsite\Connector;

use GDO\Core\GDO_DBException;
use GDO\Core\GDT;
use GDO\Dog\Dog;
use GDO\Dog\DOG_Connector;
use GDO\Dog\DOG_Message;
use GDO\Dog\DOG_Room;
use GDO\Dog\DOG_Server;
use GDO\Dog\DOG_User;
use GDO\DogWebsite\GDO_WebMessage;
use GDO\PM\GDO_PM;

/**
 * Connect to the website via a db table.
 */
final class Web extends DOG_Connector
{

    public function getGDOUserName(string $username, DOG_Server $server): string
    {
        return $username;
    }

    public function gdtRenderMode(): int
    {
        return GDT::RENDER_HTML;
    }

    public function setupServer(DOG_Server $server): void
    {
    }

    public function init(): bool
    {
        return true;
    }

    public function connect(): bool
    {
        $this->connected(true);
        return true;
    }

    public function disconnect(string $reason): void
    {
    }

    /**
     * @throws GDO_DBException
     */
    public function readMessage(): bool
    {
        if ($message = GDO_WebMessage::getNextMessageToProcess())
        {
            $this->processMessage($message);
            return true;
        }
        return false;
    }

    /**
     * @throws GDO_DBException
     */
    public function sendToUser(DOG_User $user, string $text): bool
    {
        echo "Web >> {$user->renderFullName()} >> {$text}\n";
        GDO_PM::deliver($this->getDog()->getGDOUser(), $user->getGDOUser(), t('reply_from_dog'), $text, false);
        return parent::sendToUser($user, $text);
    }

    public function sendToRoom(DOG_Room $room, string $text): bool
    {
        echo "Web >> {$text}\n";
        GDO_WebMessage::blank([
            'dw_text' => $text,
            'dw_room' => $room->getID(),
            'dw_creator' => $room->getServer()->getDog()->getGDOUserID(),
        ])->insert();
        return parent::sendToRoom($room, $text);
    }

    /**
     * @throws GDO_DBException
     */
    private function processMessage(GDO_WebMessage $msg): void
    {
        echo "Web << {$msg->getCreator()->renderUserName()} << {$msg->getText()}\n";
        $m = DOG_Message::make()->text($msg->getText())
            ->user($this->getUsersDogUser($msg))
            ->room($msg->processed()->getRoom())
            ->server($this->server);
        Dog::instance()->event('dog_message', $m);
    }

    private function getUsersDogUser(GDO_WebMessage $msg): DOG_User
    {
        $gdoUser = $msg->getCreator();
        return DOG_User::getOrCreateUser($this->server, $gdoUser->renderUserName());
    }

}
