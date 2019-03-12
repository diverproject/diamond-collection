<?php

namespace diamond\collection;

/**
 * @see AbstractCollection
 * @see DoubleNode
 * @author Andrew
 */
abstract class AbstractCollectionLinked extends AbstractCollection
{
	/**
	 * @var int
	 */
	protected $size;
	/**
	 * @var DoubleNode
	 */
	protected $first;
	/**
	 * @var DoubleNode
	 */
	protected $last;

	/**
	 *
	 * @param int $index
	 * @return DoubleNode
	 */
	protected function getNode(int $index): DoubleNode
	{
		if ($this->onHalf($index))
		{
			$iteration = $this->last;

			for ($i = $this->size() - 1; $i > $index; $i--)
				$iteration = $iteration->getPrevious();
		}

		else
		{
			$iteration = $this->first;

			for ($i = 0; $i < $index; $i++)
				$iteration = $iteration->getNext();
		}

		return $iteration;
	}

	/**
	 *
	 * @param int $index
	 * @return bool
	 */
	protected function onHalf(int $index): bool
	{
		return !$this->isEmpty() && $index >= ($this->size() / 2);
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\AbstractCollection::init()
	 */
	public function init(): void
	{
		$this->size = 0;
	}

	/**
	 *
	 * @param int $index
	 * @return bool
	 */
	public function hasIndex(int $index): bool
	{
		return $index < $this->size();
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::clear()
	 */
	public function clear(): void
	{
		if (($iteration = $this->first) !== null)
		{
			do {

				$iteration->setPrevious(null);
				$iteration->setElement(null);

			} while ($iteration = $iteration->getNext());
		}

		$this->size = 0;
		$this->first = $this->last = null;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::size()
	 */
	public function size(): int
	{
		return $this->size;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::add()
	 */
	public function add($element): bool
	{
		$this->parseGeneric($element);

		if ($this->size() === 0)
			$this->first = $this->last = new DoubleNode($element);
		else
		{
			$last = $this->last;
			$this->last = new DoubleNode($element);
			$this->last->setPrevious($last);
			$last->setNext($this->last);
		}

		$this->size++;
		return true;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::remove()
	 */
	public function remove($element): bool
	{
		if ($this->isEmpty())
			return false;

		$iteration = $this->first;

		do {

			if ($iteration->getElement() === $element)
			{
				if ($iteration === $this->first && $iteration === $this->last)
					$this->first = $this->last = null;

				else if ($iteration === $this->first)
				{
					$this->first = $this->first->getNext();
					$this->first->setPrevious(null);
				}

				else if ($iteration === $this->last)
				{
					$this->last = $this->last->getPrevious();
					$this->last->setNext(null);
				}

				else
				{
					$previous = $iteration->getPrevious();
					$next = $iteration->getNext();
					$previous->setNext($next);
					$next->setPrevious($previous);
				}

				$this->size--;
				return true;
			}

		} while ($iteration = $iteration->getNext());

		return false;
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::rewind()
	 */
	public function rewind()
	{
		$this->iteration = $this->first;
		$this->iterationCount = 0;
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::valid()
	 */
	public function valid()
	{
		return $this->iteration !== null;
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::current()
	 */
	public function current()
	{
		return $this->iteration->getElement();
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::key()
	 */
	public function key()
	{
		return $this->iterationCount;
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::next()
	 */
	public function next()
	{
		$this->iteration = $this->iteration->getNext();
		$this->iterationCount++;
	}
}

