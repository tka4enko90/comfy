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
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/pages/single-product-bundle.js":
/*!***********************************************!*\
  !*** ./src/js/pages/single-product-bundle.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  var productBundle = {
    stepsWrap: $('.bundle-steps-wrap'),
    currentStep: 0,
    stepsNum: NaN,
    loadedVariations: [],
    initBundleVariationsGallery: function initBundleVariationsGallery() {
      var self = this;
      $('.bundled_product').on('woocommerce_variation_has_changed', function () {
        var variationId = $(this).find('input.variation_id').attr('value');

        if (variationId) {
          if (self.loadedVariations.includes(variationId)) {
            self.activateLoadedGallery(variationId);
          } else {
            self.loadedVariations.push(variationId);
            self.getVariationGallery(variationId);
          }
        }
      });
    },
    getVariationGallery: function getVariationGallery(variationId) {
      var request = {
        "ajax_url": '/?wc-ajax=wc_additional_variation_images_get_images',
        "variation_id": variationId,
        "security": wc_additional_variation_images_local.ajaxImageSwapNonce
      };
      window.ajaxCall(request).success(this.ajaxSuccess.bind(this)).fail(this.ajaxFail.bind(this));
    },
    appendVariationGallery: function appendVariationGallery(variationId, galleryLayout) {
      var variationGalleryWrap = this.getVariationGalleryWrap(variationId);
      variationGalleryWrap.append(galleryLayout);
      var loadedGallery = $('.woocommerce-product-gallery--variation-' + variationId);

      if (loadedGallery[0]) {
        variationGalleryWrap.find('.woocommerce-product-gallery.active').removeClass('active');
        loadedGallery.addClass('active');
        loadedGallery.css('opacity', 1);
        this.activateLoadedGallery(variationId, variationGalleryWrap);
      }
    },
    getVariationGalleryWrap: function getVariationGalleryWrap(variationId) {
      return $('input.variation_id[value=' + variationId + ']').parents('div.bundled_product').find('.variation-gallery-wrap');
    },
    activateLoadedGallery: function activateLoadedGallery(variationId) {
      var loadedGallery = $('.woocommerce-product-gallery--variation-' + variationId),
          variationGalleryWrap = this.getVariationGalleryWrap(variationId);

      if (loadedGallery[0]) {
        variationGalleryWrap.find('.woocommerce-product-gallery.active').removeClass('active');
        loadedGallery.addClass('active');
        loadedGallery.css('opacity', 1);
      }
    },
    updateLastStepGallery: function updateLastStepGallery() {
      var lastStepGalleryNav = $('#bundle-last-step-gallery .woocommerce-product-gallery-nav').empty(),
          lastStepGalleryItems = $('#bundle-last-step-gallery .woocommerce-product-gallery-items').empty();

      if (lastStepGalleryItems.hasClass('slick-initialized')) {
        lastStepGalleryItems.slick('unslick').empty();
      }

      $('.variation-gallery-wrap .woocommerce-product-gallery.active').each(function () {
        var galleryItem = $(this).find('.woocommerce-product-gallery-items').hasClass('slick-initialized') ? $(this).find('.slick-slide[data-slick-index="0"] .gallery-item').first().clone() : $(this).find('.gallery-item').first().clone(),
            galleryItemNav = $(this).find('.gallery-nav-item').first().clone();
        lastStepGalleryItems.append(galleryItem);
        lastStepGalleryNav.append(galleryItemNav);
      });
      lastStepGalleryItems.not('.slick-initialized').slick({
        infinite: true,
        dots: true,
        arrows: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 1000,
        mobileFirst: true,
        responsive: [{
          breakpoint: 480,
          settings: "unslick"
        }]
      });
    },
    updateLastStepPrice: function updateLastStepPrice() {
      var priceWrap = $('.bundle_price').find('.price'),
          priceSymbol = priceWrap.find('ins .woocommerce-Price-currencySymbol').text(),
          price = parseFloat(priceWrap.find('ins .amount').text().replace(/[^0-9. ]/g, ""));
      $('.bundle-credit-text-val').text(priceSymbol + (price / 4).toFixed(2));
    },
    updateLastStepItems: function updateLastStepItems() {
      $('.variations_form').each(function () {
        var variationsData = $(this).data('product_variations'),
            variationId = parseInt($(this).find('input.variation_id').attr('value')),
            currentVariationImage = {},
            productId = $(this).data('product_id'),
            bundledItem = $('#bundle-item-' + productId);
        $(this).find('.attribute_options').each(function () {
          var attributeName = $(this).find('.variable-items-wrapper').data('attribute_name'),
              attributeValueLabel = $(this).find('.variable-item.selected').data('title');
          bundledItem.find('.' + attributeName).text(attributeValueLabel);
        });
        $(variationsData).each(function () {
          if (variationId === this['variation_id']) {
            currentVariationImage = this.image;
            return;
          }
        });
        bundledItem.find('img').attr('src', currentVariationImage.src).attr('srcset', currentVariationImage.srcset);
      });
    },
    updateLastStep: function updateLastStep() {
      this.updateLastStepItems();
      this.updateLastStepGallery();
      this.updateLastStepPrice();
    },
    ajaxSuccess: function ajaxSuccess(response) {
      if (response['main_images'] && response['variation_id']) {
        this.appendVariationGallery(response['variation_id'], response['main_images']);
        $(window).trigger('wc_additional_variation_images_frontend_lightbox_done');
      }
    },
    ajaxFail: function ajaxFail(response) {
      console.log(response);
    },
    goToStep: function goToStep(stepNum) {
      var oldStep = $('.bundle-step.current-step'),
          newStep = $('.bundle-step[data-step=' + stepNum + ']');
      newStep.addClass('current-step');
      oldStep.removeClass('current-step');
    },
    initStepsBtns: function initStepsBtns() {
      var self = this;
      $('.bundle-step-button').on('click', function (e) {
        e.preventDefault();

        if ($(this).hasClass('prev-step-bundle')) {
          self.currentStep--;
        } else {
          self.currentStep++;
        }

        if (self.currentStep === self.stepsNum) {
          self.updateLastStep();
        }

        self.goToStep(self.currentStep);
      });
      $('.bundle-item-change-link').on('click', function (e) {
        e.preventDefault();
        self.currentStep = $(this).data('step');
        self.goToStep(self.currentStep);
        $('.woocommerce-product-gallery-items.slick-initialized').slick('refresh');
      });
    },
    init: function init() {
      this.stepsNum = this.stepsWrap.data('steps');
      this.currentStep = $('.bundle-step.current-step').data('step');
      this.initBundleVariationsGallery();
      this.initStepsBtns();
    }
  };
  productBundle.init();
})(jQuery);

/***/ }),

/***/ 3:
/*!*****************************************************!*\
  !*** multi ./src/js/pages/single-product-bundle.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! ./src/js/pages/single-product-bundle.js */"./src/js/pages/single-product-bundle.js");


/***/ })

/******/ });
//# sourceMappingURL=single-product-bundle.js.map