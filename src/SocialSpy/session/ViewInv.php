<?php

namespace SocialSpy\session;

use pocketmine\Player;
use pocketmine\inventory\PlayerInventory;
use pocketmine\utils\TextFormat as TF;

class ViewInv {
        
        public $owner = null;
        
        public $target = null;
        
        public $lastKnownInv = null;
        
        public function __construct(Player $owner, Player $target, $open = false) {
                $this->owner = $owner;
                $this->target = $target;
                if($open) {
                        $this->open();
                }
        }
        
        public function open() {
                $this->lastKnownInv = clone $this->owner->getInventory();
                $this->owner->getInventory()->setArmorContents($this->target->getInventory()->getArmorContents());
                $this->owner->getInventory()->sendArmorContents($this->owner);
                $this->owner->getInventory()->setContents($this->target->getInventory()->getContents());
                $this->owner->getInventory()->sendContents($this->owner);
                $this->owner->sendMessage(TF::GREEN . "§bYou are now viewing " . TF::BOLD . TF::DARK_AQUA . $this->target->getName() . TF::RESET . TF::GREEN . "'s §binventory, run " . TF::BOLD . TF::DARK_AQUA . "§bPlease use: §3/viewinv" . TF::RESET . TF::GREEN . " §bto exit.");
                
        }
        
        public function close() {
                if(isset($this->lastKnownInv) and $this->lastKnownInv instanceof PlayerInventory) {
                        $this->owner->getInventory()->clearAll();
                        $this->owner->getInventory()->setArmorContents($this->lastKnownInv->getArmorContents());
                        $this->owner->getInventory()->sendArmorContents($this->owner);
                        $this->owner->getInventory()->setContents($this->lastKnownInv->getContents());
                        $this->owner->getInventory()->sendContents($this->owner);
                        $this->lastKnownInv = null;
                        $this->owner->sendMessage(TF::GOLD . "§bYou are no longer viewing " . TF::BOLD . TF::DARK_AQUA . $this->target->getName() . TF::RESET . TF::GOLD . "'s §binventory!");
                }
        }
        
        public function end() {
                $this->close();
                unset($this->owner);
                unset($this->target);
                unset($this->lastKnownInv);
        }
        
        public function __destruct() {
                $this->end();
        }
        
}
