<?php

namespace HenryDM\BlockPerms;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;

use HenryDM\BlockPerms\Events\BlockBreak;
use HenryDM\BlockPerms\Events\BlockPlace;
use HenryDM\BlockPerms\Events\AllowBreak; # In Test

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
            AllowBreak::class
        ];
        foreach($events as $e) {
            $this->getServer()->getPluginManager()->registerEvents(new $e($this), $this);
        }
    }

    public function onLoad() : void {
        self::$instance = $this;
    }

    public static function getInstance() : Main {
        return self::$instance;
    }

    public function getMainConfig() : Config {
        return $this->cfg;
    }
}