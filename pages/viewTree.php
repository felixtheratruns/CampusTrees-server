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
							<p>Tree information page</p>
                                                </div>
                                        </div>
                                        <div style="clear: both;">&nbsp;</div>

<?php
}
?>
