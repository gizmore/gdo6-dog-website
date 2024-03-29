<?php
namespace GDO\DogWebsite;

use GDO\Core\GDO_DBException;
use GDO\Core\GDT;
use GDO\Core\GDT_Template;
use GDO\Dog\DOG_Room;

final class GDT_DogChat extends GDT
{

    public DOG_Room $room;

    protected function __construct()
    {
        parent::__construct();
    }

    public function room(DOG_Room $room): self
    {
        $this->room = $room;
        return $this;
    }

    /**
     * @throws GDO_DBException
     */
    public function renderHTML(): string
    {
        return GDT_Template::php('DogWebsite', 'dog_chat_html.php', [
            'field' => $this,
            'messages' => GDO_WebMessage::getLastMessages($this->room),
        ]);
    }
}
