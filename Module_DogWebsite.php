<?php
namespace GDO\DogWebsite;

use GDO\Core\Application;
use GDO\Core\GDO_DBException;
use GDO\Core\GDO_Module;
use GDO\Core\GDT_Checkbox;
use GDO\Core\Method;
use GDO\Dog\Dog;
use GDO\Dog\DOG_Connector;
use GDO\Dog\DOG_Room;
use GDO\Dog\DOG_Server;
use GDO\DogWebsite\Connector\Web;
use GDO\DogWebsite\Method\Home;
use GDO\PM\GDO_PM;
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
            'ChatGPT',
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
            'Moment',
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

    /**
     * @throws GDO_DBException
     */
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
            GDT_Checkbox::make('dog_webchat_public')->initial('1'),
            GDT_Checkbox::make('dog_webchat_private')->initial('1'),
		];
	}

    public function cfgAllowPublic(): bool
    {
        return $this->getConfigValue('dog_webchat_public');
    }

    public function cfgAllowPrivate(): bool
    {
        return $this->getConfigValue('dog_webchat_private');
    }

	############
	### Init ###
	############
	public function onIncludeScripts(): void
    {
        $this->addJS('gdo_dog.js');
    }

    public function onModuleInit(): void
    {
        DOG_Connector::register(new Web());
    }

    public function onInitSidebar(): void
	{
		$nav = GDT_Page::$INSTANCE->topBar();
		$head = GDT_Headline::make()->level(1)->textRaw('DOG!');
		$nav->addField($head);

        $bar = GDT_Page::instance()->leftBar();
        $bar->addField(GDT_Link::make('dog_chat')->href($this->href('PublicChat')));
        $bar->addField(GDT_Link::make('dog_private_chat')->href($this->href('PrivateChat')));
	}

    /**
     * @throws GDO_DBException
     */
    public function getDogServer(): DOG_Server
    {
        return DOG_Server::getByConnector('Web');
    }

    /**
     * @throws GDO_DBException
     */
    public function getPublicRoom(): DOG_Room
    {
        return DOG_Room::getByName($this->getDogServer(), 'PublicChat');
    }

    /**
     * @throws GDO_DBException
     */
    public function hookPMSent(GDO_PM $pmFrom, GDO_PM $pmTo): void
    {
        $old = Application::$MODE;
        if ($pmTo->getReceiver() === $this->getDogServer()->getDog()->getGDOUser())
        {
            Application::$MODE = $old;
            GDO_WebMessage::blank([
                'dw_text' => $pmFrom->getMessage(),
                'dw_user' => $pmFrom->getSender()->getID(),
            ])->insert();
        }
    }

}
