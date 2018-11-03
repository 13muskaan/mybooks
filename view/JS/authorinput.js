// JavaScript Document

var authorRadios; //List of two elements, the radio buttons
var existingAuthorSelect; //Select author input
var newAuthorInputs; //New author input
var newAuthorValues;

function AuthorRadios() {

	if (authorRadios[0].checked) {
		existingAuthorSelect.style.display = "block";
		newAuthorInputs.style.display = "none";

		for (var i = 0; i < newAuthorInputs.children.length; i++) {
			if (newAuthorInputs.children[i].type == HTMLLabelElement) {
				continue;
			}

			newAuthorValues[i] = newAuthorInputs.children[i].value;
			newAuthorInputs.children[i].value = "";
		}

		return;
	}

	if (authorRadios[1].checked) {

		newAuthorInputs.style.display = "block";
		existingAuthorSelect.style.display = "none";


		for (var i = 0; i < newAuthorInputs.children.length; i++) {
			if (newAuthorInputs.children[i].type == HTMLLabelElement) {
				continue;
			}

			if (newAuthorValues[i] != undefined) {
				newAuthorInputs.children[i].value = newAuthorValues[i];
			}
		}

		return;
	}

	console.error("Author Radio code was run without either radio being selected");
}

//Variable setting
function AuthorSetup() {
	newAuthorInputs = document.getElementById("newAuthor");
	newAuthorValues = Array(newAuthorInputs.children.length);

	existingAuthorSelect = document.getElementById("existingAuthor");



	authorRadios = document.getElementById("authorRadios").children;

	var temparr = Array(authorRadios.length);

	for (var i = 0; i < authorRadios.length; i++) {
		temparr[i] = authorRadios[i].children[0];
	}

	authorRadios = temparr;


	//DATE PICKER
	var date_input = $('input[name="newAuthorBirthDate"]'); //our date input has the name "date"
	var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
	var options = {
		format: "yyyy",
		endDate: 0,
		startView: 2,
		minViewMode: 2,
		container: container,
		autoclose: true
	};
	date_input.datepicker(options);

	date_input = $('input[name="newAuthorDeathDate"]'); //our date input has the name "date"

	date_input.datepicker(options);

	date_input = $('input[name="yearofpublication"]');

	date_input.datepicker(options);
}

document.onready = function () {
	AuthorSetup();
};