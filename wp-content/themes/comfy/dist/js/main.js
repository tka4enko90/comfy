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
/* harmony import */ var _partials_ajax_call__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./partials/ajax-call */ "./src/js/partials/ajax-call.js");
/* harmony import */ var _partials_ajax_call__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_partials_ajax_call__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _partials_header__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./partials/header */ "./src/js/partials/header.js");
/* harmony import */ var _partials_header__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_partials_header__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _partials_header_search__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./partials/header-search */ "./src/js/partials/header-search.js");
/* harmony import */ var _partials_header_search__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_partials_header_search__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _partials_app__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./partials/app */ "./src/js/partials/app.js");
/* harmony import */ var _partials_app__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_partials_app__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _partials_footer__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./partials/footer */ "./src/js/partials/footer.js");
/* harmony import */ var _partials_footer__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_partials_footer__WEBPACK_IMPORTED_MODULE_4__);






/***/ }),

/***/ "./src/js/partials/ajax-call.js":
/*!**************************************!*\
  !*** ./src/js/partials/ajax-call.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

jQuery(document).ready(function ($) {
  window.ajaxCall = function (form_data) {
    return $.ajax({
      url: form_data['ajax_url'] ? form_data['ajax_url'] : woocommerce_params.ajax_url,
      // Here goes our WordPress AJAX endpoint.
      type: 'post',
      data: form_data
    });
  };
});

/***/ }),

/***/ "./src/js/partials/app.js":
/*!********************************!*\
  !*** ./src/js/partials/app.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  //Reviews section title
  if ($('#jdgm-rev-widg__rev-counter').length && $('.jdgm-rev-widg[data-number-of-reviews]').length) {
    var revsWrap = $('#judgeme_product_reviews .jdgm-rev-widg'),
        revsNum = revsWrap.data('number-of-reviews'),
        revsCounter = revsWrap.find('#jdgm-rev-widg__rev-counter'),
        summaryRatingVal = revsWrap.data('average-rating'),
        summaryRating = revsWrap.find('#jdgm-rev-widg__summary-rating-num');
    revsCounter.text(revsNum + ' ');
    summaryRating.text(summaryRatingVal + ' ');
  }
})(jQuery);

/***/ }),

/***/ "./src/js/partials/footer.js":
/*!***********************************!*\
  !*** ./src/js/partials/footer.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  var footerNavs = $('footer .widget_nav_menu'),
      toggleSpeed = 500,
      mobileBreakPoint = 480,
      navSlideInit = function navSlideInit() {
    if (window.innerWidth < mobileBreakPoint) {
      $.each(footerNavs, function () {
        if (!$(this).hasClass('active')) {
          $(this).children('div').slideUp(toggleSpeed);
        }
      });
    } else {
      $.each(footerNavs, function () {
        $(this).children('div').slideDown(toggleSpeed);
      });
    }
  };

  footerNavs.first().addClass('active');
  navSlideInit();
  $(window).on('resize', navSlideInit);
  $('footer .widget-title').on('click', function () {
    if (window.innerWidth < mobileBreakPoint) {
      var curNav = $(this).parents('.widget_nav_menu');
      curNav.toggleClass('active');

      if (curNav.hasClass('active')) {
        curNav.children('div').slideDown(toggleSpeed);
      } else {
        curNav.children('div').slideUp(toggleSpeed);
      }
    }
  });
})(jQuery);

/***/ }),

/***/ "./src/js/partials/header-search.js":
/*!******************************************!*\
  !*** ./src/js/partials/header-search.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  var AjaxSearchForm = {
    settings: {
      searchForm: $('form#search-form'),
      searchFormInput: $('input#search-form-input'),
      toggleButton: $('header__widgets-link--cart, .shipping-change, .add-related-products-js'),
      minSearchValLength: 3,
      searchResultList: $('#search-results'),
      timeoutToUpdate: 800,
      setIntervalTimeout: null
    },
    init: function init() {
      this.searchInput();
    },
    ajaxFail: function ajaxFail(response) {
      if (response['responseJSON']['data']['errors']) {
        console.log(response['responseJSON']['data']['errors']);
      }
    },
    ajaxSuccess: function ajaxSuccess(response) {
      if (response['data']['layout']) {
        AjaxSearchForm.settings.searchResultList.html(response['data']['layout']).addClass('active');
        AjaxSearchForm.settings.searchResultList.addClass('active');
      }
    },
    searchInput: function searchInput() {
      var self = this;
      self.settings.searchFormInput.on('keyup', function (e) {
        if (self.settings.setIntervalTimeout) {
          clearTimeout(self.settings.setIntervalTimeout);
        }

        if (e.currentTarget.value && e.currentTarget.value.length >= self.settings.minSearchValLength) {
          self.settings.setIntervalTimeout = setTimeout(function () {
            var formData = {
              search: e.currentTarget.value,
              action: 'search_site'
            };
            window.ajaxCall(formData).success(self.ajaxSuccess).fail(self.ajaxFail);
          }, self.settings.timeoutToUpdate);
        } else {
          self.settings.searchResultList.removeClass('active');
        }
      });
    }
  };
  AjaxSearchForm.init();
})(jQuery);

/***/ }),

/***/ "./src/js/partials/header.js":
/*!***********************************!*\
  !*** ./src/js/partials/header.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  var mobileNavBreakpoint = 1039,
      slideAnimationSpeed = 500,
      body = $('body'); // Mobile nav depth-1 slideToggle

  $('li.menu-item-has-children a.depth-0').on('click', function (e) {
    if (window.innerWidth < mobileNavBreakpoint) {
      e.preventDefault();
      var parrentLi = $(this).parents('li.menu-item-has-children'),
          subMenuWrap = parrentLi.children('div.sub-menu-wrap');
      parrentLi.toggleClass('active');

      if (parrentLi.hasClass('active')) {
        subMenuWrap.slideDown(slideAnimationSpeed);
      } else {
        subMenuWrap.slideUp(slideAnimationSpeed);
      }
    }
  }); // Change Sub menu image on hover

  var subMenu = $('.sub-menu-wrap');
  subMenu.find('.nav-item-with-image').on('mouseenter', function () {
    if (window.innerWidth >= mobileNavBreakpoint) {
      var itemImg = $(this).data('img'),
          itemDesc = $(this).data('desc') ? $(this).data('desc') : '',
          imgWrap = $(this).parents('div.sub-menu-wrap').children('.image-wrap'),
          img = imgWrap.children('img'),
          imgDesc = imgWrap.children('p'),
          currentImg = imgWrap.find('img').attr('src'),
          self = $(this);
      setTimeout(function () {
        if (self.is(":hover")) {
          if ((itemImg.length || itemDesc.length) && currentImg !== itemImg) {
            img.attr('srcset', '');
            imgWrap.fadeOut('fast', function () {
              img.attr('src', itemImg);
              imgDesc.html(itemDesc);
            }).fadeIn("fast");
          }
        }
      }, 200);
    }
  }); //Clear sub menu wrap styles after resizing on desktop

  $(window).on('resize', function () {
    if ($(this).width() >= mobileNavBreakpoint) {
      subMenu.removeAttr("style");
    }
  });
  $('div.nav-toggle').on('click', function () {
    $(this).toggleClass('active');
    $('div#primary-header-nav-container').toggleClass('active');

    if ($(this).hasClass('active')) {
      body.css('width', body.width());
      body.css('overflow', 'hidden');
    } else {
      body.removeAttr("style");
    }
  }); //Search form toggle

  body.on('click', function (e) {
    if ($(e.target).is('.search-wrap svg')) {
      $('.header-container').toggleClass('active');
      var $input = $('#search-form-input'),
          $inputVal = $input.val();
      $input.focus().val('').val($inputVal);
    } else if ($(e.target).is('.search-close-icon') || !$(e.target).parents('.header-container').length) {
      $('.header-container').removeClass('active');
    }
  });
  body.on('click', '.search-view-all a, .header-search .header-search-icon', function (e) {
    e.preventDefault();
    $(this).parents('.header-search').find('form').submit();
  });
})(jQuery);

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