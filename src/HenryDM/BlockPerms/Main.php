<?php

declare(strict_types=1);

namespace HenryDM\BlockPerms;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener { 

    /**
     * @var Config
     */
    private $cfg;

    public function onEnable() : void {

        $this->getServer()->getPluginManager()->registerEvents($this, $this);		 
        $this->saveResource("config.yml");
        $this->cfg = new Config($this->getDataFolder() . "config.yml");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool { 
	
        switch ($command->getName()) {
            case "bpreload":
            {
                $this->cfg->reload();
                $sender->sendMessage($this->cfg->get("prefix") . " " . $this->cfg->get("reload-message"));
                break;
            }
        }

        return true;
    }

    public function onPlace(BlockPlaceEvent $event): void { 
	      $config = $this->cfg->get();
        $player = $event->getPlayer();
        $bl = $event->getItem();
        $block = $event->getBlock()->getName();
        $name = str_replace(" ", "_", strtoupper($bl->getName()));

        if (in_array($name, $this->cfg->get("blocks")) && !$player->hasPermission("blockperms.bypass")) {
            if($config("alert-message") === "true") {
              if($config("place-mode") === "message") { 
                $player->sendMessage($config("prefix") . " " . str_replace("{blockname}", $block, $config("place-message")));
                 if($config("place-mode") === "popup") { 
                   $player->sendActionBarMessage($config("prefix") . " " . str_replace("{blockname}", $block, $config("place-message")));
                   $event->cancel();
              }
            }
          }
        }
      }

    public function onBreak(BlockBreakEvent $event): void { 
	      $config = $this->cfg->get();
        $player = $event->getPlayer();
        $bl = $event->getItem();
        $block = $event->getBlock()->getName();
        $name = str_replace(" ", "_", strtoupper($bl->getName()));

        if (in_array($name, $this->cfg->get("blocks")) && !$player->hasPermission("blockperms.bypass")) {
            if($config("alert-message") === "true") {
              if($config("break-mode") === "message") { 
                $player->sendMessage($config("prefix") . " " . str_replace("{blockname}", $block, $config("break-message")));
                 if($config("break-mode") === "popup") { 
                   $player->sendActionBarMessage($config("prefix") . " " . str_replace("{blockname}", $block, $config("break-message")));
                   $event->cancel();
          }
        }
      }
    }
  }
}
