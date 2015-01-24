<?php



namespace CursedPotato;


use pocketmine\Server;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\TextFormat;
use pocketmine\Player;


class VanishTask extends PluginTask{
	
	
	private $state;
	
	
    public function __construct(Main $plugin, $user){
        parent::__construct($plugin);
        $this->plugin = $plugin;
		$this->user = $user;
    }
	
    public function onRun($currentTick){
    	$time = $this->plugin->getConfig()->get("Time");
    	if($time > 0) {
    		$this->plugin->showUser($this->user);
			unset($this->plugin->sessions[$this->user->getName()]);
		}else{
			return true;
		}
	}
}
