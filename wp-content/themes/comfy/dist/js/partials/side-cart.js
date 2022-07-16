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
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/partials/side-cart.js":
/*!**************************************!*\
  !*** ./src/js/partials/side-cart.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  var sideCart = {
    cartWrap: $('#side-cart-wrap'),
    initSideCartToggle: function initSideCartToggle() {
      var self = this;
      $('.cart-link.secondary-header-nav-el').click(function (e) {
        e.preventDefault();
        self.showCart();
      });
      $('body').on('click', function (e) {
        if ($(e.target).is(self.cartWrap) || $(e.target).is('.close-cart')) {
          self.hideCart();
        }
      });
    },
    showCart: function showCart() {
      $('body').css('width', $('body').width()).css('overflow', 'hidden');
      this.cartWrap.addClass('active');
    },
    hideCart: function hideCart() {
      this.cartWrap.removeClass('active');
      $('body').removeAttr("style");
    },
    updateCart: function updateCart(data) {
      if (data['fragments']) {
        $(document.body).trigger('wc_fragment_refresh'); //$( '.side-cart-content' ).html( data['fragments']['div.widget_shopping_cart_content'] );
      }

      this.showCart();
    },
    ajaxFail: function ajaxFail(data) {
      console.log(data);
      alert('fail');
    },
    init: function init() {
      var self = this;
      this.initSideCartToggle();
      $('.single_add_to_cart_button').on('click', function (e) {
        e.preventDefault();
        var variableWrap = $(this).parent('.woocommerce-variation-add-to-cart'),
            productID = variableWrap.find('input[name="product_id"]').val(),
            variationID = variableWrap.find('input[name="variation_id"]').val(),
            quantity = variableWrap.find('input[name="quantity"]').val();
        var data = {
          action: 'add_variable_product_to_cart',
          product_id: productID,
          variation_id: variationID,
          quantity: quantity
        };
        window.ajaxCall(data).success(self.updateCart.bind(self)).fail(self.ajaxFail); //self.addProductToCart( e );
      });
    }
  };
  sideCart.init();
})(jQuery);

/***/ }),

/***/ 6:
/*!********************************************!*\
  !*** multi ./src/js/partials/side-cart.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! ./src/js/partials/side-cart.js */"./src/js/partials/side-cart.js");


/***/ })

/******/ });
//# sourceMappingURL=side-cart.js.map