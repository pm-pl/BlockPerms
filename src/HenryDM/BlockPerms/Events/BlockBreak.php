<?php

declare(strict_types=1);

namespace HenryDM\BlockPerms\Events;

use HenryDM\BlockPerms\Main;
use pocketmine\event\Listener;

use pocketmine\event\BlockBreakEvent;
use pocketmine\player\Player;


class BlockBreak implements Listener { 

    public function onBreak(BlockBreakEvent $event) {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $block = $event->getBlock()->getName();
        $world = $player->getWorld();
        $name = str_replace(" ", "_", strtoupper($block->getName()));
        $worldName = $world->getFolderName();

		if ($player->hasPermission("blockperms.bypass")) return; 
        if (in_array($name, $this->getMain()->cfg->get("blocks"))) {
            if (in_array($worldName, $this->getMain()->cfg->get("anti-break-worlds"))) {
                if ($this->getMain()->cfg->get("alert-message") === true) {
                    $player->sendActionBarMessage($this->getMain()->cfg->get("break-message"));
                    $event->cancel();
                }
            }
        }             
    }
 
    public function getMain() : Main {
        return $this->main;
    }
}