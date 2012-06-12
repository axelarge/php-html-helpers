<?php
namespace Axelarge\HtmlHelpers;

class Html
{
	/**
	 * Generates an HTML tag
	 *
	 * @param string $tagName Name of the tag
	 * @param array $attributes HTML attributes
	 * @param string $content Content of the tag. Omit to create a self-closing tag
	 * @param bool $escape_content
	 *
	 * @see attributes()
	 *
	 * @return string
	 */
	public static function tag($tagName, array $attributes = array(), $content = null, $escape_content = true)
	{
		$result = '<' . $tagName . static::attributes($attributes) . '>';

		if ($content !== null) {
			$result .= ($escape_content ? static::escape($content) : $content) . '</' . $tagName . '>';
		}

		return $result;
	}

	/**
	 * Converts an array of HTML attributes to a string
	 *
	 * If an attribute is false or null, it will not be set.
	 *
	 * If an attribute is true or is passed without a key, it will
	 * be set without an explicit value (useful for checked, disabled, ..)
	 *
	 * If an array is passed as a value, it will be joined using spaces
	 *
	 * Note: Starts with a space
	 * <code>
	 * Html::attributes(array('id' => 'some-id', 'selected' => false, 'disabled' => true, 'class' => array('a', 'b')));
	 * //=> ' id="some-id" disabled class="a b"'
	 * </code>
	 *
	 * @param array $attributes Associative array of attributes
	 *
	 * @return string
	 */
	public static function attributes(array $attributes)
	{
		$result = '';

		foreach ($attributes as $attribute => $value) {
			if ($value === false || $value === null) continue;
			if ($value === true) {
				$result .= ' ' . $attribute;
			} else if (is_numeric($attribute)) {
				$result .= ' ' . $value;
			} else {
				if (is_array($value)) { // support cases like 'class' => array('one', 'two')
					$value = implode(' ', $value);
				}
				$result .= ' ' . $attribute . '="' . static::escape($value) . '"';
			}
		}

		return $result;
	}

	/**
	 * Escapes a string for output in HTML
	 *
	 * @static
	 * @param string $string
	 * @return string
	 */
	public static function escape($string)
	{
		return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
	}
}
