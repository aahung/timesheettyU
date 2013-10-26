<?php 
	$json_got = $_POST["string"];
	$obj = json_decode($json_got, true);
	$did = $obj["id"];
	$pid = $obj["pid"];
	$ics = "BEGIN:VCALENDAR
PRODID:-//CityofU//by Aahung - ideati.me//EN
VERSION:2.0
CALSCALE:GREGORIAN
METHOD:PUBLISH
X-WR-CALNAME:liuxh128@gmail.com
X-WR-TIMEZONE:Asia/Hong_Kong
BEGIN:VTIMEZONE
TZID:Asia/Hong_Kong
X-LIC-LOCATION:Asia/Hong_Kong
BEGIN:STANDARD
TZOFFSETFROM:+0800
TZOFFSETTO:+0800
TZNAME:HKT
DTSTART:19700101T000000
END:STANDARD
END:VTIMEZONE
";
$str_template = "BEGIN:VEVENT
DTSTART:%DTSTART%
DTEND:%DTEND%
RRULE:FREQ=WEEKLY;UNTIL=%UNTIL%;WKST=MO;BYDAY=%BYDAY%
DTSTAMP:20131003T083657Z
UID:%UID%
CREATED:20121110T145627Z
DESCRIPTION:%DESCRIPTION%
LAST-MODIFIED:20121110T145627Z
LOCATION:%LOCATION%
SEQUENCE:0
STATUS:CONFIRMED
SUMMARY:%SUMMARY%
TRANSP:OPAQUE
BEGIN:VALARM
ACTION:DISPLAY
DESCRIPTION:%DESCRIPTION%
TRIGGER:-P0DT%REMINDTIME%
END:VALARM
END:VEVENT
";
$UID = "D9DA128666614D4C9CDD90BD62AEE43400000000000000000000000000077777";
$ics_end = "END:VCALENDAR";
$REMINDTIME = "1H0M0S";
foreach ($obj["course"] as $course) {
	$SUMMARY = $course["name"];
	$DESCRIPTION = $course["instructor"];
	if (is_array($course["time"])) {
		foreach ($course["time"] as $time) {
			$UID ++;
			$DTSTART = $time["date_start"] . "T" . $time["time_start"];
			$DTEND = $time["date_start"] . "T" . $time["time_end"];
			$UNTIL = $time["date_end"] . "T" . $time["time_end"];
			$BYDAY = $time["day_inweek"]; 
			$LOCATION = $time["location"];
			$vevent = str_replace(array('%UID%', '%DTSTART%', '%DTEND%', '%UNTIL%', '%BYDAY%', '%DESCRIPTION%', '%LOCATION%', '%SUMMARY%', '%REMINDTIME%'), 
		array($UID, $DTSTART, $DTEND, $UNTIL, $BYDAY, $DESCRIPTION, $LOCATION, $SUMMARY, $REMINDTIME), $str_template);
			$ics .= $vevent;
		}
	}
	
}
$ics .= $ics_end;





	require("data_process/connect.php");
	$sql = "INSERT INTO JSON (content, did, pid) VALUES 
			(:content, :did, :pid)";
	try {
		$st = $conn -> prepare( $sql );
		$st -> bindValue( ":content", $ics, PDO::PARAM_STR);
		$st -> bindValue( ":did", $did, PDO::PARAM_STR);
		$st -> bindValue( ":pid", $pid, PDO::PARAM_STR);
		$st -> execute();
    	echo json_encode("Success!");
	}
	catch(PDOException $e) {
		echo json_encode($e -> getMessage());
	}
?>