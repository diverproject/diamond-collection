<?php

namespace diamond\collection;

use diamond\lang\StringParser;

/**
 * @see AbstractCollection
 * @see CollectionMap
 * @author Andrew
 */
class HashMap extends AbstractCollection implements CollectionMap
{
	/**
	 * @var DoubleNodeKey[]
	 */
	private $table;

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\AbstractCollection::init()
	 */
	public function init(): void
	{
		$this->clear();
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::clear()
	 */
	public function clear(): void
	{
		$this->size = 0;
		$this->table = [];
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionMap::containsKey()
	 */
	public function containsKey(string $key): bool
	{
		if ($this->isEmpty() || StringParser::isEmpty($key) || !isset($this->table[($hash = $key{0})]))
			return false;

		$node = $this->table[$hash];

		while ($node !== null)
		{
			if ($node->getKey() === $key)
				return true;

			$node = $node->getNext();
		}

		return false;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionMap::containsValue()
	 */
	public function containsValue($element): bool
	{
		if ($this->isEmpty())
			return false;

		foreach ($this->table as $node)
			while ($node !== null)
			{
				if ($node->getElement() === $element)
					return true;

				$node = $node->getNext();
			}

		return false;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::add()
	 */
	public function add($element): bool
	{
		return $element instanceof MapItem ? $this->put($element->getKey(), $element->getValue()) : false;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionMap::put()
	 */
	public function put(string $key, $element): bool
	{
		if (StringParser::isEmpty($key))
			return false;

		$hash = $key{0};
		$node = new DoubleNodeKey($element);
		$node->setKey($key);

		if (!isset($this->table[$hash]))
			$this->table[$hash] = $node;

		else
		{
			if ($this->table[$hash]->getKey() === $key)
				return false;

			$tableNode = $this->table[$hash];

			if ($node->getKey() < $this->table[$hash]->getKey())
			{
				$node->setNext($tableNode);
				$tableNode->setPrevious($node);
				$this->table[$hash] = $node;
			}

			else if ($tableNode->getNext() === null)
			{
				$tableNode->setNext($node);
				$node->setPrevious($tableNode);
			}

			else
			{
				for ($tableNode = $tableNode->getNext(); $tableNode->getNext() !== null; $tableNode = $tableNode->getNext())
				{
					if ($tableNode->getKey() === $key)
						return false;

					if ($node->getKey() < $tableNode->getKey())
						if (($next = $tableNode->getNext()) === null)
						{
							$next->setPrevious($node);
							$node->setNext($next);
							break;
						}
				}

				if ($tableNode->getNext() === null)
				{
					$tableNode->setNext($node);
					$node->setPrevious($node);
				}
			}
		}

		$this->size++;
		return true;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionMap::putAll()
	 */
	public function putAll(CollectionMap $map): bool
	{
		$modified = false;

		foreach ($map as $element)
			if ($this->add($element))
				$modified = true;

		return $modified;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::remove()
	 */
	public function remove($element): bool
	{
		return $element instanceof MapItem ? $this->removeKey($element->getKey()) : false;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionMap::removeKey()
	 */
	public function removeKey(string $key): bool
	{
		if (StringParser::isEmpty($key) || !isset($this->table[($hash = $key{0})]))
			return false;

		$node = $this->table[$hash];

		do {

			if ($node->getKey() === $key)
			{
				if ($this->table[$hash] === $node)
					$this->table[$hash] = $node->getNext();
				else
				{
					if ($node->getNext() === null)
						$node->setPrevious(null);
					else
						$node->remove();
				}

				$this->size--;
				return false;
			}

		} while ($node = $node->getNext());

		return false;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionMap::get()
	 */
	public function get(string $key)
	{
		if ($this->isEmpty())
			return false;

		foreach ($this->table as $node)
			while ($node !== null)
			{
				if ($node->getKey() === $key)
					return $node->getElement();

				$node = $node->getNext();
			}

		return false;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionMap::values()
	 */
	public function values(): array
	{
		$offset = 0;
		$values = array_fill(0, $this->size(), null);

		foreach ($this->table as $node)
			while ($node !== null)
			{
				$values[$offset++] = $node->getElement();
				$node = $node->getNext();
			}

		return $values;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\AbstractCollection::toArray()
	 */
	public function toArray(): array
	{
		$array = [];

		foreach ($this->table as $node)
			while ($node !== null)
			{
				$array[$node->getKey()] = $node->getElement();
				$node = $node->getNext();
			}

		return $array;
	}
}

