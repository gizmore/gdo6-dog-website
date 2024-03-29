<?php
namespace GDO\DogWebsite;

use GDO\Core\GDT;
use GDO\Core\GDT_Object;

final class GDT_WebMessage extends GDT_Object
{

    protected function __construct()
    {
        parent::__construct();
        $this->table(GDO_WebMessage::table());
    }

    public function getMessage(): ?GDO_WebMessage
    {
        return $this->getGDO();
    }

    public function renderHTML(): string
    {
        return (string)$this->getMessage();
    }

}
