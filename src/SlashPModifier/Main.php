<?php

/** 
 * -----------------------------------------------------------
 * - All rights reserved InspectorGadget (c)                 -
 * - You can do whatever you want, it's Open Source anyways! -
 * -----------------------------------------------------------
*/

namespace SlashPModifier;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCommandPreprocessEvent;


class Main extends PluginBase implements Listener {

	public $commands = [
		"/plugins",
		"/pocketmine:plugins"
	];

	private $returnMessage;

	public function onEnable() : void {
		if (!is_dir($this->getDataFolder())) {
			@mkdir($this->getDataFolder());
			$this->getLogger()->info("Directory created...");
		}

		if (!is_file($this->getDataFolder() . "config.yml")) {
			$this->saveDefaultConfig();
		}

		$this->returnMessage = $this->getConfig()->get("message", []);
		$this->getServer()->getPluginManager()->registerEvents($this, $this);

		$this->getLogger()->info("All set, commmand blocked");
	}

	public function onPlayerCommandPreprocess(PlayerCommandPreprocessEvent $e) : void {
		if ($this->getConfig()->get("enable") === true) {
			$player = $e->getPlayer();
			$cmd = strtolower(explode(" ", $e->getMessage())[0]);

			if (in_array($cmd, $this->commands)) {
				foreach ($this->returnMessage as $line) {
					$player->sendMessage($line);
				}
				$e->setCancelled(true);
			}
		}
	}

}




