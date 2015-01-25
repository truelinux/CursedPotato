<?php



namespace CursedPotato;


use pocketmine\Server;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\TextFormat;
use pocketmine\Player;


class CursedSession extends PluginTask{
	
	
	private $state;
	
	
    public function __construct(Main $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }
	
	public function setCurse() {
		$this->state = 1;
	}
	
	
	public function onRun($currentTick) {
		return true;
	}
}
