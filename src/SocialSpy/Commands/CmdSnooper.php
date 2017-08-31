<?php

namespace SocialSpy\Commands;
  
use SocialSpy\SocialSpy;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;
use pocketmine\command\CommandExecutor;
  
class CmdSnooper implements CommandExecutor{
    public function __construct(SocialSpy $plugin){
      $this->plugin = $plugin;
    }

    public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
      if(!$this->plugin->isAuthorized($sender)){
        $this->plugin->authorize($sender);
        return true;
      } 
      else{
        $this->plugin->deauthorize($sender);
        return true;
      }
    }
  
}

