<?php

namespace SocialSpy;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use SocialSpy\SocialSpy;

class SocialSpy extends PluginBase implements Listener{
  
        public function onArmorChange(EntityArmorChangeEvent $event) {
                if(($player = $event->getEntity()) instanceof Player) {
                        if($this->plugin->isViewing($player->getName())) {
                                $event->setCancelled(true);
                                $player->sendMessage(TF::RED . "You can't change you armor while viewing a players inventory!");
                        }
                }
        }
        public function onDrop(PlayerDropItemEvent $event) {
                $player = $event->getPlayer();
                if($this->plugin->isViewing($player->getName())) {
                        $event->setCancelled(true);
                        $player->sendMessage(TF::RED . "You can't drop items while viewing a players inventory!");
                }
        }
        
        public function onItemPickup(InventoryPickupItemEvent $event) {
                if(($player = $event->getInventory()->getHolder()) instanceof Player) {
                        if($this->plugin->isViewing($player->getName())) {
                                $event->setCancelled(true);
                                $player->sendMessage(TF::RED . "You can't pick up items while viewing a players inventory!");
                        }
                }
        }
        
        public function onArrowPickup(InventoryPickupArrowEvent $event) {
                if(($player = $event->getInventory()->getHolder()) instanceof Player) {
                        if($this->plugin->isViewing($player->getName())) {
                                $event->setCancelled(true);
                                $player->sendMessage(TF::RED . "You can't pick up arrows while viewing a players inventory!");
                        }
                }
        }
        
        public function onBlockPlace(BlockPlaceEvent $event) {
                $player = $event->getPlayer();
                if($this->plugin->isViewing($player->getName())) {
                        $event->setCancelled(true);
                        $player->sendMessage(TF::RED . "You can't place blocks while viewing a players inventory!");
                }
        }
        
        public function onBreak(BlockBreakEvent $event) {
                $player = $event->getPlayer();
                if($this->plugin->isViewing($player->getName())) {
                        $event->setCancelled(true);
                        $player->sendMessage(TF::RED . "You can't break blocks while viewing a players inventory!");
                }
        }
        
        public function onInteract(PlayerInteractEvent $event) {
                $player = $event->getPlayer();
                if($this->plugin->isViewing($player->getName())) {
                        if($event->getBlock()->getId() === Block::CHEST or $event->getBlock()->getId() === Block::TRAPPED_CHEST) {
                                $event->setCancelled(true);
                                $player->sendMessage(TF::RED . "You can't use chest's while viewing a players inventory!");
                        }
                }
        }
        
         public function onQuit(PlayerQuitEvent $event){
            $this->plugin->deauthorize($event->getPlayer());
          }
  
       public function onPlayerCmd(PlayerCommandPreprocessEvent $event) {
                  $sender = $event->getPlayer();
                  $msg = $event->getMessage();

                  if($this->getPlugin()->cfg->get("Console.Logger") == "true") {
                    if($msg[0] == "/") {
                      if(stripos($msg, "login") || stripos($msg, "log") || stripos($msg, "reg") || stripos($msg, "register")) {
                        $this->getPlugin()->getLogger()->info($sender->getName() . "> §4Hidden for security reasons");	
                      } else {
                        $this->getPlugin()->getLogger()->info($sender->getName() . "> " . $msg);
                      }

                    }
                  }

                    if(!empty($this->getPlugin()->authorized)) {
                      foreach($this->getPlugin()->authorized as $snooper) {
                         if($msg[0] == "/") {
                          if(stripos($msg, "login") || stripos($msg, "log") || stripos($msg, "reg") || stripos($msg, "register")) {
                            $snooper->sendMessage($sender->getName() . "> §4Hidden for security reasons");	
                          } else {
                            $snooper->sendMessage($sender->getName() . "> " . $msg);
                          }

                        }
                          }		
                        }
                    }    
  
//    public function onInventoryClose(InventoryCloseEvent $event) {
//            $player = $event->getPlayer();
//            if(isset($this->plugin->viewing[$player->getName()])) {
//                    $this->plugin->viewing[$player->getName()]->end();
//                    unset($this->plugin->viewing[$player->getName()]);
//            }
//            return;
//    }
  
}
