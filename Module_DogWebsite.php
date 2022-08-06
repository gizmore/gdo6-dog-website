<?php
namespace GDO\DogWebsite;

use GDO\Core\GDO_Module;
use GDO\UI\GDT_Page;
use GDO\UI\GDT_Headline;

final class Module_DogWebsite extends GDO_Module
{
    ##############
    ### Module ###
    ##############
    public int $priority = 100;
    public function isSiteModule() : bool { return true; }
    public function getTheme() : string { return 'dog'; }
    public function getDependencies() : array {
        return [
            'Bootstrap5Theme', 'JQuery', 'Avatar',
            'Dog', 'DogAuth', 'Login', 'Register', 'Admin',
            'DogIRC', 'DogTick', 'DogShadowdogs', 'DogIRCAutologin',
            'DogIRCSpider', 'DogGreetings', 'DogBlackjack',
            'News', 'PM', 'Quotes', 'Shoutbox', 'Forum', 'Links', 'Download',
            'Math', 'Contact', 'Todo', 'Perf',
            'Markdown',
        ];
    }
    
    public function onInstall() : void
    {
        DOG_Install::onInstall();
    }
    
    ##############
    ### Config ###
    ##############
    public function getConfig() : array
    {
        return [
            
        ];
    }
    
    ############
    ### Init ###
    ############
    public function onIncludeScripts() : void
    {
        
    }
    
    public function onInitSidebar() : void
    {
        $nav = GDT_Page::$INSTANCE->topNav;
        $head = GDT_Headline::make()->level(1)->textRaw('DOG!');
        $nav->addField($head);
    }
    
}
