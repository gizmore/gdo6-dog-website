<?php
namespace GDO\DogWebsite;

use GDO\Core\GDO_Module;

final class Module_DogWebsite extends GDO_Module
{
    public $module_priority = 100;
    public function isSiteModule() { return true; }
    public function getTheme() { return 'dog'; }
    public function getDependencies() {
        return [
            'Classic', 'Dog', 'DogAuth', 'Login', 'Register', 'Admin',
            'DogIRC', 'DogTick', 'DogShadowdogs', 'DogIRCAutologin',
            'DogIRCSpider', 'DogGreetings',
            'News', 'PM', 'Quotes', 'Shoutbox', 'Forum', 'Links', 'Download',
            'Math', 'Contact', 'Todo',
        ];
    }
    
    ##############
    ### Config ###
    ##############
    public function getConfig()
    {
        return [
            
        ];
    }
    
    public function onIncludeScripts()
    {
        
    }
    
}
