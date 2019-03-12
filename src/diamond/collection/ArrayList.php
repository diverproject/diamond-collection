<?php

namespace diamond\collection;

use diamond\collection\exceptions\OutOfBoundsException;
use diamond\lang\IntParser;

/**
 * @see CollectionList
 * @see AbstractCollectionArray
 * @author Andrew
 */
class ArrayList extends AbstractCollectionArray implements CollectionList
{
	/**
	 * @var int
	 */
	private $length;

	/**
	 *
	 * @param int $length
	 * @param string $generic
	 */
	public function __construct(?int $length = null, ?string $generic = null)
	{
		parent::__construct($generic);

		if (is_int($length))
			$this->length = IntParser::capMin($length, 0);
		else
			$this->length = 0;

		$this->setAcceptNull($this->isDynamic());
		$this->clear();
	}

	/**
	 * @return bool
	 */
	public function isDynamic(): bool
	{
		return $this->length === 0;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::clear()
	 */
	public function clear(): void
	{
		$this->size = 0;
		$this->elements = $this->isDynamic() ? [] : array_fill(0, $this->length, null);
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\AbstractCollection::count()
	 */
	public function count(): int
	{
		return count($this->elements);
	}

	/**
	 *
	 * @param int $index
	 * @return bool
	 */
	public function hasIndex(int $index): bool
	{
		return $this->isDynamic() ? $index <= $this->size() : $index < $this->count();
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::add()
	 */
	public function add($element): bool
	{
		return $this->addIndex($this->size(), $element);
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionList::addIndex()
	 */
	public function addIndex(int $index, $element): bool
	{
		$this->parseGeneric($element);

		if (!$this->hasIndex($index))
			return false;

		if ($this->isDynamic())
		{
			if ($index === $this->size())
				array_push($this->elements, $element);
			else
				array_splice($this->elements, $index, 0, [$element]);

			$this->size++;
		}

		else
		{
			if ($this->elements[$index] === null)
				$this->size++;

			$this->elements[$index] = $element;
		}

		return true;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionList::setIndex()
	 */
	public function setIndex(int $index, $element): bool
	{
		$this->parseGeneric($element);

		if (!$this->hasIndex($index))
			return false;

		$this->elements[$index] = $element;
		return true;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::remove()
	 */
	public function remove($element): bool
	{
		if (($index = $this->indexOf($element)) === null)
			return false;

		return $this->removeIndex($index) !== null;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionList::removeIndex()
	 */
	public function removeIndex(int $index)
	{
		if (!$this->hasIndex($index))
			throw new OutOfBoundsException("índice $index inválido");

		if ($index === 0)
			$removed = array_shift($this->elements);

		else if ($index === $this->count() - 1)
			$removed = array_pop($this->elements);

		else
		{
			$removed = $this->elements[$index];
			array_splice($this->elements, $index, 1);
		}

		$this->size--;
		return $removed;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionList::get()
	 */
	public function get(int $index)
	{
		return $this->hasIndex($index) ? $this->elements[$index] : null;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionList::indexOf()
	 */
	public function indexOf($element): ?int
	{
		foreach ($this->elements as $index => $collectionElement)
			if ($collectionElement === $element)
				return $index;

		return null;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionList::lastIndexOf()
	 */
	public function lastIndexOf($element): ?int
	{
		for ($index = $this->size() - 1; $index >= 0; $index--)
			if ($this->elements[$index] === $element)
				return $index;

		return null;
	}
}

