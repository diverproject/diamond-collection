<?php

namespace diamond\collection;

use diamond\collection\exceptions\CollectionException;
use diamond\lang\Diamond;

/**
 * @see Collection
 * @author Andrew
 */
abstract class AbstractCollection implements Collection
{
	/**
	 * @var string
	 */
	private $generic;
	/**
	 * @var bool
	 */
	private $acceptNull;
	/**
	 * @var int
	 */
	protected $size;

	/**
	 *
	 * @param string $generic
	 */
	public function __construct(?string $generic = null)
	{
		$this->setGeneric($generic);
		$this->setAcceptNull(true);
		$this->init();
		$this->size = 0;
	}

	/**
	 *
	 */
	protected function init(): void
	{

	}

	/**
	 *
	 * @return string|NULL
	 */
	public final function getGeneric(): ?string
	{
		return $this->generic;
	}

	/**
	 *
	 * @throws CollectionException
	 * @param string $generic
	 */
	protected function setGeneric(?string $generic): void
	{
		if (!class_exists($generic) && !interface_exists($generic))
		{
			if (Diamond::isEnabledParseThrows())
				throw CollectionException::newGenericNotFound($generic);
			return;
		}

		foreach ($this as $element)
			if (!is_subclass_of($element, $generic))
			{
				if (Diamond::isEnabledParseThrows())
					throw CollectionException::newInvalidGeneric();
				return;
			}

		$this->generic = $generic;
	}

	/**
	 * @return bool
	 */
	public final function isAcceptNull(): bool
	{
		return $this->acceptNull;
	}

	/**
	 * @param bool $accept
	 */
	protected function setAcceptNull(bool $accept): void
	{
		$this->acceptNull = $accept;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::isEmpty()
	 */
	public function isEmpty(): bool
	{
		return $this->size() === 0;
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
	 * @see \Countable::count()
	 */
	public function count()
	{
		return $this->size();
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::contains()
	 */
	public function contains($element): bool
	{
		foreach ($this as $collectionElement)
			if ($collectionElement === $element)
				return true;

		return false;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::containsAll()
	 */
	public function containsAll(Collection $collection): bool
	{
		foreach ($collection as $element)
			if (!$this->contains($element))
				return false;

		return true;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::addAll()
	 */
	public function addAll(Collection $collection): bool
	{
		$modified = false;

		foreach ($collection as $element)
			if ($this->add($element))
				$modified = true;

		return $modified;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::removeAll()
	 */
	public function removeAll(Collection $collection): bool
	{
		$modified = false;

		foreach ($collection as $element)
			if ($this->remove($element))
				$modified = true;

		return $modified;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::retainAll()
	 */
	public function retainAll(Collection $collection): bool
	{
		$modified = false;

		foreach ($collection as $element)
			if (!$this->remove($element))
				$modified = true;

		return $modified;
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::toArray()
	 */
	public function toArray(): array
	{
		$array = [];

		foreach ($this as $index => $collectionElement)
			$array[$index] = $collectionElement;

		return $array;
	}

	/**
	 *
	 * @throws CollectionException
	 * @param mixed $element
	 */
	protected function parseGeneric($element)
	{
		if ($element === null && !$this->isAcceptNull())
			throw CollectionException::newNotNullValues(nameOf($this));

		if ($this->getGeneric() !== null)
			if (!is_subclass_of($element, $this->getGeneric()))
				if (Diamond::isEnabledParseThrows())
					throw CollectionException::newGenericParser($this->getGeneric());
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::rewind()
	 */
	public function rewind()
	{
		$this->iterator = $this->toArray();
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
	 * @see \Iterator::current()
	 */
	public function current()
	{
		return current($this->iterator);
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::key()
	 */
	public function key()
	{
		return key($this->iterator);
	}

	/**
	 * {@inheritDoc}
	 * @see \Iterator::next()
	 */
	public function next()
	{
		next($this->iterator);
	}

	/**
	 * {@inheritDoc}
	 * @see \JsonSerializable::jsonSerialize()
	 */
	public function jsonSerialize()
	{
		return $this->toArray();
	}

	/**
	 *
	 * @return string
	 */
	public function __toString(): string
	{
		return $this->jsonSerialize();
	}
}

