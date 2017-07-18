<?php

declare(strict_types = 1);

namespace BlockHorizons\BlockSniper\undo;

use pocketmine\block\Block;

class Undo implements Revert {
	
	private $undoBlocks;

	/**
	 * @param Block[] $undoBlocks
	 */
	public function __construct(array $undoBlocks) {
		$this->undoBlocks = $undoBlocks;
	}
	
	public function restore() {
		foreach($this->undoBlocks as $undoBlock) {
			$undoBlock->getLevel()->setBlock($undoBlock, $undoBlock, false, false);
		}
	}

	/**
	 * Should be called BEFORE the undo has been restored.
	 *
	 * @return Redo
	 */
	public function getDetachedRedo(): Redo {
		$redoBlocks = [];
		foreach($this->undoBlocks as $undoBlock) {
			$redoBlocks[] = $undoBlock->getLevel()->getBlock($undoBlock);
		}

		return new Redo($redoBlocks);
	}

	/**
	 * @return Block[]
	 */
	public function getBlocks(): array {
		return $this->undoBlocks;
	}

	/**
	 * @return int
	 */
	public function getBlockCount(): int {
		return count($this->undoBlocks);
	}
}