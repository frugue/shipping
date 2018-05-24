// 2018-05-13
// «Магазин frugue США будет обслуживать всех клиентов за исключением 28 стран Евросоюза.
// В корзине, в момент checkout'a, в бегунке со списком стран, не должно быть 28 стран ЕС.»
// https://github.com/mage2pro/frugue.com/issues/4
define(['df-lodash', 'jquery'], function(_, $) {'use strict'; return function(sb) {
	var _super = sb.getAddressItems;
	return _.assign(sb, {getAddressItems: function() {
		var r = _super.call();
		return !window.checkoutConfig || 'us' !== window.checkoutConfig.storeCode ? r :
			_.filter(r, function(a) {return -1 === [
				'AT', 'BE', 'BG', 'CY', 'CZ', 'DK', 'EE', 'FI', 'FR', 'DE', 'GR', 'HU', 'HR', 'IE',
				'IT', 'LV', 'LT', 'LU', 'MT', 'NL', 'PL', 'PT', 'RO', 'SK', 'SI', 'ES', 'SE', 'GB'
			].indexOf(a.countryId);})
		;
	}});
};});