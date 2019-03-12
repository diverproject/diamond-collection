<?php

namespace diamond\collection;

/**
 * @see Collection
 * @author Andrew
 */
interface CollectionQueue extends Collection
{
	/**
	 *
	 * @param mixed $element
	 * @return bool
	 */
	public function offer($element): bool;

	/**
	 *
	 * @return mixed
	 */
	public function poll();

	/**
	 *
	 * @return mixed
	 */
	public function peek();

	/**
	 *
	 * @param mixed $element
	 * @return int|NULL
	 */
	public function search($element): ?int;
}

