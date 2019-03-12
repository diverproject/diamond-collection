<?php

namespace diamond\collection;

use diamond\collection\exceptions\OutOfBoundsException;

/**
 * @see CollectionList
 * @see CollectionQueue
 * @see AbstractCollectionLinked
 * @author Andrew
 */
class LinkedList extends AbstractCollectionLinked implements CollectionList, CollectionQueue
{
	/**
	 *
	 * @return bool
	 */
	private function added(): bool
	{
		$this->size++;
		return true;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionList::addIndex()
	 */
	public function addIndex(int $index, $element): bool
	{
		$node = new DoubleNode($element);

		if ($index === 0)
		{
			if ($this->isEmpty())
				$this->first = $this->last = $node;
			else
			{
				$node->setNext($this->first);
				$this->first->setPrevious($node);
				$this->first = $node;
			}

			return $this->added();
		}

		else if ($index === $this->size)
		{
			if ($this->size() === 1)
			{
				$node->setPrevious($this->first);
				$this->first->setNext($node);
				$this->last = $node;
			}

			else
			{
				$node->setPrevious($this->last);
				$this->last->setNext($node);
				$this->last = $node;
			}

			return $this->added();
		}

		else if ($this->hasIndex($index))
		{
			$listnode = $this->getNode($index);
			$listnode->insertBefore($node);
			return $this->added();
		}

		throw new OutOfBoundsException();
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionList::setIndex()
	 */
	public function setIndex(int $index, $element): bool
	{
		if (!$this->hasIndex($index))
			return false;

		$node = $this->getNode($index);
		$node->setElement($element);

		return true;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionList::replaceAll()
	 */
	public function replaceAll(Collection $collection): bool
	{
		$modified = false;

		foreach ($collection as $index => $element)
		{
			if (!is_int($index))
				continue;

			$node = $this->getNode($index);
			$node->setElement($element);
			$modified = true;
		}

		return $modified;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionList::removeIndex()
	 */
	public function removeIndex(int $index)
	{
		if (!$this->hasIndex($index))
			return false;

		$node = $this->getNode($index);
		$removed = $node->getElement();

		if ($node === $this->first)
		{
			$this->first = $this->first->getNext();

			if ($this->first !== null)
				$this->first->setPrevious(null);
		}

		else if ($node === $this->last)
		{
			$this->last = $this->last->getPrevious();

			if ($this->last !== null)
				$this->last->setNext(null);
		}

		else
			$node->remove();

		$this->size--;
		return $removed;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionList::get()
	 */
	public function get(int $index)
	{
		return ($node = $this->getNode($index)) !== null ? $node->getElement() : null;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionList::indexOf()
	 */
	public function indexOf($element): ?int
	{
		for ($i = 0, $iteration = $this->first; $i < $this->count(); $i++, $iteration = $iteration->getNext())
			if ($iteration->getElement() === $element)
				return $i;

		return null;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionList::lastIndexOf()
	 */
	public function lastIndexOf($element): ?int
	{
		for ($i = $this->count() - 1, $iteration = $this->last; $i >= 0; $i--, $iteration = $iteration->getPrevious())
			if ($iteration->getElement() === $element)
				return $i;

		return null;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\PriorityQueue::poll()
	 */
	public function poll()
	{
		if ($this->isEmpty())
			return null;

		$element = $this->first->getElement();

		if (($next = $this->first->getNext()) !== null)
			$next->setPrevious(null);

		$this->first->setNext(null);
		$this->first = $next;

		return $element;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\PriorityQueue::offer()
	 */
	public function offer($element): bool
	{
		return $this->addIndex($this->size(), $element);
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\PriorityQueue::search()
	 */
	public function search($element): ?int
	{
		return $this->indexOf($element);
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\PriorityQueue::peek()
	 */
	public function peek()
	{
		return $this->isEmpty() ? null : $this->get($this->size() - 1);
	}
}

