<?php

namespace diamond\collection;

/**
 * @see CollectionStack
 * @see AbstractCollectionLinked
 * @author Andrew
 */
class LinkedStack extends AbstractCollectionLinked implements CollectionStack
{
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

		$element = $this->last->getElement();

		if (($previous = $this->last->getPrevious()) !== null)
			$previous->setNext(null);

		$this->last->setPrevious(null);
		$this->last = $previous;
		$this->size--;

		return $element;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionStack::peek()
	 */
	public function peek()
	{
		return $this->isEmpty() ? null : $this->last->getElement();
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionStack::search()
	 */
	public function search($element): ?int
	{
		if (!$this->isEmpty())
		{
			for ($index = 0, $node = $this->first; $node !== null; $index++, $node = $node->getNext())
				if ($node->getElement() === $element)
					return $index;
		}

		return null;
	}
}

