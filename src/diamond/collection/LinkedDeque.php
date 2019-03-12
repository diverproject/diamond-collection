<?php

namespace diamond\collection;

/**
 * @see CollectionDeque
 * @see AbstractCollectionLinked
 * @author Andrew
 */
class LinkedDeque extends AbstractCollectionLinked implements CollectionDeque
{
	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionDeque::addFirst()
	 */
	public function addFirst($element): bool
	{
		if ($this->isEmpty())
			return $this->add($element);

		$node = new DoubleNode($element);
		$node->setNext($this->first);
		$this->first->setPrevious($node);
		$this->first = $node;
		$this->size++;

		return true;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionDeque::addLast()
	 */
	public function addLast($element): bool
	{
		return $this->add($element);
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionDeque::offerFirst()
	 */
	public function offerFirst($element): bool
	{
		return $this->addFirst($element);
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionDeque::offerLast()
	 */
	public function offerLast($element): bool
	{
		return $this->addLast($element);
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionDeque::removeFirst()
	 */
	public function removeFirst()
	{
		if ($this->isEmpty())
			return false;

		$element = $this->first->getElement();

		if (($next = $this->first->getNext()) === null)
			$this->first = $this->last = null;
		else
		{
			$next->setPrevious(null);
			$this->first->setNext(null);
			$this->first = $next;
		}

		$this->size--;
		return $element;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionDeque::removeLast()
	 */
	public function removeLast()
	{
		if ($this->isEmpty())
			return false;

		$element = $this->last->getElement();

		if (($previous = $this->last->getPrevious()) === null)
			$this->last = $this->first = null;
		else
		{
			$previous->setNext(null);
			$this->last->setPrevious(null);
			$this->last = $previous;
		}

		$this->size--;
		return $element;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionDeque::pollFirst()
	 */
	public function pollFirst()
	{
		return $this->removeFirst();
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionDeque::pollLast()
	 */
	public function pollLast()
	{
		return $this->removeLast();
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionDeque::getFirst()
	 */
	public function getFirst()
	{
		return $this->isEmpty() ? null : $this->first->getElement();
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionDeque::getLast()
	 */
	public function getLast()
	{
		return $this->isEmpty() ? null : $this->last->getElement();
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionDeque::peekFirst()
	 */
	public function peekFirst()
	{
		return $this->getFirst();
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionDeque::peekLast()
	 */
	public function peekLast()
	{
		return $this->getLast();
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionDeque::removeFirstOccurrence()
	 */
	public function removeFirstOccurrence($element): bool
	{
		if (!$this->isEmpty())
		{
			for ($node = $this->last; $node !== null; $node = $node->getPrevious())
				if ($node->getElement() === $element)
					return $this->removeNode($node);
		}

		return false;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionDeque::removeLastOccurrence()
	 */
	public function removeLastOccurrence($element): bool
	{
		if (!$this->isEmpty())
		{
			for ($node = $this->first; $node !== null; $node = $node->getNext())
				if ($node->getElement() === $element)
					return $this->removeNode($node);
		}

		return false;
	}

	/**
	 *
	 * @param DoubleNode $node
	 * @return bool
	 */
	private function removeNode(DoubleNode $node): bool
	{
		if ($node === $this->first)
		{
			if (($next = $this->first->getNext()) !== null)
				$next->setPrevious(null);

			$this->first->setNext(null);
			$this->first = $next;
		}

		else if ($node === $this->last)
		{
			if (($previous = $this->last->getPrevious()) !== null)
				$previous->setNext(null);

			$this->last->setPrevious(null);
			$this->last = $previous;
		}

		else
			$node->remove();

		$this->size--;
		return true;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionQueue::offer()
	 */
	public function offer($element): bool
	{
		return $this->offerLast($element);
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionQueue::poll()
	 */
	public function poll()
	{
		return $this->pollFirst();
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionQueue::peek()
	 */
	public function peek()
	{
		return $this->peekFirst();
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionQueue::search()
	 */
	public function search($element): ?int
	{
		if (!$this->isEmpty())
		{
			for ($i = 0, $node = $this->first; $node !== null; $i++, $node = $node->getNext())
				if ($node->getElement() === $element)
					return $i;
		}

		return null;
	}
}

