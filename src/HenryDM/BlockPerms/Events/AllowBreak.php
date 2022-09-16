<?php

declare(strict_types=1);

namespace HenryDM\BlockPerms\Events;

use HenryDM\BlockPerms\Main;
use pocketmine\event\Listener;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\player\Player;


class AllowBreak implements Listener {
     
    public function __construct(private Main $main) {
        $this->main = $main;
    }

    public function onBreak(BlockBreakEvent $event) {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $block = $event->getBlock()->getName();
        $world = $player->getWorld();
        $name = $block;
        $worldName = $world->getFolderName();
        $blockName = $this->getMain()->cfg->get("allowed-blocks");

        if ($this->getMain()->cfg->get("allow-specific-break") === true) {
           if(!$event->getBlock()->getID() == 59) return; 
                 if (in_array($worldName, $this->getMain()->cfg->get("anti-break-worlds"))) {
                    $event->cancel();
                }
            }
        }             
 
    public function getMain() : Main {
        return $this->main;
    }
}