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
        $this->getServer()->getLogger()->info("  ____  _            _      _____                         ");
		$this->getServer()->getLogger()->info(" |  _ \| |          | |    |  __ \                        ");
		$this->getServer()->getLogger()->info(" | |_) | | ___   ___| | __ | |__) |__ _ __ _ __ ___  ___  ");
		$this->getServer()->getLogger()->info(" |  _ <| |/ _ \ / __| |/ / |  ___/ _ \ '__| '_ ` _ \/ __| ");
		$this->getServer()->getLogger()->info(" | |_) | | (_) | (__|   <  | |  |  __/ |  | | | | | \__ \ ");
	    $this->getServer()->getLogger()->info(" |____/|_|\___/ \___|_|\_\ |_|   \___|_|  |_| |_| |_|___/ ");
	    $this->getServer()->getLogger()->info("");
		$this->getServer()->getLogger()->info("[BlockPerms] Plugin Enable - By HenryDM");
		$this->saveResource("config.yml");
        $this->cfg = new Config($this->getDataFolder() . "config.yml");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool { 
	
        switch ($command->getName()) {
            case "bpreload":
            {
                $this->cfg->reload();
                $sender->sendMessage($this->cfg->get("prefix") . " " . $this->cfg->get("reloaded"));
                break;
            }
        }

        return true;
    }

    public function onBlockPlace(BlockPlaceEvent $event): void { 
	
        $player = $event->getPlayer();
        $bl = $event->getItem();
        $name = str_replace(" ", "_", strtoupper($bl->getName()));

        if (in_array($name, $this->cfg->get("blocks")) && !$player->hasPermission("bypass.permission")) {
            if ($this->cfg->get("alert-message")) {
                $player->sendMessage($this->cfg->get("prefix") . " " . str_replace("%block%", $event->getBlock()->getName(), $this->cfg->get("place-message")));
            }

            $event->cancel();
        }
    }
	
	public function onBlockBreak(BlockBreakEvent $event): void { 
	
        $player = $event->getPlayer();
        $bl = $event->getItem();
        $name = str_replace(" ", "_", strtoupper($bl->getName()));

        if (in_array($name, $this->cfg->get("blocks")) && !$player->hasPermission("bypass.permission")) {
            if ($this->cfg->get("alert-message")) {
                $player->sendMessage($this->cfg->get("prefix") . " " . str_replace("%block%", $event->getBlock()->getName(), $this->cfg->get("break-message")));
            }

            $event->cancel();
        }
	}
	
}
