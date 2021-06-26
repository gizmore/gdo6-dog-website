<?php
namespace GDO\DogWebsite;

use GDO\Core\GDO_Module;

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
            'Bootstrap5Theme', 'JQuery',
            'Dog', 'DogAuth', 'Login', 'Register', 'Admin',
            'DogIRC', 'DogTick', 'DogShadowdogs', 'DogIRCAutologin',
            'DogIRCSpider', 'DogGreetings', 'DogBlackjack',
            'News', 'PM', 'Quotes', 'Shoutbox', 'Forum', 'Links', 'Download',
            'Math', 'Contact', 'Todo',
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
    
}
