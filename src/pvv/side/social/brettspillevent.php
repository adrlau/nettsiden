<?php //declare(strict_types=1);
namespace pvv\side\social;

use \pvv\side\Event;

use \DateInterval;

class BrettspillEvent extends Event {

	public function getStop() {
		return $this->getStart()->add(new DateInterval('PT4H1800S'));
	}

	public function getName() /* : string */ {
		return "Brettspillkveld";
	}

	public function getLocation() /* : Location */ {
		return "Koserommet";
	}

	public function getOrganiser() /* : User */ {
		return "PVV";
	}

	public function getURL() /* : string */ {
		return '/brettspill/';
	}

	public function getImageURL() {
		return null;
	}

	public function getDescription() {
		return [
			'Er du en hardcore brettspillentusiast eller en nybegynner som har bare spilt ludo?' . "\n" .
			'Da er vårt brettspillkveld noe for deg.' . "\n" .
			'Vi tar ut et par spill fra vårt samling of spiller så mye vi orker. Kom innom!',

			'<a class="btn" href="#b_spill">Vår samling</a>',

			'<ul id="b_spill" class="collapsable">' . "\n" .
			'<li>Dominion*' . "\n" .
			'<li>Three cheers for master' . "\n" .
			'<li>Avalon' . "\n" .
			'<li>Hanabi' . "\n" .
			'<li>Cards aginst humanity*' . "\n" .
			'<li>Citadels' . "\n" .
			'<li>Munchkin**' . "\n" .
			'<li>Exploding kittens**' . "\n" .
			'<li>Aye dark overlord' . "\n" .
			'<li>Settlers of catan*' . "\n" .
			'<li>Risk**' . "\n" .
			'<li>og mange flere...' . "\n" .
			'</ul>',
			'*  Vi har flere ekspansjon til spillet',
			'** Vi har flere varianter av spillet'
			];
	}

}
