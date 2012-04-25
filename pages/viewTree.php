<?php
$treeid = $_GET['treeId'];

require_once("/var/www/config.inc.php");
require_once(ROOT_DIR . 'classes/tree.inc.php');
require_once(ROOT_DIR . 'classes/SpeciesTable.inc.php');

if (empty($treeid) || !isset($treeid) || $treeid<1) {

?>
					<div class="post">
                                                <h2 class="title"><a href="#">Unknown Tree</a></h2>
                                                <div class="entry">
							<p>You did not select a valid tree. Please go back, and try again.</p>
                                                </div>
                                        </div>
                                        <div style="clear: both;">&nbsp;</div>
<?php
}

else {
$tree = new tree($treeid);
$info = $tree->getProperties();
$sTable = new SpeciesTable();
$species = $sTable->GetSpecies();
?>
					<div class="post">
                                                <h2 class="title"><a href="#">Tree Information</a></h2>
                                                <div class="entry">
							<?php /*<img src="images/unknowntree.gif" style="float: left;">*/ ?>
							<h3>Basic Information</h3>
							<p>Species: <a href="index.php?p=viewSpecies&amp;specId=<?php echo $info['sid']; ?>"><?php
foreach ($species as $s) {
	if ($s['sid'] == $info['sid']) {
		echo $s['commonname'];
		break;
	}
}
?></a><br />
							Age: <?php echo $info['age']; ?><br />
							Location: <?php echo $info['lat']; ?>, <?php echo $info['long']; ?></p>
							<h3>Tree Measurements</h3>
							<p>Height: <?php echo $info['height']; ?> ft<br />
							Volume: <?php echo $info['vol']; ?><br />
							Dry Weight: <?php echo $info['drywt']; ?> lbs<br />
							Green Weight: <?php echo $info['greenwt']; ?> lbs</p>
							<h3>Environmental Information</h3>
							<p>Weight of CO<sub>2</sub>/year: <?php echo $info['co2pyear']; ?> lbs<br />
							Weight of CO<sub>2</sub> in life: <?php echo $info['co2seqwt']; ?> lbs<br />
							Weight of Carbon: <?php echo $info['carbonwt']; ?> lbs</p>
                                                </div>
                                        </div>
                                        <div style="clear: both;">&nbsp;</div>

<?php
}
?>
