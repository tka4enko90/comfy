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
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/partials/ajax-account-forms.js":
/*!***********************************************!*\
  !*** ./src/js/partials/ajax-account-forms.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

jQuery(document).ready(function ($) {
  var forms = $('form#login-form, form#registration-form, form#lost-password'),
      ajaxFail = function ajaxFail(response) {
    if (response['responseJSON']['data']['errors']) {
      showErrors(response['responseJSON']['data']['errors']);
      $([document.documentElement, document.body]).animate({
        scrollTop: $('#' + Object.keys(response['responseJSON']['data']['errors'])[0]).offset().top - 200
      }, 600);
    }
  },
      ajaxSuccess = function ajaxSuccess(response) {
    if (response.success === true) {
      if (response.data && response.data['redirect_to']) {
        location.replace(response.data['redirect_to']);
      } else {
        location.reload();
      }
    }
  },
      clearErrors = function clearErrors() {
    $('.error-message').remove();
    $('.form-field.error').removeClass('error');
  },
      showErrors = function showErrors(errors) {
    clearErrors();

    for (var key in errors) {
      var elWrap = $("#" + key).parents('.form-field');
      elWrap.addClass('error');
      elWrap.append('<span class="error-message">' + errors[key] + '</span>');
    }
  };

  if (forms) {
    forms.submit(function (e) {
      e.preventDefault();
      var formFields = $(this).serializeArray(),
          formData = {};

      for (var i = 0; i < formFields.length; i++) {
        formData[formFields[i]['name']] = formFields[i]['value'];
      }

      formData['security'] = cpm_object.account_nonce_key;
      window.ajaxCall(formData).success(ajaxSuccess).fail(ajaxFail);
      return false;
    });

    if ($('form#lost-password #user_login')[0]) {
      $('#user_login').on('keyup', function () {
        $('button[type="submit"]').attr('disabled', false);
      });
    }
  }
});

/***/ }),

/***/ 4:
/*!*****************************************************!*\
  !*** multi ./src/js/partials/ajax-account-forms.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! ./src/js/partials/ajax-account-forms.js */"./src/js/partials/ajax-account-forms.js");


/***/ })

/******/ });
//# sourceMappingURL=ajax-account-forms.js.map