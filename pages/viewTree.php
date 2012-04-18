<?php
$treeid = $_GET['treeId'];

if (empty($treeid) || !isset($treeid)) {

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
?>
					<div class="post">
                                                <h2 class="title"><a href="#">Tree Information</a></h2>
                                                <div class="entry">
							<?php /*<img src="images/unknowntree.gif" style="float: left;">*/ ?>
							<h3>Basic Information</h3>
							<p>Species: &lt;SPECIES&gt;<br />
							Age: &lt;AGE&gt;<br />
							Location: &lt;LAT&gt;, &lt;LONG&gt;</p>
							<h3>Tree Measurements</h3>
							<p>Height: &lt;HEIGHT&gt;<br />
							Volume: &lt;VOLUME&gt;<br />
							Dry/Green Weight: &lt;DRY_WEIGHT&gt;/&lt;GREEN_WEIGHT&gt;</p>
							<h4>Environmental Information</h4>
							<p>Weight of CO<sub>2</sub>/year: &lt;CO2_YEAR&gt;<br />
							Weight of CO<sub>2</sub> in life: &lt;CO2_LIFE&gt;<br />
							Weight of Carbon: &lt;CARBON_WEIGHT&gt;</p>
                                                </div>
                                        </div>
                                        <div style="clear: both;">&nbsp;</div>

<?php
}
?>
