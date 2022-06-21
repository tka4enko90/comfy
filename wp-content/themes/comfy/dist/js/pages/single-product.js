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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/pages/single-product.js":
/*!****************************************!*\
  !*** ./src/js/pages/single-product.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

jQuery(function ($) {
  var body = $('body');
  $(document).on('found_variation', 'form.cart', function (event, variation) {
    console.log(variation);

    if (variation.price_html) {
      $('.summary > p.price').html(variation.price_html);
    }

    $('.woocommerce-variation-price').hide();
  });
  $(document).on('hide_variation', 'form.cart', function (event, variation) {
    $('.summary > p.price').html(cmfProduct.price_html);
  });
  body.on('click', '.woocommerce-product-gallery__image a', function (e) {
    e.preventDefault();
    $(this).toggleClass('zoom-active');
  });
  body.on('click', '.gallery-nav-item', function () {
    var scrollTo = $('.gallery-item-' + $(this).data('item'));
    scrollTo.addClass('Test-123');
    $([document.documentElement, document.body]).animate({
      scrollTop: scrollTo.offset().top - 120 //($( '#' + Object.keys( 'gallery-item-' + $( this ).data( 'item' ) )).offset().top - 200)

    }, 600);
  });
  body.on('click', '.btn-qty', function () {
    var $this = $(this);
    var $qty = $this.closest('.quantity').find('.qty');
    var val = parseFloat($qty.val());
    var max = parseFloat($qty.attr('max'));
    var min = parseFloat($qty.attr('min'));
    var step = parseFloat($qty.attr('step'));
    var $button = $this.closest('.card-product').find('.add_to_cart_button');
    $(".actions .button[name='update_cart']").removeAttr('disabled');

    if ($this.is('.plus')) {
      if (max && max <= val) {
        $qty.val(max);
        $button.attr('data-quantity', max);
      } else {
        $qty.val(val + step);
        $button.attr('data-quantity', val + step);
      }
    } else {
      if (min && min >= val) {
        $qty.val(min);
        $button.attr('data-quantity', min);
      } else if (val > 1) {
        $qty.val(val - step);
        $button.attr('data-quantity', val - step);
      }
    }
  });
});

/***/ }),

/***/ 2:
/*!**********************************************!*\
  !*** multi ./src/js/pages/single-product.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! ./src/js/pages/single-product.js */"./src/js/pages/single-product.js");


/***/ })

/******/ });
//# sourceMappingURL=single-product.js.map