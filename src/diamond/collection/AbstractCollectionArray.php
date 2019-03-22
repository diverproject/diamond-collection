<?php

namespace diamond\collection;

/**
 * @see AbstractCollection
 * @author Andrew
 */
abstract class AbstractCollectionArray extends AbstractCollection
{
	/**
	 * @var array
	 */
	protected $elements = [];

	/**
	 * {@inheritDoc}
	 * @see \Iterator::rewind()
	 */
	public function rewind()
	{
		reset($this->elements);
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::current()
	 */
	public function current()
	{
		return current($this->elements);
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::valid()
	 */
	public function valid()
	{
		return $this->current() !== false;
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::next()
	 */
	public function next()
	{
		next($this->elements);
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::key()
	 */
	public function key()
	{
		return key($this->elements);
	}

	/**
	 *
	 * @param Collection $collection
	 * @return bool
	 */
	public function replaceAll(Collection $collection): bool
	{
		$modefied = false;

		foreach ($collection as $index => $element)
			if (isset($this->elements[$index]))
			{
				$this->elements[$index] = $element;
				$modefied = true;
			}

		return $modefied;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\AbstractCollection::toArray()
	 */
	public function toArray(): array
	{
		return array_slice($this->elements, 0, $this->size);
	}
}

