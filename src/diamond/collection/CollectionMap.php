<?php

namespace diamond\collection;

/**
 * @see Collection
 * @author Andrew
 */
interface CollectionMap extends Collection
{
	/**
	 *
	 * @param string $key
	 * @return bool
	 */
	public function containsKey(string $key): bool;

	/**
	 *
	 * @param mixed $element
	 * @return bool
	 */
	public function containsValue($element): bool;

	/**
	 *
	 * @param string $key
	 */
	public function get(string $key);

	/**
	 *
	 * @param string $key
	 * @param mixed $element
	 * @return bool
	 */
	public function put(string $key, $element): bool;

	/**
	 *
	 * @param string $key
	 * @return bool
	 */
	public function removeKey(string $key): bool;

	/**
	 *
	 * @param CollectionMap $map
	 * @return bool
	 */
	public function putAll(CollectionMap $map): bool;

	/**
	 *
	 * @return array
	 */
	public function values(): array;
}

