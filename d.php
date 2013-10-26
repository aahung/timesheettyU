<?php

$id=$_GET['id'];

?>
<?php require("../../part_head.php") ?>
<body>
<div class="container">

	<?php $nav_wire = "idea"; require("../../part_header.php") ?>
	<!-- main -->
	<div class="row">
		<div class="col-sm-12">
			<h2 class="alert alert-info">If you are using in-app browser like in <large><em>WeChat</em></large> and BlaBla, please open this page in Chrome or Safari!</h2>
			<h3>file will be download in 3 seconds...</h3>
			<h1>if no response, click <a href="icsfile.php?id=<?php echo $id; ?>">HERE</a> to launch the download.</h1>
		</div>
	</div>
	<!-- /main -->
	<script type="text/javascript">
		$(function(){
			setTimeout(location.href="icsfile.php?id=<?php echo $id; ?>", 6000);
		})
	</script>
	<?php require("../../part_footer.php") ?>
</div>
</body>
</html>