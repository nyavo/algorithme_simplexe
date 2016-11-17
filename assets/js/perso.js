/**
 * 
 */

var InfoMessage = (function() {
   "use strict";
   var elem,
       hideHandler,
       that = {};

   that.init = function(options) {
       elem = $(options.selector);
   };

   that.show = function(text) {
       clearTimeout(hideHandler);
       elem.find("span").html(text);      
       elem.delay(200).fadeIn().delay(4000).fadeOut();
   };

   return that;
}());

var ErrorMessage = (function() {
	"use strict";
	var elem,hideHandler,that = {};
	that.init = function(options) {
	    elem = $(options.selector);
	};
	that.show = function(text) {
		clearTimeout(hideHandler);
		elem.find("span").html(text);      
	    elem.delay(200).fadeIn().delay(4000).fadeOut();
	};
	return that;
}());