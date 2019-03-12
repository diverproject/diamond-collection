<?php

namespace diamond\collection;

/**
 * @see CollectionQueue
 * @see AbstractCollectionVector
 * @author Andrew
 */
class LoopQueue extends AbstractCollectionVector implements CollectionQueue
{
	/**
	 * @var int
	 */
	private $firstOffset;
	/**
	 * @var int
	 */
	private $lastOffset;

	/**
	 *
	 * @return int
	 */
	protected function addOffset(): int
	{
		$offset = $this->lastOffset;
		$this->lastOffset = ($this->lastOffset + 1) % $this->length();

		return $offset;
	}

	/**
	 *
	 * @return int
	 */
	protected function removeOffset(): int
	{
		$offset = $this->firstOffset;
		$this->firstOffset = ($this->firstOffset + 1) % $this->length();

		return $offset;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\AbstractCollectionVector::clear()
	 */
	public function clear(): void
	{
		parent::clear();

		$this->firstOffset = 0;
		$this->lastOffset = 0;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::add()
	 */
	public function add($element): bool
	{
		return $this->offer($element);
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionQueue::offer()
	 */
	public function offer($element): bool
	{
		if ($this->isFull())
			return false;

		$this->elements[$this->addOffset()] = $element;
		$this->size++;

		return true;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::remove()
	 */
	public function remove($element): bool
	{
		foreach ($this->elements as $index => $queueElement)
			if ($queueElement === $element)
			{
				array_splice($this->elements, $index, 1, [null]);
				$this->size--;
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
			return false;

		$removedOffset = $this->removeOffset();
		$element = $this->elements[$removedOffset];
		$this->elements[$removedOffset] = null;
		$this->size--;

		return $element;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionQueue::peek()
	 */
	public function peek()
	{
		if ($this->isEmpty())
			return false;

		return $this->elements[$this->firstOffset];
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\AbstractCollectionArray::toArray()
	 */
	public function toArray(): array
	{
		if ($this->firstOffset < $this->lastOffset)
			return array_slice($this->elements, $this->firstOffset, $this->size());

		$firstSlice = array_slice($this->elements, $this->firstOffset);
		$secondSlice = array_slice($this->elements, 0, $this->lastOffset);

		return array_merge($firstSlice, $secondSlice);
	}
}

