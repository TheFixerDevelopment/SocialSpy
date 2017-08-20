<?php

namespace SocialSpy\Commands;
  
use SocialSpy\SocialSpy;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;
use pocketmine\command\CommandExecutor;
  
class SnoopCommand implements CommandExecutor{
    public function __construct(SocialSpy $plugin){
      $this->plugin = $plugin;
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
      if($this->plugin->isAuthorized($sender)){

        return true;
      }  
    }
  
}

