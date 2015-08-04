<?php
namespace System\Utility;

use Closure;
use BadMethodCallException;

class Html
{
	/**
	 * Custom tags.
	 *
	 * @var array
	 */
	protected static $tags = [];

	/**
	 * Registers a new HTML tag.
	 *
	 * @param   string  $name Tag name
	 * @param   Closure $tag  Tag closure
	 */
	public static function registerTag($name, Closure $tag)
	{
		static::$tags[$name] = $tag;
	}

	/**
	 * Takes an array of attributes and turns it into a string.
	 *
	 * @param   array $attributes Array of tags
	 * @return  string
	 */
	protected static function attributes($attributes)
	{
		$attr = '';

		foreach ($attributes as $attribute => $value) {
			if (is_int($attribute)) {
				$attribute = $value;
			}

			$attr .= ' ' . $attribute . '="' . $value . '"';
		}

		return $attr;
	}

	/**
	 * Creates a HTML5 tag.
	 *
	 * @param   string $name       Tag name
	 * @param   array  $attributes Tag attributes
	 * @param   string $content    Tag content
	 * @return  string
	 */
	public static function tag($name, array $attributes = [], $content = null)
	{
		return '<' . $name . static::attributes($attributes) . (($content === null) ? '/>' : '>' . $content . '</' . $name . '>');
	}

	/**
	 * Helper method for building media tags.
	 *
	 * @param   string $type       Tag type
	 * @param   mixed  $files      File or array of files
	 * @param   array  $attributes Tag attributes
	 * @return string
	 */
	protected static function buildMedia($type, $files, $attributes)
	{
		$sources = '';

		foreach ((array) $files as $file) {
			$sources .= static::tag('source', ['src' => $file]);
		}

		return static::tag($type, $attributes, $sources);
	}

	/**
	 * Creates audio tag with support for multiple sources.
	 *
	 * @param   mixed $files      File or array of files
	 * @param   array $attributes Tag attributes
	 * @return string
	 */
	public static function audio($files, array $attributes = [])
	{
		return static::buildMedia('audio', $files, $attributes);
	}

	/**
	 * Creates video tag with support for multiple sources.
	 *
	 * @param   mixed $files      File or array of files
	 * @param   array $attributes Tag attributes
	 * @return string
	 */
	public static function video($files, array $attributes = [])
	{
		return static::buildMedia('video', $files, $attributes);
	}

	/**
	 * Helper method for building list tags.
	 *
	 * @param   string $type       Tag type
	 * @param   mixed  $items      File or array of files
	 * @param   array  $attributes Tag attributes
	 * @return string
	 */
	protected static function buildList($type, $items, $attributes)
	{
		$list = '';

		foreach ($items as $item) {
			if (is_array($item)) {
				$list .= static::tag('li', [], static::buildList($type, $item, []));
			} else {
				$list .= static::tag('li', [], $item);
			}
		}

		return static::tag($type, $attributes, $list);
	}

	/**
	 * Builds an un-ordered list.
	 *
	 * @param   array $items      List items
	 * @param   array $attributes List attributes
	 * @return  string
	 */
	public static function ul(array $items, array $attributes = [])
	{
		return static::buildList('ul', $items, $attributes);
	}

	/**
	 * Builds am ordered list.
	 *
	 * @param   array $items      List items
	 * @param   array $attributes List attributes
	 * @return  string
	 */
	public static function ol(array $items, array $attributes = [])
	{
		return static::buildList('ol', $items, $attributes);
	}

	/**
	 * Magic shortcut to the custom HTML macros.
	 *
	 * @param   string $name      Method name
	 * @param   array  $arguments Method arguments
	 * @return  string
	 */
	public static function __callStatic($name, $arguments)
	{
		if (! isset(static::$tags[$name])) {
			throw new BadMethodCallException(sprintf("Call to undefined method %s::%s().", __CLASS__, $name));
		}

		array_unshift($arguments, new static);

		return call_user_func_array(static::$tags[$name], $arguments);
	}
}
