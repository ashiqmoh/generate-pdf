var debug;
var table1;
var uniSuggestionTotalId;

window.onload = function () {
	table1 = document.getElementById('resultTable');
	debug = document.getElementById('debug');
	document.getElementById('previewPDF').addEventListener("click", prevPDF, false);
	// document.getElementById('file_text').addEventListener("click", getFile, false);
	// document.getElementById('file_button').addEventListener("click", getFile, false);
	document.getElementById("loadSample").addEventListener("click", loadSampleData, false);
	document.getElementById("addrow").addEventListener("click", addRow, false)
	uniInput = document.getElementById('uni');
	uniInput.addEventListener("keyup", uniSuggest, false);
	uniInput.addEventListener("keydown", move, false);
	document.getElementById("sender").focus();
}
function prevPDF() {
	document.getElementById("submit").click();
}
function getFile() {
	document.getElementById("file").click();
}
function setFileName() {
	var space = " ";
	var file = document.getElementById('file').value;
	var fileName = file.split("\\");
	document.getElementById("file_text").value = space.concat(fileName[fileName.length-1]);
}
function getRowLength() {
	return table.rows.length;
}
function addRow() {
	var table = document.getElementById('resultTable');
	var rowCount = table.rows.length;
	var row = table.insertRow(rowCount);
	//debug.innerHTML = debug.innerHTML + "addRow(" + rowCount + ")\n";
	
	var cell0 = row.insertCell(0);
	cell0.innerHTML = rowCount;
	cell0.className = "count center";
	cell0.id = "count";
	
	var cell1 = row.insertCell(1);
	var element1 = document.createElement("input");
	element1.type = "text";
	element1.name= "subjectEnglish[]";
	element1.className = "subjectEnglish";
	element1.id = "subjectEnglish";
	cell1.appendChild(element1);
	
    var cell2 = row.insertCell(2);
	var element2 = document.createElement("input");
	element2.type = "text";
	element2.name= "subjectGerman[]";
	element2.className = "subjectGerman";
	element2.id = "subjectGerman";
	cell2.appendChild(element2);

	var cell3 = row.insertCell(3);
	var element3 = document.createElement("select");
	element3.name= "result[]";
	element3.className = "result";
	element3.id = rowCount;
	element3.onchange = function() {setNote(element3.value, element3.id);};
	var optionResult1 = document.createElement('option');
	optionResult1.innerHTML = "Note";
	optionResult1.value = "Note";
	optionResult1.name = "result_note";
	var optionResult2 = document.createElement('option');
	optionResult2.innerHTML = "Schein";
	optionResult2.value = "Schein";
	optionResult2.name = "schein";
	element3.appendChild(optionResult1);
	element3.appendChild(optionResult2);
	cell3.appendChild(element3);

	var cell4 = row.insertCell(4);
	var element4 = document.createElement("input");
	element4.type = "text";
	element4.name= "note[]";
	element4.className = "note";
	element4.id = "note";
	cell4.appendChild(element4);

	var cell5 = row.insertCell(5);
	var element5 = document.createElement("select");
	element5.name= "status[]";
	element5.className = "status";
	element5.id = "status";
	var optionStatus1 = document.createElement('option');
	optionStatus1.innerHTML = "Pass";
	optionStatus1.value = "Pass";
	optionStatus1.name = "pass";
	var optionStatus2 = document.createElement('option');
	optionStatus2.innerHTML = "Fail";
	optionStatus2.value = "Fail";
	optionStatus2.name = "fail";
	var optionStatus3 = document.createElement('option');
	optionStatus3.innerHTML = "Drop";
	optionStatus3.value = "Drop";
	optionStatus3.name = "drop";
	element5.appendChild(optionStatus1);
	element5.appendChild(optionStatus2);
	element5.appendChild(optionStatus3);
	cell5.appendChild(element5);

	var cell6 = row.insertCell(6);
	var element6 = document.createElement("input");
	element6.type = "text";
	element6.name= "attempt[]";
	element6.className = "attempt";
	element6.id = "attempt";
	cell6.appendChild(element6);

	var cell7 = row.insertCell(7);
	var element7 = document.createElement("input");
	element7.type = "button";
	element7.name = "deleterow";
	element7.className = "deleterow";
	element7.id = rowCount;
	element7.value = "Delete";
	element7.onclick = function() { deleteRow(element7.id);};
	cell7.appendChild(element7);
	
	var cell8 = row.insertCell(8);
	cell8.className = "noborder";
	var element8 = document.createElement("span");
	element8.className = "error";
	cell8.appendChild(element8);
	//debug.innerHTML = debug.innerHTML + "New row added\n";
}
function deleteRow(rowID) {
	//debug.innerHTML = debug.innerHTML + "deleteRow(" + rowID + ")\n";
	var table = document.getElementById('resultTable');
	var rowCount = table.rows.length;
	
	if(rowCount < 3) {
		var tableMessage = document.getElementById('tableError');
		tableMessage.innerHTML = "Cannot delete all the rows";
		setTimeout(function() {tableMessage.innerHTML = ""}, 3000);
	}
	else {
		table.deleteRow(rowID);
		var tableNew = document.getElementById('resultTable');
		var rowCountNew = tableNew.rows.length;
		//debug.innerHTML = debug.innerHTML + "New row count: " + rowCountNew +"\n";
		for (var i = 1; i < rowCountNew; i++) {
			var rowStep = tableNew.rows[i];
			rowStep.cells[0].innerHTML = i;
			rowStep.cells[7].getElementsByTagName('input')[0].id = i;
			rowStep.cells[3].getElementsByTagName('select')[0].id = i;
		}
	}
}
function setNote(resultType, rowID) {
	//debug.innerHTML = debug.innerHTML + "setNote(" + resultType + ", " + rowID + ")\n";
	var table = document.getElementById('resultTable');
	var row = table.rows[rowID];
	var cell = row.cells[4];
	var noteField = cell.getElementsByTagName('input')[0];
	if (resultType == "Schein") {
		noteField.value = '-';
		noteField.readOnly = true;
		noteField.disabled = true;
		noteField.style.backgroundColor="#dddddd";
	}
	else if (resultType == "Note") {
		noteField.value = '';
		noteField.readOnly = false;
		noteField.disabled = false;
		noteField.style.backgroundColor="#ffffff";
	}
}
function uniSuggest(e) {
	var xmlhttp;
	var str = this.value;
	if (!e) var e = window.event;
	var valueCap = "";
	document.getElementById("uni_suggest").innerHTML = "";
	if (str.length == 0) {
		document.getElementById("uni_suggest").innerHTML = "";
		return;
	}
	if (e.keyCode > 64 && e.keyCode < 91) {
		if (str.length > 0 && getCaretPosition(this) == str.length) {			
			strTemp = str.split(" ");
			for (var i = 0; i < strTemp.length; i++) {
				valueCap += strTemp[i].charAt(0).toUpperCase();
				if (strTemp[i].length > 1) {
					valueCap += strTemp[i].slice(1, str.length);
				}
				if (str.match(" ") != null && i != (strTemp.length - 1)) {
					valueCap += " ";
				}
			}
			document.getElementById('uni').value = valueCap;
		}
	}
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	}
	else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			if(xmlhttp.responseText.length != 0) {
				var suggestion_list = new Array();
				suggestion_list = xmlhttp.responseText.split(",");
				uniSuggestionTotalId = suggestion_list.length - 1;
				for (var i = 0; i < suggestion_list.length; i++) {
					var suggest = document.createElement('div');
					suggest.className = "suggest_link";
					suggest.id = i;
					suggest.tabIndex = "-1";
					suggest.addEventListener("click", setSearch, false);
					suggest.addEventListener("keyup", suggestKeyUp, true);
					suggest.addEventListener("keydown", suggestKeyDown, true);
					suggest.innerHTML = suggestion_list[i];
					document.getElementById("uni_suggest").appendChild(suggest);
				}
			}
		}
	}
	xmlhttp.open("GET", "uniList.php?q=" + str, true);
	xmlhttp.send();
}
function getCaretPosition(oField) {
	var iCaretPos = 0;
	if (document.selection) {
		oField.focus();
		var oSel = document.selection.createRange ();
		oSel.moveStart('character', -oField.value.length);
		iCaretPos = oSel.text.length;
	}
	else if (oField.selectionStart || oField.selectionStart == '0') {
		iCaretPos = oField.selectionStart;
	}
	return (iCaretPos);
}
function move(e) {
	if (!e) var e = window.event;
	if (document.getElementById('uni_suggest').innerHTML != "") {
		if (e.keyCode == 40) {
			document.getElementById('uni').blur();
			setTimeout(function() {document.getElementById('0').focus()}, 100);
		}
		else if (e.keyCode == 38) {
			document.getElementById('uni').blur();
			setTimeout(function() {document.getElementById(uniSuggestionTotalId).focus()}, 100);
		}
	}
}
function setSearch() {
	value = this.innerHTML.replace(/<b>/gi, "");
	value = value.replace(/<\/b>/gi, "");
	document.getElementById('uni').value = value;
	document.getElementById('uni_suggest').innerHTML = "";
	document.getElementById('uni').focus();
}
function suggestKeyUp (e) {
	if (!e) var e = window.event;
	if (e.keyCode == 13) {
		value = this.innerHTML.replace(/<b>/gi, "");
		value = value.replace(/<\/b>/gi, "");
		document.getElementById('uni').value = value;
		document.getElementById('uni_suggest').innerHTML = "";
		document.getElementById('uni').focus();
	}
}
function suggestKeyDown (e) {
	if (!e) var e = window.event;
	if (e.keyCode == 40) {
		var nextId = parseInt(this.id, 10) + 1;
		if (this.id == uniSuggestionTotalId) {
			this.blur();
			document.getElementById('uni').focus();
		}
		else {
			this.blur();
			document.getElementById(nextId).focus();
		}
	}
	else if (e.keyCode == 38) {
		var prevId = parseInt(this.id, 10) - 1;
		if (this.id == 0) {
			this.blur();
			document.getElementById('uni').focus();
		}
		else {
			this.blur();
			document.getElementById(prevId).focus();
		}
	}
}
function loadSampleData() {
	document.getElementById("sender").value = "Ashiq Mohamed";
	document.getElementById("nric").value = "123456-78-1234";
	document.getElementById("alg").value = "12";
	document.getElementById("uni").value = "Hochschule Furtwangen University";
	document.getElementById("course").value = "Maschinenbau und Mechatronik";
	document.getElementById("currentSem").value = "6";
	document.getElementById("mobile").value = "+490123456789";
	document.getElementById("email").value = "user@example.com";
	document.getElementById("WS").checked = true;
	document.getElementById("resultFor").value = "13/14";
}