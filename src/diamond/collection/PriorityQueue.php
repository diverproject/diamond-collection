<?php

namespace diamond\collection;

/**
 * @see CollectionList
 * @see CollectionQueue
 * @see AbstractCollectionLinked
 * @author Andrew
 */
class PriorityQueue extends AbstractCollectionLinked implements CollectionQueue
{
	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::add()
	 * @param Comparable $element
	 */
	public function add($element): bool
	{
		$this->parseGeneric($element);

		if ($this->size() === 0)
		{
			$this->first = $this->last = new DoubleNode($element);
			return $this->added();
		}

		$elementNode = new DoubleNode($element);
		$comparable = $this->first->getElement();
		$compare = $this->compare($element, $comparable);

		if ($compare <= 0)
		{
			$elementNode->setNext($this->first);
			$this->first->setPrevious($elementNode);
			$this->first = $elementNode;
			return $this->added();
		}

		$elementNode = new DoubleNode($element);
		$comparable = $this->last->getElement();
		$compare = $this->compare($element, $comparable);

		if ($compare >= 0)
		{
			$elementNode->setPrevious($this->last);
			$this->last->setNext($elementNode);
			$this->last = $elementNode;
			return $this->added();
		}

		$node = $this->last->getPrevious();

		do {

			$comparable = $node->getElement();
			$compare = $this->compare($element, $comparable);

			if ($compare >= 0)
			{
				$node->insertAfter($elementNode);
				return $this->added();
			}

		} while ($node = $node->getPrevious());

		return false;
	}

	private function compare($element, $comparable)
	{
		if ($element instanceof Comparable && $comparable instanceof Comparable)
			return $element->compareTo($comparable);

		return $element < $comparable ? -1 : ($element > $comparable ? 1 : 0);
	}

	/**
	 *
	 */
	private function added(): bool
	{
		$this->size++;
		return true;
	}

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
	 * @see \diamond\collection\Collection::contains()
	 */
	public function contains($element): bool
	{
		if (!$this->isEmpty())
		{
			for ($node = $this->first; $node !== null; $node = $node->getNext())
				if ($node->getElement() === $element)
					return true;
		}
		return false;
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
			$this->first = null;
		else
		{
			$next = $this->first->getNext();
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

