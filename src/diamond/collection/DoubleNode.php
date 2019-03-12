<?php

namespace diamond\collection;

/**
 * @author Andrew
 */
class DoubleNode
{
	/**
	 * @var mixed
	 */
	private $element;
	/**
	 * @var DoubleNode
	 */
	private $next;
	/**
	 * @var DoubleNode
	 */
	private $previous;

	/**
	 *
	 * @param mixed $element
	 */
	public function __construct($element)
	{
		$this->element = $element;
	}

	/**
	 * @return mixed
	 */
	public function getElement()
	{
		return $this->element;
	}

	/**
	 * @param mixed $element
	 */
	public function setElement($element): void
	{
		$this->element = $element;
	}

	/**
	 * @return DoubleNode
	 */
	public function getNext(): ?DoubleNode
	{
		return $this->next;
	}

	/**
	 * @param DoubleNode $next
	 */
	public function setNext(?DoubleNode $next): void
	{
		$this->next = $next;
	}

	/**
	 * @return DoubleNode
	 */
	public function getPrevious(): ?DoubleNode
	{
		return $this->previous;
	}

	/**
	 *
	 * @param DoubleNode $previous
	 */
	public function setPrevious(?DoubleNode $previous): void
	{
		$this->previous = $previous;
	}

	/**
	 *
	 * @param DoubleNode $node
	 */
	public function insertAfter(DoubleNode $node): void
	{
		$next = $this->getNext();
		$next->setPrevious($node);
		$node->setNext($next);
		$node->setPrevious($this);
		$this->setNext($node);
	}

	/**
	 *
	 * @param DoubleNode $node
	 */
	public function insertBefore(DoubleNode $node): void
	{
		$previous = $this->getPrevious();
		$previous->setNext($node);
		$node->setPrevious($previous);
		$node->setNext($this);
		$this->setPrevious($node);
	}

	/**
	 *
	 * @return bool
	 */
	public function remove(): bool
	{
		if ($this->getPrevious() !== null && $this->getNext() !== null)
		{
			$this->getNext()->setPrevious($this->getPrevious());
			$this->getPrevious()->setNext($this->getNext());
			$this->setNext(null);
			$this->setPrevious(null);
			return true;
		}

		return false;
	}
}

