// 2017-04-28
// «Replace a default JS component»:
// http://devdocs.magento.com/guides/v2.0/javascript-dev-guide/javascript/custom_js.html#js_replace
// 2018-04-18
// «How to override a HTML file using a custom module?»:
// https://stackoverflow.com/a/37464758
// https://magento.stackexchange.com/a/117236
// 2018-04-22 «What are requirejs-config.js `mixins`?» https://mage2.pro/t/5297
var config = {config: {mixins: {
	'Magento_Customer/js/model/customer-addresses': {'Frugue_Shipping/addresses': true}
	,'Magento_Theme/js/jquery.rd-navbar': {'Frugue_Shipping/rd-navbar': true}
}}};