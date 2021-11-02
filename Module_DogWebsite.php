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
    public $module_priority = 100;
    public function isSiteModule() { return true; }
    public function getTheme() { return 'dog'; }
    public function getDependencies() {
        return [
            'Bootstrap5Theme', 'JQuery', 'Avatar',
            'Dog', 'DogAuth', 'Login', 'Register', 'Admin',
            'DogIRC', 'DogTick', 'DogShadowdogs', 'DogIRCAutologin',
            'DogIRCSpider', 'DogGreetings', 'DogBlackjack',
            'News', 'PM', 'Quotes', 'Shoutbox', 'Forum', 'Links', 'Download',
            'Math', 'Contact', 'Todo', 'Perf', 'Website',
            'Markdown',
        ];
    }
    
    public function onInstall()
    {
        DOG_Install::onInstall();
    }
    
    ##############
    ### Config ###
    ##############
    public function getConfig()
    {
        return [
            
        ];
    }
    
    ############
    ### Init ###
    ############
    public function onIncludeScripts()
    {
        
    }
    
    public function onInitSidebar()
    {
        $nav = GDT_Page::$INSTANCE->topNav;
        $head = GDT_Headline::make()->level(1)->textRaw('DOG!');
        $nav->addField($head);
    }
    
}
