<?php

namespace diamond\collection;

/**
 * @see Collection
 * @see CollectionQueue
 * @see CollectionStack
 * @author Andrew
 */
interface CollectionDeque extends Collection, CollectionQueue
{
	/**
	 *
	 * @param mixed $element
	 * @return bool
	 */
	public function addFirst($element): bool;

	/**
	 *
	 * @param mixed $element
	 * @return bool
	 */
	public function addLast($element): bool;

	/**
	 *
	 * @param mixed $element
	 * @return bool
	 */
	public function offerFirst($element): bool;

	/**
	 *
	 * @param mixed $element
	 * @return bool
	 */
	public function offerLast($element): bool;

	/**
	 *
	 * @return mixed
	 */
	public function removeFirst();

	/**
	 *
	 * @return mixed
	 */
	public function removeLast();

	/**
	 *
	 * @return mixed
	 */
	public function pollFirst();

	/**
	 *
	 * @return mixed
	 */
	public function pollLast();

	/**
	 *
	 * @return mixed
	 */
	public function getFirst();

	/**
	 *
	 * @return mixed
	 */
	public function getLast();

	/**
	 *
	 * @return mixed
	 */
	public function peekFirst();

	/**
	 *
	 * @return mixed
	 */
	public function peekLast();

	/**
	 *
	 * @param mixed $element
	 * @return bool
	 */
	public function removeFirstOccurrence($element): bool;

	/**
	 *
	 * @param mixed $element
	 * @return bool
	 */
	public function removeLastOccurrence($element): bool;
}

