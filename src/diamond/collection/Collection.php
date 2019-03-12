<?php

namespace diamond\collection;

/**
 * @see Arrayable
 * @see \JsonSerializable
 * @author Andrew
 */
interface Collection extends Arrayable, \Iterator, \Countable, \JsonSerializable
{
	/**
	 *
	 */
	public function clear(): void;

	/**
	 *
	 * @return int
	 */
	public function size(): int;

	/**
	 *
	 * @return bool
	 */
	public function isEmpty(): bool;

	/**
	 *
	 * @param mixed $element
	 * @return bool
	 */
	public function contains($element): bool;

	/**
	 *
	 * @param Collection $collection
	 * @return bool
	 */
	public function containsAll(Collection $collection): bool;

	/**
	 *
	 * @param mixed $element
	 * @return bool
	 */
	public function add($element): bool;

	/**
	 *
	 * @param Collection $collection
	 * @return bool
	 */
	public function addAll(Collection $collection): bool;

	/**
	 *
	 * @param mixed $element
	 * @return bool
	 */
	public function remove($element): bool;

	/**
	 *
	 * @param Collection $collection
	 * @return bool
	 */
	public function removeAll(Collection $collection): bool;

	/**
	 *
	 * @param Collection $collection
	 * @return bool
	 */
	public function retainAll(Collection $collection): bool;

	/**
	 *
	 * @return array
	 */
	public function toArray(): array;
}

