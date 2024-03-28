<?php
namespace GDO\DogWebsite\Method;

use GDO\Core\GDT;
use GDO\Core\GDT_Text;
use GDO\Core\GDT_Tuple;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\UI\GDT_Container;

final class Chat extends MethodForm
{

    protected function createForm(GDT_Form $form): void
    {
        $form->addFields(
            GDT_Text::make('input')->notNull(),
            GDT_AntiCSRF::make(),
        );
        $form->actions()->addField(GDT_Submit::make());
    }

    public function execute(): GDT
    {
        return GDT_Tuple::make()->addFields(
            $this->renderHistory(),
            parent::execute(),
        );
    }

    public function renderHistory(): GDT
    {
        $cont = GDT_Container::make();

        return $cont;
    }

}
