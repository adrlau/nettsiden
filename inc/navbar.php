<?php
function navbar($depth, $active = NULL) {
	$result = "\n\t<ul>\n";
	$menuItems = [
		'hjem' => '',
		'kalender' => 'kalender',
		'aktiviteter' => 'aktiviteter',
		'prosjekter' => 'prosjekt',
		'kontakt' => 'kontakt',
		'webmail' => 'https://webmail.pvv.ntnu.no/',
		'wiki' => 'pvv',
	];
	foreach($menuItems as $caption => $link) {
		if ($caption !== 'webmail') {
			$link = rtrim(str_repeat('../', $depth) . $link, '/') . '/';
		}
		$result .= "\t\t<li" . ($active === $link ? ' class="active"' : '') . '>'
			. '<a href="' . $link . '">'
			. $caption
			. "</a></li>\n"
			;
	}
	return $result . "\t</ul>\n";
}

function loginBar($sp = 'default-sp') {
	$result = "\n";
	require_once(__DIR__ . '/../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
	$as = new SimpleSAML_Auth_Simple($sp);

	$attr = $as->getAttributes();
	if($attr) {
		$uname = $attr['uid'][0];
		$result .= "\t<p class=\"login\">logget inn som: " . htmlspecialchars($uname) . "</p>\n";
	} else {
		$result .= "\t<a class=\"login\" href=\"" . htmlspecialchars($as->getLoginURL()) . "\">logg inn</a>\n";
	}

	return $result;
}