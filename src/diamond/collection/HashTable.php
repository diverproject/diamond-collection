<?php

namespace diamond\collection;

use diamond\lang\exceptions\UnsupportedMethodException;

/**
 * @author Andrew
 */
class HashTable extends AbstractCollection implements CollectionMap
{
	/**
	 * @var array
	 */
	private $table;

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\AbstractCollection::init()
	 */
	protected function init(): void
	{
		$this->clear();
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::clear()
	 */
	public function clear(): void
	{
		$this->table = [];
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionMap::containsKey()
	 */
	public function containsKey(string $key): bool
	{
		return isset($this->table[$key]);
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionMap::containsValue()
	 */
	public function containsValue($element): bool
	{
		foreach ($this->table as $tableElement)
			if ($tableElement === $element)
				return true;

		return false;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::add()
	 * @throws UnsupportedMethodException
	 */
	public function add($element): bool
	{
		throw new UnsupportedMethodException();
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionMap::put()
	 */
	public function put(string $key, $element): bool
	{
		if ($this->containsKey($key))
			return false;

		$this->table[$key] = $element;
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

		foreach ($map as $key => $element)
			if ($this->put($key, $element))
				$modified = true;

		return $modified;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::remove()
	 */
	public function remove($element): bool
	{
		foreach ($this->table as $key => $tableElement)
			if ($tableElement === $element)
			{
				unset($this->talbe[$key]);
				$this->size--;
				return true;
			}

		return false;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionMap::removeKey()
	 */
	public function removeKey(string $key): bool
	{
		if (!$this->containsKey($key))
			return false;

		unset($this->talbe[$key]);
		$this->size--;

		return true;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionMap::get()
	 */
	public function get(string $key)
	{
		return !$this->containsKey($key) ? null : $this->table[$key];
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\CollectionMap::values()
	 */
	public function values(): array
	{
		return array_values($this->toArray());
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::rewind()
	 */
	public function rewind()
	{
		reset($this->table);
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::current()
	 */
	public function current()
	{
		return current($this->table);
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
		next($this->table);
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::key()
	 */
	public function key()
	{
		return key($this->table);
	}
}

