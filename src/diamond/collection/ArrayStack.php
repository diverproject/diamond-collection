<?php

namespace diamond\collection;

/**
 * @see CollectionStack
 * @see AbstractCollectionVector
 * @author Andrew
 */
class ArrayStack extends AbstractCollectionVector implements CollectionStack
{
	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::add()
	 */
	public function add($element): bool
	{
		$this->elements[$this->size++] = $element;
		return true;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionStack::push()
	 */
	public function push($element): bool
	{
		return $this->add($element);
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionStack::pop()
	 */
	public function pop()
	{
		if ($this->isEmpty())
			return null;

		return $this->elements[--$this->size];
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionStack::peek()
	 */
	public function peek()
	{
		return $this->isEmpty() ? null : $this->elements[$this->size - 1];
	}
}

