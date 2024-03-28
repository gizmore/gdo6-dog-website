<?php
namespace GDO\DogWebsite;

use GDO\Core\GDO;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;
use GDO\Core\GDT_Text;

final class GDO_WebMessage extends GDO
{

    public function gdoColumns(): array
    {
        return [
            GDT_Text::make('dw_input'),
            GDT_Text::make('dw_output'),
            GDT_CreatedAt::make('dw_created'),
            GDT_CreatedBy::make('dw_creator'),
        ];
    }

}
