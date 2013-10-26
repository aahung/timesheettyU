<?php 
	date_default_timezone_set('Asia/Hong_Kong');
	$json_got = $_POST["string"];
	$obj = json_decode($json_got, true);
	$userName = $obj["name"];
	$semester = $obj['semester'];
	$_time = date(DATE_RFC2822);
	$_forHASH = $userName . $semester . $_time;
	$did = hash( "sha256", $_forHASH);
	$EID = $obj['EID'];
	require('template.php');
	require('function.php');

	foreach ($obj["course"] as $course) {
		$SUMMARY = $course["name"];
		$location = $course["timeCollection"]['time'][0]['location'];
		$_remind = $course["reminder"];
		if ($_remind != 0 && $_remind != '0') {
			$remindText = $_remind . 'H0M0S';
			$remindText = str_replace(array('%DESCRIPTION%', '%REMINDTIME%'), 
			array($location, $remindText), $remind_template);
		}
		else {
			$remindText = "";
		}
		$DESCRIPTION = $course[""];
		foreach ($course["timeCollection"]['time'] as $time) {
			$UID = hash("sha256", $userName . $_time . $SUMMARY);
			$startDate = generateDate($time['startYr'], $time['startMon'], $time['startDay']);
			$endDate = generateDate($time['endYr'], $time['endMon'], $time['endDay']);
			$startTime = generateTime($time['startHr'], $time['startMin']);
			$endTime = generateTime($time['endHr'], $time['endMin']);
			$day = generateDay($time['day']);
			$DTSTART = $startDate . "T" . $startTime;
			$DTEND = $startDate . "T" . $endTime;
			$UNTIL = $endDate . "T" . $endTime;
			$BYDAY = $day; 
			$LOCATION = $location;
			$DESCRIPTION = $time['instructor'];
			$vevent = str_replace(array('%UID%', '%DTSTART%', '%DTEND%', '%UNTIL%', '%BYDAY%', '%DESCRIPTION%', '%LOCATION%', '%SUMMARY%', '%REMIND%'), 
		array($UID, $DTSTART, $DTEND, $UNTIL, $BYDAY, $DESCRIPTION, $LOCATION, $SUMMARY, $remindText), $str_template);
			$ics .= $vevent;
		}
	}
	$ics .= $ics_end;


	require("data_process/connect.php");
	$sql = "INSERT INTO JSON (content, did, pid, name, semester, time, raw) VALUES 
			(:content, :did, :pid, :name, :semester, :time, :raw)";
	try {
		$st = $conn -> prepare( $sql );
		$st -> bindValue( ":content", $ics, PDO::PARAM_STR);
		$st -> bindValue( ":did", $did, PDO::PARAM_STR);
		$st -> bindValue( ":pid", $EID, PDO::PARAM_STR);
		$st -> bindValue( ":name", $userName, PDO::PARAM_STR);
		$st -> bindValue( ":semester", $semester, PDO::PARAM_STR);
		$st -> bindValue( ":time", $_time, PDO::PARAM_STR);
		$st -> bindValue( ":raw", $json_got, PDO::PARAM_STR);
		$st -> execute();
    	echo json_encode($did);
	}
	catch(PDOException $e) {
		echo json_encode($e -> getMessage());
	}
?>