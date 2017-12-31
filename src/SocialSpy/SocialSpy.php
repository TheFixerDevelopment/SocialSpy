<?php

namespace SocialSpy;

use SocialSpy\EventListener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\PluginCommand;
use SocialSpy\Command\ViewInv;
use SocialSpy\Session\ViewInv as ViewSession;


class SocialSpy extends PluginBase{
	
	public $authorized = array();
	
  	public function onEnable(){
       		$this->getLogger()->info('§ePlugin initialization...');
		
		@mkdir($this->getDataFolder());
		
		if(!is_file($this->getDataFolder(). 'config.yml')){
			$this->saveResource('config.yml'); 
		}
		
		$this->config = new Config($this->getDataFolder(). 'config.yml', Config::YAML);
		
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		
		$this->getCommand("snoop")->setExecutor(new Commands\CmdSnooper($this));
        }
    
  	public function onDisable(){
        	
        }  
	
	public function isAuthorized(Player $player){
		return isset($this->authorized[strtolower($player->getName())]);
	}
	
	public function authorize(Player $player){
		$nick = strtolower($player->getName());
		
		$this->authorized[$nick] = true;
		return true;
	}
	
	public function deauthorize(Player $player){
		unset($this->authorized[strtolower($player->getName())]);
		return true;
	}
	
	public function registerCommands() {
		$cmd = new PluginCommand("viewinv", $this);
                $cmd->setDescription("View a players inventory");
                $cmd->setExecutor(new ViewInv($this));
                $this->getServer()->getCommandMap()->register("ic", $cmd);
		return true;
        }

  	public function viewInventory(Player $player, Player $target) {
          	$this->viewing[$player->getName()] = new ViewSession($player, $target, true);
		return true;
        }
        
  	public function isViewing($name) {
          	return isset($this->viewing[$name]) and $this->viewing[$name] instanceof ViewSession;
        }
        
  	public function stopViewing($name) {
          	if(!$this->isViewing($name)) return;
          	$this->viewing[$name]->end();
          	unset($this->viewing[$name]);
    	}

}
