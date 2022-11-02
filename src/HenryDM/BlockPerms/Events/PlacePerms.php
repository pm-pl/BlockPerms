<?php

namespace HenryDM\BlockPerms\Events;

use HenryDM\BlockPerms\Main;
use pocketmine\event\Listener;

use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\player\Player;

class PlacePerms implements Listener { 

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
        $message = str_replace(["{block}", "&"], [$name, "§"], $this->main->cfg->get("place-message"));
# ===========================================================

        if($this->main->cfg->get("place-perms") === true) {
            if($player->hasPermission("blockperms.bypass")) {
                return;
            }

            if(in_array($worldName, $this->main->cfg->get("block-perms-worlds", []))) {
                if(in_array($name, $this->main->cfg->get("blocks", []))) {
                    $event->cancel();

                    if($this->main->get("place-alert-message") === true) {
                        if($this->main->get("messages-type") === "popup") {
                            $player->sendPopup($message);
                        }

                        if($this->main->get("messages-type") === "message") {
                            $player->sendMessage($message);
                        }
                    }
                }
            }
        }
    }

    public function getMain() : Main {
        return $this->main;
    }
}