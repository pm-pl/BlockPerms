<?php

namespace HenryDM\BlockPerms;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;

use HenryDM\BlockPerms\Events\BlockBreak;
use HenryDM\BlockPerms\Events\BlockPlace;

class Main extends PluginBase implements Listener {

    /*** @var Main */
    private static Main $instance;

    /*** @var Config */
    public Config $cfg;

    public function onEnable() : void {
        $this->saveDefaultConfig();
        $this->cfg = $this->getConfig();

        $events = [
            BlockBreak::class,
            BlockPlace::class
        ];
        foreach($events as $e) {
                       
    public function getMainConfig() : Config {
        return $this->cfg;
    }
}