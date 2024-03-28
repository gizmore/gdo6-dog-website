<?php
namespace GDO\DogWebsite;

use GDO\Core\GDO_Module;
use GDO\Core\Method;
use GDO\DogWebsite\Method\Home;
use GDO\UI\GDT_Headline;
use GDO\UI\GDT_Link;
use GDO\UI\GDT_Page;

final class Module_DogWebsite extends GDO_Module
{

	##############
	### Module ###
	##############
	public int $priority = 100;

	public function isSiteModule(): bool { return true; }

	public function getTheme(): ?string { return 'dog'; }

	public function getDependencies(): array
	{
		return [
			'Admin',
			'Avatar',
			'Bootstrap5Theme',
            'Captcha',
			'Contact',
			'Dog',
			'DogAuth',
			'DogBlackjack',
            'DogFriends',
			'DogGreetings',
			'DogIRC',
			'DogIRCAutologin',
			'DogIRCSpider',
            'DogOracle',
            'DogShadowdogs',
            'DogSlapwarz',
            'DogTelegram',
            'DogTick',
            'DogWeather',
			'Download',
			'Forum',
			'JQuery',
			'Links',
			'Markdown',
			'News',
			'Perf',
			'PM',
			'Quotes',
			'Shoutbox',
			'Todo',
		];
	}

    public function defaultMethod(): Method
    {
        return Home::make();
    }

    public function onLoadLanguage(): void
	{
		$this->loadLanguage('lang/dog');
	}

	public function onInstall(): void
	{
		DOG_Install::onInstall();
	}

    public function getClasses(): array
    {
        return [
            GDO_WebMessage::class,
        ];
    }

    ##############
	### Config ###
	##############
	public function getConfig(): array
	{
		return [

		];
	}

	############
	### Init ###
	############
	public function onIncludeScripts(): void {}

	public function onInitSidebar(): void
	{
		$nav = GDT_Page::$INSTANCE->topBar();
		$head = GDT_Headline::make()->level(1)->textRaw('DOG!');
		$nav->addField($head);

        $bar = GDT_Page::instance()->leftBar();
        $bar->addField(GDT_Link::make('dog_chat')->href($this->href('Chat')));
	}

}
