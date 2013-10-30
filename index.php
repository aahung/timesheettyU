<?php require("../../part_head.php") ?>
<body>
<div class="container">

	<?php $nav_wire = "idea"; require("../../part_header.php") ?>
<!-- main -->
	<div class="row visible-xs visible-sm">
		<div class="col-sm-12">
			<br>
			<div class="alert alert-info">
				<small>You may need to use computer to implement the whole procedure.</small>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<h1><strong>TimeSheettyU</strong> <small><em>make the schedule easy!</em></small></h1>
			<h4>To automatically extract schedule from your CityU AIMS into your calendar Apps! <strong>AUTOMATICALLY!</strong></h4>
			<div class="well well-sm">
				<p>
					In CityU, everybody (almost) has a schedule, most students make a <strong>screenshot</strong> and save it into phones or set it as wallpaper.
					<br />
					<em>small, ugly, always out of style.</em>
					<br />
				</p>
				<h4>
					Input it into your calendar in your phone? one by one? <strong>What an annoying JOB!</strong>	
				</h4>
				<h2>	
					Now, you will never need to do it.
				</h2>
				<p class="lead">
					Here is <strong>TimeSheettyU</strong>, making schedule into your Calendar App, <strong>AUTOMATICALLY</strong>, reminder setting, weekly detecting, extendable, and simplifying your timetable!
				</p>
			</div>
		</div>
		<div class="col-sm-6 col-sm-offset-3">
			<iframe style="width: 100%; height: 300px;" src="//www.youtube.com/embed/xWTv19ozzOk" frameborder="0" allowfullscreen></iframe>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<h3>1. Open the "My Detail Schedule" in AIMS and see the source code;</h3>
		</div>
		<div class="col-sm-4">
			<h3>2. Copy the page's source code into the text box below;</h3>
		</div>
		<div class="col-sm-4">
			<h3>3. Use your phone to scan the QR Code to download the calendar file and ENJOY!</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<img class="img-responsive" src="img/1.png">
		</div>
		<div class="col-sm-4">
			<img class="img-responsive" src="img/2.png">
		</div>
		<div class="col-sm-4">
			<img class="img-responsive" src="img/3.png">
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<br>
			<div class="alert alert-warning">
				<em>You'd better use a new calendar to store the schedule (making the choice while opening the schedule file), in case your schedule is changing and if so you can simply remove the whole calendar then create a new one.</em>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-9" id="course_table" style="display: none">
			<h3>Let's check your course!</h3>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Course Name</th>
						<th><input id = "toggleAllCheckbox" type="checkbox" checked> Reminder</th>
						<th></th>
					</tr>
				</thead>
				<tbody id="course_rows">
					
				</tbody>
			</table>
		</div>
		<div id="input" class="col-sm-9">
			<div class="form-group">
				<label for="exampleInputEmail1">Paste the source code here:</label>
				<textarea class="form-control" rows="9" name="timetable_source" id="timetable_source" style="background: url('img/sc-placeholder.png')"></textarea>
			</div>
			<button onclick="doIt()" class="btn btn-default">Make Schedule Easy!</button>
		</div>
		<div class="col-sm-9" id="success_info" style="display: none">
			<p class="alert alert-success" id = "success_info_h1"></p>
		</div>

		<div id="QR" class="col-sm-3 text-center">
			<label>QR Code:</label>
			<div id="qrcode" style="margin: auto"></div>
			<br />
			<form id="get_it" role="form" style="display:none" >
			<button type="submit" class="btn btn-default">Get it!</button>
			</form>
			<script type="text/javascript" src="qrcode.min.js"></script>
			<script type="text/javascript">
				var qrcode = new QRCode("qrcode");

				function makeCode (value) {		
					qrcode.makeCode(value);
					
				}
				$(function(){
					$("#notice").html("If you find any bugs of have any ideas, just inform me: <a href='mailto:landxh@gmail.com'>landxh@gmail.com</a>:-)");
					qrcode.makeCode("mailto:landxh@gmail.com");
				})
			</script>
			
		</div>
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<p class="well" id="notice" style="text-align: center"></p>
			</div>
		</div>
		
	</div>
	<script src="main.js"></script>
	<script src="class.js"></script>
	<script src="http://dystroy.org/JSON.prune/.js"></script>
	<!-- /main -->
	<?php require("../../part_footer.php") ?>
</div>
</body>
</html>