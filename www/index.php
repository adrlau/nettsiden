<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
require __DIR__ . '/../inc/navbar.php';
require __DIR__ . '/../src/_autoload.php';
require __DIR__ . '/../sql_config.php';

$translation = ['i dag', 'i morgen', 'denne uka', 'neste uke', 'denne måneden', 'neste måned'];
$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$agenda = new \pvv\side\Agenda([
		new \pvv\side\social\NerdepitsaActivity,
		new \pvv\side\social\AnimekveldActivity,
		new \pvv\side\DBActivity($pdo),
	]);

$motdfetcher = new \pvv\side\MOTD($pdo);
$motd = $motdfetcher->getMOTD();
?>

<!DOCTYPE html>
<html lang="no">
<head>
	<title>Programvareverkstedet</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/nav.css">
	<link rel="stylesheet" href="css/splash.css">
	<link rel="stylesheet" href="css/landing.css">

	<script>
	function navbar() {
		var x = document.getElementById("navbar");
		if (x.className === "opennav") {
			x.className = "";
		} else {
			x.className = "opennav";
		}
	}
	</script>
</head>

<body>
	<nav id="navbar" class="">
		<?php echo navbar(0, ''); ?>
		<?php echo loginbar(); ?>
	</nav>

	<header>
		<img class="logo" src="css/logo-white.png"/>
		<div class="info">
			<h2>Velkommen til Programvare&shy;verkstedet</h2>
			<p>Programvareverkstedet (PVV) er en studentorganisasjon ved NTNU som vil skape et miljø for datainteresserte personer tilknyttet universitetet.</p>
			<p>Nåværende og tidligere studenter ved NTNU, samt ansatte ved NTNU og tilstøtende miljø, kan bli medlemmer.</p>
			<ul class="essentials">
				<a class="btn" href="om/"><li>Om PVV</li></a>
				<a class="btn join" href="paamelding/"><li>Bli medlem</li></a>
				<a class="btn" href="https://use.mazemap.com/?v=1&amp;left=10.4032&amp;right=10.4044&amp;top=63.4178&amp;bottom=63.4172&amp;campusid=1&amp;zlevel=2&amp;sharepoitype=point&amp;sharepoi=10.40355%2C63.41755%2C2&amp;utm_medium=longurl"><li>Veibeskrivelse</li></a>
			</ul>
		</div>
	</header>

	<main class="contentsplit">
		<div class="gridr">
			<h2>Kommende aktiviteter</h2>
			<div class="calendar-events">
				<?php $counter1 = 0; ?>
				<?php $counter2 = 0; ?>
				<?php foreach($agenda->getNextDays() as $period => $events) if ($events && $counter1 < 3 && $counter2 < 10) { $counter1++ ?>
					<p class="no-chin"><?= $translation[$period] ?></p>
					<hr>
					<ul>
						<?php foreach($events as $event) { $counter2++ ?>
							<li>
							<a href="<?= htmlspecialchars($event->getURL()) ?>"><?= $event->getName(); ?></a>
							<?php /* <a class="icon subscribe">+</a> */ ?>
							<?php if ($period !== \pvv\side\Agenda::TODAY) {
								echo '<span class="time">' . $event->getStart()->format('H:i') . '</span>';
								if (\pvv\side\Agenda::isThisWeek($event->getStart()) || $event->getStart()->sub(new DateInterval('P3D'))->getTimestamp() < time()) {
									echo '<span class="date">' . strftime('%a', $event->getStart()->getTimestamp()) . '</span>';
								} else {
									echo '<span class="date">' . strftime('%e. %b', $event->getStart()->getTimestamp()) . '</span>';
								}
							} else {
								echo '<span class="time">' . $event->getStart()->format('H:i') . '</span>';
							}
							?>
						</li>
						<?php } ?>
					</ul>
				<?php } ?>
			</div>
			<p><a class="btn" href="kalender/">Flere aktiviteter</a></p>
		</div>

		<div class="gridl">
			<?php
				$title = $motd["title"];

				echo "<h2>";
				if($title == ""){
					echo "Dagens melding";
				}else{
					echo $title;
				}
				echo "</h2>";

				echo "<p>" . implode($motd["content"], "<br>") . "</p>";
			?>
		</div>
	</main>
</body>
</html>