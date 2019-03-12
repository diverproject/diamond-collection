<?php

namespace diamond\collection\exceptions;

/**
 * @see \Exception
 * @author Andrew
 */
class CollectionException extends \Exception
{
	/**
	 * @var int
	 */
	public const GENERIC_NOT_FOUND = 1;
	/**
	 * @var int
	 */
	public const INVALID_GENERIC = 2;
	/**
	 * @var int
	 */
	public const GENERIC_PARSER = 3;
	/**
	 * @var int
	 */
	public const NOT_NULL_VALUES = 4;

	/**
	 *
	 * @param string $message [optional]
	 * @param int $code [optional]
	 * @param \Throwable $previous [optional]
	 */
	public function __construct(?string $message = null, ?int $code = null, ?\Throwable $previous = null)
	{
		parent::__construct($message = null, $code = null, $previous = null);
	}

	/**
	 *
	 * @param string $generic
	 * @return CollectionException
	 */
	public static function newGenericNotFound(string $generic): CollectionException
	{
		return new CollectionException("class $generic not found", self::GENERIC_NOT_FOUND);
	}

	/**
	 *
	 * @return CollectionException
	 */
	public static function newInvalidGeneric(): CollectionException
	{
		return new CollectionException('invalid generic collection class', self::INVALID_GENERIC);
	}

	/**
	 *
	 * @param string $generic
	 * @return CollectionException
	 */
	public static function newGenericParser(string $generic): CollectionException
	{
		return new CollectionException("element generic parser failure into $generic", self::GENERIC_PARSER);
	}

	/**
	 *
	 * @param string $class_name
	 * @return CollectionException
	 */
	public static function newNotNullValues(string $class_name): CollectionException
	{
		return new CollectionException("collection $class_name not accept null values", self::NOT_NULL_VALUES);
	}
}

