window.$ = window.jQuery = require('jquery')
require('bootstrap-sass');
require('bootstrap-datepicker');
var dt = require( 'datatables.net' )();
require('datatables-bootstrap3-plugin');

$( document ).ready(function() {
    console.log($.fn.tooltip.Constructor.VERSION);
});
