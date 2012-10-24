<?php 
/**
 * Add a currency format to the Number helper.  Makes reusing
 * currency formats easier.
 *
 * {{{ $number->addFormat('NOK', array('before' => 'Kr. ')); }}}
 * 
 * You can now use `NOK` as a shortform when formatting currency amounts.
 *
 * {{{ $number->currency($value, 'NOK'); }}}
 *
 * Added formats are merged with the following defaults.
 *
 * {{{
 *	array(
 *		'before' => '$', 'after' => 'c', 'zero' => 0, 'places' => 2, 'thousands' => ',',
 *		'decimals' => '.', 'negative' => '()', 'escape' => true
 *	)
 * }}}
 *
 * @param string $formatName The format name to be used in the future.
 * @param array $options The array of options for this format.
 * @return void
 * @see NumberHelper::currency()
 * @access public
 */

?>