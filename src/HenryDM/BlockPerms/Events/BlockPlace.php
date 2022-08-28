<?php

declare(strict_types=1);

namespace HenryDM\BlockPerms\Events;

use HenryDM\BlockPerms\Main;
use HenryDM\BlockPerms\Listener;

use pocketmine\event\BlockPlaceEvent;
use pocketmine\player\Player;


class BlockPlace implements Listener { 

    public function onPlace(BlockPlaceEvent $event) {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $block = $event->getBlock()->getName();
        $world = $player->getWorld();
        $name = str_replace(" ", "_", strtoupper($block->getName()));
        $worldName = $world->getFolderName();
        
		if ($player->hasPermission("blockperms.bypass")) return;
        if (in_array($name, $this->getMain()->cfg->get("blocks") {
            if (in_array($worldName, $this->getMain()->cfg->get("anti-place-worlds"))) {
                if($this->getMain()->cfg->get("alert-message", true)) {
                    $player->sendActionBarMessage($this->getMain()->cfg->get("place-message"));
                    $event->cancel();

                }
            }
        }             
    }

    public function getMain() : Main {
        return $this->main;
    }
}