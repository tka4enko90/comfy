/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/main.js":
/*!************************!*\
  !*** ./src/js/main.js ***!
  \************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _partials_header__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./partials/header */ "./src/js/partials/header.js");
/* harmony import */ var _partials_header__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_partials_header__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _partials_app__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./partials/app */ "./src/js/partials/app.js");
/* harmony import */ var _partials_app__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_partials_app__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _partials_slider__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./partials/slider */ "./src/js/partials/slider.js");
/* harmony import */ var _partials_slider__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_partials_slider__WEBPACK_IMPORTED_MODULE_2__);




/***/ }),

/***/ "./src/js/partials/app.js":
/*!********************************!*\
  !*** ./src/js/partials/app.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {})(jQuery);

/***/ }),

/***/ "./src/js/partials/header.js":
/*!***********************************!*\
  !*** ./src/js/partials/header.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  //Header Scripts
  var speed = "500";
  $('li.depth-1 ul.sub-menu').slideUp();
  $('li.depth-1.active ul.sub-menu').slideDown();
  $('li.depth-1.menu-item-has-children').hover(function () {
    if ($(this).hasClass('active')) {
      return;
    }

    $(this).parent('.sub-menu').find('li.active').removeClass('active').find('ul.sub-menu').slideUp();
    $(this).addClass('active');
    $(this).find('ul.sub-menu').slideDown(speed);
  }); // Change Sub menu image on hover

  var subMenu = $('.sub-menu-wrap');
  subMenu.find('.nav-item-with-image').hover(function () {
    var itemImg = $(this).attr('data-img'),
        itemDesc = $(this).attr('data-desc'),
        imgWrap = $(this).parents('div.sub-menu-wrap').children('.image-wrap'),
        img = imgWrap.children('img'),
        imgDesc = imgWrap.children('p');
    imgDesc.html(itemDesc);
    img.attr('srcset', '');
    img.attr('src', itemImg);
  });
})(jQuery);

/***/ }),

/***/ "./src/js/partials/slider.js":
/*!***********************************!*\
  !*** ./src/js/partials/slider.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

console.log('ok');

/***/ }),

/***/ 0:
/*!******************************!*\
  !*** multi ./src/js/main.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! ./src/js/main.js */"./src/js/main.js");


/***/ })

/******/ });
//# sourceMappingURL=main.js.map