
var app = {

	init: function() {
		app.getShifts();
		app.getTotalWorkedHours();
		app.getBonusMinutes();
	},

	getShifts: function() {
		var shiftContainer = document.getElementById('shiftContainerData');
		shiftContainer.innerHTML = '';

		axios.get('http://localhost/api/shifts')
		.then(function (response) {
			shiftContainer.innerHTML = app.renderShiftRows(response.data);
			app.renderShiftCells(response.data);

		})
		.catch(function (error) {
			app.renderErrorMessage(error);
		});
	},

	getTotalWorkedHours: function() {
		var container = document.getElementById('totalHoursContainerData');
		container.innerHTML = '';

		axios.get('http://localhost/api/hours')
		.then(function (response) {
			container.innerHTML = app.renderTotalHourCells(response.data);

		})
		.catch(function (error) {
			app.renderErrorMessage(error);
		});
	},

	getBonusMinutes: function() {
		var container = document.getElementById('minutesBonusContainerData');
		container.innerHTML = '';

		axios.get('http://localhost/api/bonusminutes')
		.then(function (response) {
			container.innerHTML = app.renderBonusMinutesCells(response.data);
		})
		.catch(function (error) {
			app.renderErrorMessage(error);
		});
	},

	renderErrorMessage: function(error) {
		var errorContainer = document.getElementById('errorContainerData');
		errorContainer.innerHTML = '<span>' + error + '</span>';
	},

	renderShiftRows: function(data) {
		var rows = '';
		for (var i = 0; i < data.length; i++) {
			rows +=
			'<div class="shifts-container" id="shiftRow' + i + '">' +
				'<div class="staff-item">Staff #' + data[i].staff + '</div>' +
				'<div class="shift-cell-container" id="staffShiftCellsContainer' + i + '">' +
					'StaffShiftCellsContainer' + i +
				'</div>' +
			'</div>'
		}

		return rows;
	},

	renderTotalHourCells: function(data) {
		var cells = '';
		for (var i = 0; i < data.length; i++) {
			cells +=
			'<div class="total-hours-item">' +
				'<span class="">' +
				 	data[i] +
				 '</span>' +
			 '</div>';
		}

		return cells;
	},

	renderBonusMinutesCells: function(data) {
		var cells = '';
		for (var i = 0; i < data.length; i++) {
			cells +=
			'<div class="total-bonus-item">' +
				'<span class="">' +
				 	data[i] +
				 '</span>' +
			 '</div>';
		}

		return cells;
	},

	renderShiftCells: function(data) {
		for (var i = 0; i < data.length; i++) {
			document.getElementById('staffShiftCellsContainer' + i).innerHTML =  app.renderShiftCellsContent('shiftRow' + i, data[i].shifts);
		}
	},

	renderShiftCellsContent: function(rowId, shifts) {
		var cells = '';
		for (var i = 0; i < shifts.length; i++) {
			var cell = '<div class="shift-item"></div>';
			if (shifts[i] === null) {
				cell ='<div class="shift-item empty-shift">&nbsp;</div>';
			} else {
				cell = '<div class="shift-item"><span class="shift-time-text">' + shifts[i].start + '-' + shifts[i].end + '</span></div>';
			}

			cells += cell;
		}

		return cells;
	}
}

app.init();








