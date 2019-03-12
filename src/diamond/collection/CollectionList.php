<?php

namespace diamond\collection;

/**
 * @see Collection
 * @author Andrew
 */
interface CollectionList extends Collection
{
	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::add()
	 */
	public function addIndex(int $index, $element): bool;

	/**
	 *
	 * @param int $index
	 * @param mixed $element
	 * @return bool
	 */
	public function setIndex(int $index, $element): bool;

	/**
	 *
	 * @param Collection $collection
	 * @return bool
	 */
	public function replaceAll(Collection $collection): bool;

	/**
	 *
	 * @param int $index
	 * @return mixed
	 */
	public function removeIndex(int $index);

	/**
	 *
	 * @param int $index
	 * @return mixed
	 */
	public function get(int $index);

	/**
	 *
	 * @param mixed $element
	 * @return int|NULL
	 */
	public function indexOf($element): ?int;

	/**
	 *
	 * @param mixed $element
	 * @return int|NULL
	 */
	public function lastIndexOf($element): ?int;
}

