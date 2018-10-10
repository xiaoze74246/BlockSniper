<?php

namespace BlockHorizons\BlockSniper\brush\async;

use pocketmine\block\Block;
use pocketmine\level\SimpleChunkManager;
use pocketmine\math\Facing;

class BlockSniperChunkManager extends SimpleChunkManager{

	/**
	 * @param int $x
	 * @param int $z
	 * @param int $id
	 */
	public function setBiomeIdAt(int $x, int $z, int $id) : void{
		if($chunk = $this->getChunk($x >> 4, $z >> 4)){
			$chunk->setBiomeId($x & 0x0f, $z & 0x0f, $id);
		}
	}

	/**
	 * @param int $x
	 * @param int $z
	 *
	 * @return int
	 */
	public function getBiomeIdAt(int $x, int $z) : int{
		if($chunk = $this->getChunk($x >> 4, $z >> 4)){
			return $chunk->getBiomeId($x, $z);
		}

		return 0;
	}

	/**
	 * @param int $x
	 * @param int $y
	 * @param int $z
	 * @param int $side
	 *
	 * @return Block
	 */
	public function getSide(int $x, int $y, int $z, int $side) : Block{
		if($chunk = $this->getChunk($x >> 4, $z >> 4)){
			$block = Block::get($this->getSideId($x, $y, $z, $side), $this->getSideData($x, $y, $z, $side));
			$pos = [];
			switch($side){
				case Facing::DOWN:
					$pos = [$x, $y - 1, $z];
					break;
				case Facing::UP:
					$pos = [$x, $y + 1, $z];
					break;
				case Facing::NORTH:
					$pos = [$x, $y, $z - 1];
					break;
				case Facing::SOUTH:
					$pos = [$x, $y, $z + 1];
					break;
				case Facing::WEST:
					$pos = [$x - 1, $y, $z];
					break;
				case Facing::EAST:
					$pos = [$x + 1, $y, $z];
			}
			$block->setComponents($pos[0], $pos[1], $pos[2]);

			return $block;
		}

		return Block::get(Block::AIR);
	}

	public function getSideId(int $x, int $y, int $z, int $side) : int{
		if($chunk = $this->getChunk($x >> 4, $z >> 4)){
			switch($side){
				case Facing::DOWN:
					return $this->getBlockIdAt($x, $y - 1, $z);
				case Facing::UP:
					return $this->getBlockIdAt($x, $y + 1, $z);
				case Facing::NORTH:
					return $this->getBlockIdAt($x, $y, $z - 1);
				case Facing::SOUTH:
					return $this->getBlockIdAt($x, $y, $z + 1);
				case Facing::WEST:
					return $this->getBlockIdAt($x - 1, $y, $z);
				case Facing::EAST:
					return $this->getBlockIdAt($x + 1, $y, $z);
				default:
					return -1;
			}
		}

		return -1;
	}

	public function getSideData(int $x, int $y, int $z, int $side) : int{
		if($chunk = $this->getChunk($x >> 4, $z >> 4)){
			switch($side){
				case Facing::DOWN:
					return $this->getBlockDataAt($x, $y - 1, $z);
				case Facing::UP:
					return $this->getBlockDataAt($x, $y + 1, $z);
				case Facing::NORTH:
					return $this->getBlockDataAt($x, $y, $z - 1);
				case Facing::SOUTH:
					return $this->getBlockDataAt($x, $y, $z + 1);
				case Facing::WEST:
					return $this->getBlockDataAt($x - 1, $y, $z);
				case Facing::EAST:
					return $this->getBlockDataAt($x + 1, $y, $z);
				default:
					return -1;
			}
		}

		return -1;
	}
}