<?php

namespace diamond\collection;

/**
 * @author Andrew
 */
interface MapItem
{
	/**
	 * @return string
	 */
	public function getKey(): string;

	/**
	 * @return mixed
	 */
	public function getValue();
}

