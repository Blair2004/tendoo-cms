<?php
namespace System\I18n;

use ArrayObject;
use RuntimeException;

class TextDomain extends ArrayObject
{
	/**
	 * Plural rule.
	 *
	 * @var string
	 */
	protected $pluralRule;

	/**
	 * Default plural rule shared between instances.
	 *
	 * @var object
	 */
	protected static $defaultPluralRule;

	/**
	 * Set the plural rule
	 *
	 * @param  PluralRule $pluralRule
	 * @return TextDomain
	 */
	public function setPluralRule(PluralRule $pluralRule)
	{
		$this->pluralRule = $pluralRule;

		return $this;
	}

	/**
	 * Get the plural rule.
	 *
	 * @param  bool $fallbackToDefaultRule
	 * @return PluralRule
	 */
	public function getPluralRule($fallbackToDefaultRule = true)
	{
		if ($this->pluralRule === null and $fallbackToDefaultRule) {
			return static::getDefaultPluralRule();
		}

		return $this->pluralRule;
	}

	/**
	 * Checks whether the text domain has a plural rule.
	 *
	 * @return bool
	 */
	public function hasPluralRule()
	{
		return ($this->pluralRule !== null);
	}

	/**
	 * Returns a shared default plural rule.
	 *
	 * @return string
	 */
	public static function getDefaultPluralRule()
	{
		if (static::$defaultPluralRule === null) {
			static::$defaultPluralRule = new PluralRule('nplurals=2; plural=n != 1;');
		}

		return static::$defaultPluralRule;
	}

	/**
	 * Merge another text domain with the current one.
	 * The plural rule of both text domains must be compatible for a successful
	 * merge. We are only validating the number of plural forms though, as the
	 * same rule could be made up with different expression.
	 *
	 * @param  TextDomain $textDomain
	 * @return TextDomain
	 * @throws RuntimeException
	 */
	public function merge(TextDomain $textDomain)
    {
        if ($this->hasPluralRule() and $textDomain->hasPluralRule()) {
            if ($this->getPluralRule()->getNumPlurals() !== $textDomain->getPluralRule()->getNumPlurals()) {
                throw new RuntimeException(
	                'Plural rule of merging text domain is not compatible with the current one'
                );
            }
        } elseif ($textDomain->hasPluralRule()) {
            $this->setPluralRule($textDomain->getPluralRule());
        }

        $this->exchangeArray(
            array_replace(
                $this->getArrayCopy(),
                $textDomain->getArrayCopy()
            )
        );

        return $this;
    }
}
