<?php

namespace diamond\collection;

/**
 * @see AbstractCollectionArray
 * @author Andrew
 */
abstract class AbstractCollectionVector extends AbstractCollectionArray
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
	public function __construct(int $length, ?string $generic = null)
	{
		parent::__construct($generic);

		$this->length = $length;
		$this->setAcceptNull(false);
		$this->clear();
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::clear()
	 */
	public function clear(): void
	{
		$this->size = 0;
		$this->elements = array_fill(0, $this->length(), null);
	}

	/**
	 *
	 * @return int
	 */
	public function length(): int
	{
		return $this->length;
	}

	/**
	 *
	 * @return bool
	 */
	public function isFull(): bool
	{
		return $this->size() === $this->length();
	}

	/**
	 * {@inheritDoc}
	 * @see \diamond\collection\Collection::remove()
	 */
	public function remove($element): bool
	{
		foreach ($this->elements as $index => $vectorElement)
			if ($vectorElement === $element)
			{
				array_splice($this->elements, $index, 1, [null]);
				$this->size--;
				return true;
			}

		return false;
	}

	/**
	 *
	 * @param mixed $element
	 * @return int|NULL
	 */
	public function search($element): ?int
	{
		foreach ($this->elements as $index => $queueElement)
		{
			if ($queueElement === null)
				break;

			if ($queueElement === $element)
				return $index;
		}

		return null;
	}
}

