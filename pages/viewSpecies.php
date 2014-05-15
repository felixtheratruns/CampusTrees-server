<!-- This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.-->
<?php
$specid = $_GET['specId'];

require_once("/var/www/config.inc.php");
require_once(ROOT_DIR . 'classes/species.inc.php');
require_once(ROOT_DIR . 'classes/GenusTable.inc.php');
require_once(ROOT_DIR . 'classes/genus.inc.php');
require_once(ROOT_DIR . 'classes/FlowerMonthsTable.inc.php');
require_once(ROOT_DIR . 'classes/SeedingMonthsTable.inc.php');

if (empty($specid) || !isset($specid) || $specid<1) {

?>
					<div class="post">
                                                <h2 class="title"><a href="#">Unknown Species</a></h2>
                                                <div class="entry">
							<p>You did not select a valid species. Please go back, and try again.</p>
                                                </div>
                                        </div>
                                        <div style="clear: both;">&nbsp;</div>
<?php
}

else {
$s = new species($specid);
$info = $s->getProperties();
$gTable = new GenusTable();
$genus = $gTable->GetAll();
?>
					<div class="post">
                                                <h2 class="title"><a href="#">Species Information</a></h2>
                                                <div class="entry">
							<?php /*<img src="images/unknowntree.gif" style="float: left;">*/ ?>
							<h3>Basic Information</h3>
							<p>Common Name: <?php echo $info['commonname']; ?><br />
							Growth Factor: <?php echo $info['gf']; ?><br />
							Number of Trees on Campus: <?php echo $info['count']; ?></p>
							<h3>Regional Information</h3>
							<p>Native to N. America: <?php echo ($info['american'] ? "Yes" : "No"); ?><br />
							Native to Kentucky: <?php echo ($info['ky'] ? "Yes" : "No"); ?></p>
							<h3>Fruit Information</h3>
							<p>Fruit Type: <?php echo $info['fruittype']; ?><br />
							Fruit Edible: <?php echo ($info['edible'] ? "Yes*<br /><strong>*NOTE: Eat at your own risk</strong>" : "<strong>No</strong>"); ?><br /></p>
                                                </div>
                                        </div>
                                        <div style="clear: both;">&nbsp;</div>

<?php
}
?>
