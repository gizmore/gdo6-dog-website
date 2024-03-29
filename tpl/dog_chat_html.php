<?php
namespace GDO\DogWebsite\tpl;
use GDO\DB\ArrayResult;
use GDO\DogWebsite\GDO_WebMessage;
use GDO\DogWebsite\GDT_DogChat;use GDO\Table\GDT_List;
/** @var GDO_WebMessage[] $messages */
/** @var GDT_DogChat $field */

$list = GDT_List::make();
$list->result(new ArrayResult($messages, GDO_WebMessage::table()));
echo $list->render();
