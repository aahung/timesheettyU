// define CourseCollection
function CourseCollection(EID, semester, name){
	this.course = [];
	this.EID = EID;
	this.name = name;
	this.semester = semester;
}
CourseCollection.prototype.add = function(x) {
	this.course.push(x);
}
CourseCollection.prototype.remove = function(x) {
	var index = this.course.indexOf(x);
	if (index > -1) {
		this.course.splice(index, 1);
	}
}
CourseCollection.prototype.toJSON = function() {
	var json = JSON.stringify(this);
	json = json.replace(/\"\\n/g, "\"");
	json = json.replace(/\\n\"/g, "\"");
	return json;
}
// define Course
function Course(){
	this.name;
	this.reminder = 1;
	this.timeCollection = new TimeCollection();
}
Course.prototype.name = function(x) {
	this.name = x;
}
Course.prototype.setReminder = function(x) {
	this.reminder = x;
}
// define TimeCollection
function TimeCollection() {
	this.time = [];
}
TimeCollection.prototype.add = function(x) {
	this.time.push(x);
}
TimeCollection.prototype.remove = function() {
	var index = this.time.indexOf(x);
	if (index > -1) {
		this.time.splice(index, 1);
	}
}

// define Time
function Time() {
	this.startHr;
	this.startMin;
	this.endHr;
	this.endMin;
	this.day;
	this.startYr;
	this.startMon;
	this.startDay;
	this.endYr;
	this.endMon;
	this.endDay;
	this.instructor = "";
	this.location;
}
Time.prototype.getTime = function(x) {
	var st, sh, sm, et, eh, em;
	st = x.split(" - ")[0];
	et = x.split(" - ")[1];
	sh = st.split(" ")[0].split(":")[0];
	if (st.split(" ")[1] == "pm" && parseInt(sh) != 12) {
		sh = parseInt(st) + 12;
	}
	eh = et.split(" ")[0].split(":")[0];
	if (et.split(" ")[1] == "pm" && parseInt(eh) != 12) {
		eh = parseInt(et) + 12;
	}
	sm = st.split(" ")[0].split(":")[1];
	em = et.split(" ")[0].split(":")[1];
	this.startHr = sh;
	this.startMin = sm;
	this.endHr = eh;
	this.endMin = em;
}
Time.prototype.getInstructor = function(x) {
	this.instructor = x;
}
Time.prototype.getLocation = function(x) {
	this.location = x;
}
Time.prototype.getDay = function(x) {
	var dayList1Char = ['M', 'T', 'W', 'R', 'F', 'S', ''];
	this.day = dayList1Char.indexOf(x);
}
// WARNING!!  getDay must be called before getDate!!!
Time.prototype.getDate = function(x) {
	var monthList = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	var st, sy, sm, sd, et, ey, em, ed;
	st = x.split(" - ")[0];
	et = x.split(" - ")[1];
	sm = st.split(", ")[0].split(" ")[0];
	sm = monthList.indexOf(sm);
	em = et.split(", ")[0].split(" ")[0];
	em = monthList.indexOf(em);
	sd = st.split(", ")[0].split(" ")[1];
	ed = et.split(", ")[0].split(" ")[1];
	sy = st.split(", ")[1];
	ey = et.split(", ")[1];
	var sa = [sy, sm, sd];
	sa = reviseStartDate(sa, this.day);
	this.startYr = sa[0];
	this.startMon = sa[1];
	this.startDay = sa[2];
	this.endYr = ey;
	this.endMon = em;
	this.endDay = ed;
	function reviseStartDate(y, thisday) {
		var yy = y[0];
		var ym = y[1];
		var yd = y[2];
		ym = parseInt(ym) + 1;
		if (ym < 10) {
			ym = '0' + ym;
		}
		var str = yy + "-" + ym + "-" + yd;
		var ydate = new Date(str);
		ydate.setDate(ydate.getDate() - ydate.getDay() + 1 + thisday);
		return [ydate.getFullYear(), ydate.getMonth(), ydate.getDate()] ;
	}
}

// about table

Course.prototype.CreateTableRow = function() {
	var courseItself = this;
	var row = document.createElement('tr');
	var nametd = document.createElement('td');
	$(nametd).text(this.name);
	var reminder = document.createElement('td');
	var number = document.createElement('input');
	number.type = 'number';
	number.value = 1;
	$(number).change(function(){
		if (this.value % 1 != 0) {
			this.value = Math.floor(this.value);
		}
		if (checkbox.checked) {
			courseItself.setReminder(this.value);
		}
	})
	var checkbox = document.createElement('input');
	$(checkbox).addClass("isReminded");
	checkbox.type = "checkbox";
	checkbox.checked = 1;
	$(checkbox).change(function(){
		if (this.checked){
			courseItself.setReminder(number.value);
		}
		else {
			courseItself.setReminder(0);
		}
	})
	$(reminder).append(checkbox).append("<span> </span>").append(number).append("<span> hr(s)</span>");
	var deletetd = document.createElement('td');
	var deletebtn = document.createElement('a');
	$(deletebtn).addClass("btn btn-sm btn-default").text("x").click(function(){
		courseCollection.remove(courseItself);
		$(row).css({"background": "red", "color": "white"}).fadeOut();
	});
	$(deletetd).addClass("text-center").append(deletebtn);
	$(row).append(nametd).append(reminder).append(deletetd);
	return row;
}


