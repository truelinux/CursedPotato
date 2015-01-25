<?php


namespace CursedPotato;


use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;
use pocketmine\IPlayer;
use pocketmine\utils\TextFormat;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;


class Main extends PluginBase  implements Listener {
	
	
	public function onEnable() {
		@mkdir($this->getDataFolder());
		$this->saveDefaultConfig();
		$this->reloadConfig();
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info( TextFormat::GREEN . "CursedPotato - Enabled!" );
	}
	
	
	public function onEat(PlayerItemConsumeEvent $ev) {
		$food = $ev->getItem()->getName();
		$player = $ev->getPlayer();
		$sec = $this->getConfig()->get("Time");
		if($food == "Potato" &&  $player->hasPermission("cursedpotato.access") && $this->getConfig()->get("Enabled")) {
			if(!isset($this->sessions[$player->getName()])) {
				$this->sessions[$player->getName()] = new CursedSession($this);
				$this->sessions[$player->getName()]->setCurse($player);
				$time = $sec * 20;
				$player->sendMessage("Your cursed! Invisible for $sec seconds!");
				$this->hideUser($player);
				$this->getServer()->getScheduler()->scheduleDelayedTask(new VanishTask($this, $player), $time);
				return true;
			}else{
				$player->sendMessage("Your already cursed!");
				return true;
			}
		}
	}
	
	public function onQuit(PlayerQuitEvent $ev) {
		if(isset($this->sessions[$ev->getPlayer()->getName()])) {
			unset($this->sessions[$ev->getPlayer()->getName()]);
			return true;
		}
	}
	
	public function hideUser($user) {
		foreach($user->getLevel()->getPlayers() as $p) {
			$p->hidePlayer($user);
			return true;
		}
	}
	
	public function showUser($user) {
		foreach($user->getLevel()->getPlayers() as $p) {
			$p->showPlayer($user);
			$user->sendMessage("Curse has worn off!");
			return true;
		}
	}
}
