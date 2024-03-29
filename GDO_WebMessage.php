<?php
namespace GDO\DogWebsite;

use GDO\Core\GDO;
use GDO\Core\GDO_DBException;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;
use GDO\Core\GDT_String;
use GDO\Core\GDT_Text;
use GDO\Date\GDT_Timestamp;
use GDO\Date\Time;
use GDO\Dog\DOG_Room;
use GDO\Dog\GDT_Room;
use GDO\Table\GDT_ListItem;
use GDO\User\GDO_User;
use GDO\User\GDT_User;

/**
 * Message bridged between CLI and Web.
 */
final class GDO_WebMessage extends GDO
{

    public function gdoCached(): bool
    {
        return false;
    }

    public function gdoColumns(): array
    {
        return [
            GDT_AutoInc::make('dw_id'),
            GDT_String::make('dw_text')->max(255)->notNull(),
            GDT_Room::make('dw_room'),
            GDT_User::make('dw_user'), # user in PM
            GDT_CreatedAt::make('dw_created'),
            GDT_CreatedBy::make('dw_creator'),
            GDT_Timestamp::make('dw_processed'),
        ];
    }

    public function isDog(): bool
    {
        return $this->getCreator() === Module_DogWebsite::instance()->getDogServer()->getDog()->getGDOUser();
    }


    public function isPrivate(): bool
    {
        return $this->gdoVar('dw_room') === null;
    }

    public function getRoom(): ?DOG_Room
    {
        return $this->gdoValue('dw_room');
    }

    public function getText(): string
    {
        return $this->gdoVar('dw_text');
    }

    public function getCreator(): GDO_User
    {
        return $this->gdoValue('dw_creator');
    }

    /**
     * @throws GDO_DBException
     */
    public function processed(): self
    {
        return $this->saveVar('dw_processed', Time::getDate());
    }

    ##############
    ### Static ###
    ##############

    /**
     * @throws GDO_DBException
     * @return self[]
     */
    public static function getLastMessages(DOG_Room $room, int $amt=20): array
    {
        $messages = GDO_WebMessage::table()->select()->where("dw_room={$room->getID()}")
            ->limit($amt)->order('dw_created DESC')->exec()->fetchAllObjects();
        return array_reverse($messages);
    }

    public static function getNextMessageToProcess(): ?self
    {
        return self::table()->select()->where('dw_processed IS NULL')
            ->order('dw_created ASC')->first()->exec()->fetchObject();
    }

    ##############
    ### Render ###
    ##############

    public function renderList(): string
    {
        return GDT_ListItem::make()->gdo($this)->creatorHeader()->css('font-size', '9')->titleRaw($this->getText(), !$this->isDog())->render();
    }


}
