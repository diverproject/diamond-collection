<?php

namespace diamond\collection;

/**
 * @author Andrew
 */
class Node
{
	/**
	 * @var mixed
	 */
	private $element;
	/**
	 * @var Node
	 */
	private $next;

	/**
	 *
	 * @param mixed $element
	 */
	public function __construct($element)
	{
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
	public function setElement($element)
	{
		$this->element = $element;
	}

	/**
	 * @return Node
	 */
	public function getNext(): ?Node
	{
		return $this->next;
	}

	/**
	 * @param Node $next
	 */
	public function setNext(?Node $next)
	{
		$this->next = $next;
	}
}

