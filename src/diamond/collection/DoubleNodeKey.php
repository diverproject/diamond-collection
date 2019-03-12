<?php

namespace diamond\collection;

/**
 * @see DoubleNode
 * @author Andrew
 */
class DoubleNodeKey extends DoubleNode
{
	/**
	 * @var string
	 */
	private $key;

	/**
	 * @return string
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * @param string $key
	 */
	public function setKey(string $key)
	{
		$this->key = $key;
	}

}

