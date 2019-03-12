<?php

namespace diamond\collection;

/**
 * @see CollectionList
 * @see CollectionQueue
 * @see AbstractCollectionLinked
 * @author Andrew
 */
class LinkedQueue extends AbstractCollectionLinked implements CollectionQueue
{
	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionQueue::offer()
	 */
	public function offer($element): bool
	{
		return $this->add($element);
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionQueue::poll()
	 */
	public function poll()
	{
		if ($this->isEmpty())
			return null;

		$poll = $this->first->getElement();

		if ($this->size() === 1)
			$this->first = $this->last = null;
		else
		{
			$next = $this->first->getNext();

			if ($next === null)
				$next->setPrevious(null);

			$this->first->setNext(null);
			$this->first = $next;
		}

		$this->size--;
		return $poll;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionQueue::peek()
	 */
	public function peek()
	{
		if ($this->isEmpty())
			return null;

		return $this->first->getElement();
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionQueue::search()
	 */
	public function search($element): ?int
	{
		if (!$this->isEmpty())
			for ($node = $this->first, $i = 0; $node !== null; $node = $node->getNext(), $i++)
				if ($node->getElement() === $element)
					return $i;

		return null;
	}
}

