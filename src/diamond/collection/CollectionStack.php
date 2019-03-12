<?php

namespace diamond\collection;

/**
 * @see Collection
 * @author Andrew
 */
interface CollectionStack extends Collection
{
	/**
	 *
	 * @param mixed $element
	 * @return bool
	 */
	public function push($element): bool;

	/**
	 *
	 * @return mixed
	 */
	public function pop();

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

