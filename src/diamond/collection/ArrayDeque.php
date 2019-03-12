<?php

namespace diamond\collection;

/**
 * @see CollectionDeque
 * @see AbstractCollectionVector
 * @author Andrew
 */
class ArrayDeque extends AbstractCollectionVector implements CollectionDeque
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
	 * @var int
	 */
	private $iteration;
	/**
	 * @var int
	 */
	private $iterationOffset;

	/**
	 *
	 * @return int
	 */
	protected function addLastOffset(): int
	{
		$offset = $this->lastOffset;
		$this->lastOffset = ($this->lastOffset + 1) % $this->length();

		return $offset;
	}

	/**
	 *
	 * @return int
	 */
	protected function removeLastOffset(): int
	{
		return ($this->lastOffset = $this->lastOffset === 0 ? $this->length() - 1 : $this->lastOffset - 1);
	}

	/**
	 *
	 * @return int
	 */
	protected function addFirstOffset(): int
	{
		$offset = $this->firstOffset;
		$this->firstOffset = ($this->firstOffset + 1) % $this->length();

		return $offset;
	}

	/**
	 *
	 * @return int
	 */
	protected function removeFirstOffset(): int
	{
		return ($this->firstOffset = $this->firstOffset === 0 ? $this->length() - 1 : $this->firstOffset - 1);
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::clear()
	 */
	public function clear(): void
	{
		parent::clear();

		$this->firstOffset = 0;
		$this->lastOffset = 0;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionDeque::addFirst()
	 */
	public function addFirst($element): bool
	{
		if ($this->isFull())
			return false;

		$this->parseGeneric($element);
		$this->elements[$this->removeFirstOffset()] = $element;
		$this->size++;

		return true;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionDeque::addLast()
	 */
	public function addLast($element): bool
	{
		if ($this->isFull())
			return false;

		$this->parseGeneric($element);
		$this->elements[$this->addLastOffset()] = $element;
		$this->size++;

		return true;
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

		$indexRemoved = $this->addFirstOffset();
		$element = $this->elements[$indexRemoved];
		$this->elements[$indexRemoved] = null;
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

		$indexRemoved = $this->removeLastOffset();
		$element = $this->elements[$indexRemoved];
		$this->elements[$indexRemoved] = null;
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
		return $this->isEmpty() ? null : $this->elements[$this->firstOffset];
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionDeque::getLast()
	 */
	public function getLast()
	{
		return $this->isEmpty() ? null : $this->elements[$this->lastOffset === 0 ? $this->length() - 1 : $this->lastOffset - 1];
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
	 * @see \diamond\collection\CollectionDeque::removeFirstOccurrence()
	 */
	public function removeFirstOccurrence($element): bool
	{
		if (!$this->isEmpty())
		{
			if ($this->firstOffset < $this->lastOffset)
			{
				for ($i = $this->firstOffset; $i < $this->lastOffset; $i++)
					if ($this->elements[$i] === $element)
					{
						for ($j = $i; $j < $this->lastOffset; $j++)
							$this->elements[$j] = $this->elements[$j + 1];

						$this->elements[$this->lastOffset] = null;
						$this->removeLastOffset();
						$this->size--;
						return true;
					}
			}

			else
			{
				for ($i = $this->firstOffset; $i < $this->length(); $i++)
					if ($this->elements[$i] === $element)
					{
						for ($j = $i; $j >= $this->firstOffset && $j > 0; $j--)
							$this->elements[$j] = $this->elements[$j - 1];

						$this->elements[$this->firstOffset] = null;
						$this->addFirstOffset();
						$this->size--;
						return true;
					}

				for ($i = 0; $i < $this->lastOffset; $i++)
					if ($this->elements[$i] === $element)
					{
						for ($j = $i; $j < $this->lastOffset; $j++)
							$this->elements[$j] = $this->elements[$j + 1];

						$this->elements[$this->removeLastOffset()] = null;
						$this->size--;
						return true;
					}
			}
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
			if ($this->firstOffset < $this->lastOffset)
			{
				for ($i = $this->lastOffset - 1; $i >= $this->firstOffset; $i--)
					if ($this->elements[$i] === $element)
					{
						for ($j = $i; $j >= $this->firstOffset && $j > 0; $j--)
							$this->elements[$j] = $this->elements[$j - 1];

						$this->elements[$this->firstOffset] = null;
						$this->addFirstOffset();
						$this->size--;
						return true;
					}
			}

			else
			{
				for ($i = $this->lastOffset - 1; $i >= 0; $i--)
					if ($this->elements[$i] === $element)
					{
						for ($j = $i; $j < $this->lastOffset; $j++)
							$this->elements[$j] = $this->elements[$j + 1];

						$this->elements[$this->removeLastOffset()] = null;
						$this->size--;
						return true;
					}

				for ($i = $this->length() - 1; $i >= $this->firstOffset; $i--)
					if ($this->elements[$i] === $element)
					{
						for ($j = $i; $j >= $this->firstOffset; $j--)
							$this->elements[$j] = $this->elements[$j - 1];

						$this->elements[$this->removeFirstOffset()] = null;
						$this->size--;
						return true;
					}
			}
		}

		return false;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::add()
	 */
	public function add($element): bool
	{
		return $this->addLast($element);
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::remove()
	 */
	public function remove($element): bool
	{
		return $this->removeFirstOccurrence($element);
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionQueue::search()
	 */
	public function search($element): ?int
	{
		if (!$this->isEmpty())
		{
			foreach ($this->toArray() as $index => $dequeElement)
				if ($dequeElement === $element)
					return $index;
		}

		return null;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\AbstractCollectionArray::toArray()
	 */
	public function toArray(): array
	{
		if ($this->isEmpty())
			return [];

		if ($this->firstOffset < $this->lastOffset)
			return array_slice($this->elements, $this->firstOffset, $this->size());

		$firstSlice = array_slice($this->elements, $this->firstOffset);
		$secondSlice = array_slice($this->elements, 0, $this->lastOffset);

		return array_merge($firstSlice, $secondSlice);
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::rewind()
	 */
	public function rewind()
	{
		$this->iteration = 0;
		$this->iterationOffset = $this->firstOffset;
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::current()
	 */
	public function current()
	{
		return $this->elements[$this->iterationOffset];
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::valid()
	 */
	public function valid()
	{
		return $this->iteration < $this->size();
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::next()
	 */
	public function next()
	{
		$this->iteration++;
		$this->iterationOffset = ($this->iterationOffset + 1 % $this->length());
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::key()
	 */
	public function key()
	{
		return $this->iteration;
	}
}

