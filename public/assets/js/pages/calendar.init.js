/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/pages/calendar.init.js":
/*!*********************************************!*\
  !*** ./resources/js/pages/calendar.init.js ***!
  \*********************************************/
/***/ (() => {

/*
Template Name: Minia - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Calendar init js
*/

document.addEventListener("DOMContentLoaded", function () {
  var addEvent = new bootstrap.Modal(document.getElementById('event-modal'), {
    keyboard: false
  });
  document.getElementById('event-modal');
  var modalTitle = document.getElementById('modal-title');
  var formEvent = document.getElementById('form-event');
  var selectedEvent = null;
  var forms = document.getElementsByClassName('needs-validation');
  /* initialize the calendar */

  var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();
  var Draggable = FullCalendar.Draggable;
  var externalEventContainerEl = document.getElementById('external-events');
  var defaultEvents = [{
    title: 'All Day Event',
    start: new Date(y, m, 1)
  }, {
    title: 'Long Event',
    start: new Date(y, m, d - 5),
    end: new Date(y, m, d - 2),
    className: 'bg-warning'
  }, {
    id: 999,
    title: 'Repeating Event',
    start: new Date(y, m, d - 3, 16, 0),
    allDay: false,
    className: 'bg-info'
  }, {
    id: 999,
    title: 'Repeating Event',
    start: new Date(y, m, d + 4, 16, 0),
    allDay: false,
    className: 'bg-primary'
  }, {
    title: 'Meeting',
    start: new Date(y, m, d, 10, 30),
    allDay: false,
    className: 'bg-success'
  }, {
    title: 'Lunch',
    start: new Date(y, m, d, 12, 0),
    end: new Date(y, m, d, 14, 0),
    allDay: false,
    className: 'bg-danger'
  }, {
    title: 'Birthday Party',
    start: new Date(y, m, d + 1, 19, 0),
    end: new Date(y, m, d + 1, 22, 30),
    allDay: false,
    className: 'bg-success'
  }, {
    title: 'Click for Google',
    start: new Date(y, m, 28),
    end: new Date(y, m, 29),
    url: 'http://google.com/',
    className: 'bg-dark'
  }];

  // init draggable
  new Draggable(externalEventContainerEl, {
    itemSelector: '.external-event',
    eventData: function eventData(eventEl) {
      return {
        id: Math.floor(Math.random() * 11000),
        title: eventEl.innerText,
        allDay: true,
        start: new Date(),
        className: eventEl.getAttribute('data-class')
      };
    }
  });
  var calendarEl = document.getElementById('calendar');
  function addNewEvent(info) {
    document.getElementById('form-event').reset();
    addEvent.show();
    formEvent.classList.remove("was-validated");
    formEvent.reset();
    selectedEvent = null;
    modalTitle.innerText = 'Create Event';
    newEventData = info;
  }
  function getInitialView() {
    if (window.innerWidth >= 768 && window.innerWidth < 1200) {
      return 'timeGridWeek';
    } else if (window.innerWidth <= 768) {
      return 'listMonth';
    } else {
      return 'dayGridMonth';
    }
  }
  var calendar = new FullCalendar.Calendar(calendarEl, {
    timeZone: 'local',
    editable: true,
    droppable: true,
    selectable: true,
    navLinks: true,
    initialView: getInitialView(),
    themeSystem: 'bootstrap',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
    },
    windowResize: function windowResize(view) {
      var newView = getInitialView();
      calendar.changeView(newView);
    },
    eventResize: function eventResize(info) {
      var indexOfSelectedEvent = defaultEvents.findIndex(function (x) {
        return x.id == info.event.id;
      });
      if (defaultEvents[indexOfSelectedEvent]) {
        defaultEvents[indexOfSelectedEvent].title = info.event.title;
        defaultEvents[indexOfSelectedEvent].className = info.event.classNames[0];
      }
    },
    eventClick: function eventClick(info) {
      document.getElementById("edit-event-btn").removeAttribute("hidden");
      document.getElementById('btn-save-event').setAttribute("hidden", true);
      document.getElementById("edit-event-btn").setAttribute("data-id", "edit-event");
      document.getElementById("edit-event-btn").innerHTML = "Edit";
      eventClicked();
      addEvent.show();
      formEvent.reset();
      selectedEvent = info.event;
      // First Modal
      document.getElementById("modal-title").innerHTML = "";

      // Edit Modal
      document.getElementById("event-title").value = selectedEvent.title;
      document.getElementById("event-category").value = selectedEvent.className;
      console.log("selectedEvent", selectedEvent);
      document.getElementById('btn-delete-event').removeAttribute('hidden');
    },
    dateClick: function dateClick(info) {
      document.getElementById("edit-event-btn").setAttribute("hidden", true);
      document.getElementById('btn-save-event').removeAttribute("hidden");
      addNewEvent(info);
    },
    events: defaultEvents,
    eventReceive: function eventReceive(info) {
      var newid = parseInt(info.event.id);
      var newEvent = {
        id: newid,
        title: info.event.title,
        className: info.event.classNames[0]
      };
      defaultEvents.push(newEvent);
    },
    eventDrop: function eventDrop(info) {
      var indexOfSelectedEvent = defaultEvents.findIndex(function (x) {
        return x.id == info.event.id;
      });
      if (defaultEvents[indexOfSelectedEvent]) {
        defaultEvents[indexOfSelectedEvent].title = info.event.title;
        defaultEvents[indexOfSelectedEvent].className = info.event.classNames[0];
      }
    }
  });
  setTimeout(function () {
    calendar.render();
  }, 0);

  /*Add new event*/
  // Form to add new event
  formEvent.addEventListener('submit', function (ev) {
    ev.preventDefault();
    var updatedTitle = document.getElementById("event-title").value;
    var updatedCategory = document.getElementById('event-category').value;
    var all_day = false;
    if (selectedEvent) {
      var eventid = document.getElementById("eventid").value;
      selectedEvent.setProp("id", eventid);
      selectedEvent.setProp("title", updatedTitle);
      selectedEvent.setProp("classNames", [updatedCategory]);
      var indexOfSelectedEvent = defaultEvents.findIndex(function (x) {
        return x.id == selectedEvent.id;
      });
      if (defaultEvents[indexOfSelectedEvent]) {
        defaultEvents[indexOfSelectedEvent].title = updatedTitle;
        defaultEvents[indexOfSelectedEvent].className = updatedCategory;
      }
      calendar.render();
      // default
    } else {
      var newEvent = {
        id: (Math.random() * 10000).toFixed(0),
        title: updatedTitle,
        start: new Date(document.querySelector("#calender").value),
        // Replace "date-picker-input" with the actual ID of your date picker input,
        allDay: true,
        className: updatedCategory
      };
      calendar.addEvent(newEvent);
      defaultEvents.push(newEvent);
    }
    addEvent.hide();
  });
  document.getElementById("btn-delete-event").addEventListener("click", function (e) {
    if (selectedEvent) {
      for (var i = 0; i < defaultEvents.length; i++) {
        if (defaultEvents[i].id == selectedEvent.id) {
          defaultEvents.splice(i, 1);
          i--;
        }
      }
      selectedEvent.remove();
      selectedEvent = null;
      addEvent.hide();
    }
  });
  document.getElementById("btn-new-event").addEventListener("click", function (e) {
    addNewEvent();
    document.getElementById('edit-event-btn').click();
  });
});
function eventClicked() {
  document.getElementById('form-event').classList.add("view-event");
  document.getElementById("event-title").classList.replace("d-block", "d-none");
  document.getElementById("event-category").classList.replace("d-block", "d-none");
  document.getElementById('btn-save-event').setAttribute("hidden", true);
}
function editEvent(data) {
  var data_id = data.getAttribute("data-id");
  if (data_id == 'new-event') {
    document.getElementById('modal-title').innerHTML = "";
    document.getElementById('modal-title').innerHTML = "Add Event";
    document.getElementById("btn-save-event").innerHTML = "Add Event";
    eventTyped();
  } else if (data_id == 'edit-event') {
    data.innerHTML = "Cancel";
    document.getElementById("btn-save-event").innerHTML = "Update Event";
    data.removeAttribute("hidden");
    eventTyped();
  } else {
    data.innerHTML = "Edit";
    eventClicked();
  }
}
function eventTyped() {
  document.getElementById('form-event').classList.remove("view-event");
  document.getElementById("event-title").classList.replace("d-none", "d-block");
  document.getElementById("event-category").classList.replace("d-none", "d-block");
  document.getElementById('btn-save-event').removeAttribute("hidden");
}

/***/ }),

/***/ "./resources/scss/bootstrap.scss":
/*!***************************************!*\
  !*** ./resources/scss/bootstrap.scss ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/scss/icons.scss":
/*!***********************************!*\
  !*** ./resources/scss/icons.scss ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/scss/app.scss":
/*!*********************************!*\
  !*** ./resources/scss/app.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/assets/js/pages/calendar.init": 0,
/******/ 			"assets/css/app": 0,
/******/ 			"assets/css/icons": 0,
/******/ 			"assets/css/bootstrap": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkveltrix"] = self["webpackChunkveltrix"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["assets/css/app","assets/css/icons","assets/css/bootstrap"], () => (__webpack_require__("./resources/js/pages/calendar.init.js")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/app","assets/css/icons","assets/css/bootstrap"], () => (__webpack_require__("./resources/scss/bootstrap.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/app","assets/css/icons","assets/css/bootstrap"], () => (__webpack_require__("./resources/scss/icons.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["assets/css/app","assets/css/icons","assets/css/bootstrap"], () => (__webpack_require__("./resources/scss/app.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;