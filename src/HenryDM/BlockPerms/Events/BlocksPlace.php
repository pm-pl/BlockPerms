<?php

namespace HenryDM\BlockPerms\Events;

use HenryDM\BlockPerms\Main;
use pocketmine\event\Listener;

use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\player\Player;

class BlocksPlace implements Listener { 

    public function __construct(private Main $main) {
        $this->main = $main;
    }

    public function onPlace(BlockPlaceEvent $event) {

# ===========================================================        
        $player = $event->getPlayer();
        $item = $event->getItem();
        $block = $event->getBlock();
        $world = $player->getWorld();
        $worldName = $world->getFolderName();
        $name = str_replace(" ", "_", strtoupper($block->getName()));
        $message = str_replace(["{block}", "&"], [$name, "§"], $this->main->cfg->get("specific-place-message"));
        $blockN = $this->main->cfg->get("specific-blocks", []);
# ===========================================================

        if($this->main->cfg->get("place-specific-block") === true) {
            if($player->hasPermission("blockperms.bypass")) {
                return;
            }

            if(in_array($worldName, $this->main->cfg->get("specific-blocks-worlds", []))) {
                if(in_array($name, $this->main->cfg->get("specific-blocks", []))) {
                    if($block != $blockN) {
                        $event->cancel();
                    }
                }
            }
        }
    }

    public function getMain() : Main {
        return $this->main;
    }
}