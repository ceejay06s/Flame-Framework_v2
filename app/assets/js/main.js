/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/index.js":
/*!*************************!*\
  !*** ./src/js/index.js ***!
  \*************************/
/***/ (() => {

eval("navigator.serviceWorker.register('/assets/js/service-worker.js');\r\nNotification.requestPermission().then(function (permission) {\r\n    if (permission === 'granted') {\r\n        console.log('Notification permission granted.');\r\n        fetch('/api/notifications')\r\n            .then(response => response.json())\r\n            .then(notifications => {\r\n                notifications.forEach(notification => {\r\n                    new Notification(notification.title, {\r\n                        body: notification.body,\r\n                        icon: notification.icon,\r\n                        tag: notification.tag,\r\n                        data: notification.data,\r\n                    });\r\n                });\r\n            });\r\n\r\n\r\n        /*  const n = new Notification(\"My Great Song\");\r\n         n.onclick = () => {\r\n             // Handle notification click\r\n             // window.open('https://www.youtube.com/watch?v=dQw4w9WgXcQ');\r\n         }; */\r\n    }\r\n});\r\n\n\n//# sourceURL=webpack:///./src/js/index.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./src/js/index.js"]();
/******/ 	
/******/ })()
;