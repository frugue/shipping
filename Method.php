<?php
namespace Frugue\Shipping;
use Magento\Quote\Model\Quote\Address\RateRequest as Req;
use Magento\Quote\Model\Quote\Address\RateResult\Error as ResE;
use Magento\Quote\Model\Quote\Address\RateResult\Method as ResM;
use Magento\Shipping\Model\Carrier\CarrierInterface as IC; // 2018-04-17 It is used by PHPDoc.
use Magento\Shipping\Model\Rate\Result as Res;
// 2018-05-13
final class Method extends \Df\Shipping\Method {
	/**
	 * 2018-05-13
	 * @override
	 * @see \Df\Shipping\Method::collectRates()
	 * @used-by \Magento\Shipping\Model\Shipping::collectCarrierRates():
 	 *	$result = $carrier->collectRates($request);
	 * https://github.com/magento/magento2/blob/2.2.3/app/code/Magento/Shipping/Model/Shipping.php#L243-L321
	 * @param Req $req
	 * @return Res
	 */
	function collectRates(Req $req) {
		$r = df_new_om(Res::class); /** @var Res $r */
		$to = $req['dest_country_id']; /** @var string $to */
		/**
		 * 2018-05-13
		 * @param string $id
		 * @param string $title
		 * @param float $price
		 * @param string $currency
		 */
		$m = function($id, $title, $price, $currency) use($r) {
			$a = df_currency_convert_to_base($price, $currency); /** @var float $a */
			$m = df_new_omd(ResM::class, [
				'carrier' => $this->getCarrierCode()
				,'carrier_title' => 'Frugue'
				,'cost' => $a
				,'method' => "frugue_$id"
				,'method_title' => $title
				,'price' => $a
			]); /** @var ResM $m */
			$r->append($m);
		};
		switch (df_store_code()) {
			case 'de':
				if ('DE' === $to) {
					$m('de_domestic_standard', 'Standard delivered (2-3 business days)', 0, 'EUR');
					$m('de_domestic_priority', 'Priority delivered (1 business day)', 19.99, 'EUR');
				}
				else {
					$m('de_international_standard', 'Standard delivered (7-21 business days)', 4.99, 'EUR');
					$m('de_international_priority', 'Priority delivered (1-5 business days)', 19.99, 'EUR');
				}
				break;
			case 'fr':
				if ('FR' === $to) {
					$m('fr_domestic_standard', 'Standard delivered (2-4 business days)', 0, 'EUR');
					$m('fr_domestic_priority', 'Priority delivered (1 business day)', 19.99, 'EUR');
				}
				else {
					$m('fr_international_standard', 'Standard delivered (7-21 business days)', 4.99, 'EUR');
					$m('fr_international_priority', 'Priority delivered (1-5 business days)', 19.99, 'EUR');
				}
				break;
			case 'uk':
				if ('GB' === $to) {
					$m('uk_domestic_standard', 'Standard delivered (2-3 business days)', 0, 'GBP');
					$m('uk_domestic_priority', 'Priority delivered (1 business day)', 19.99, 'GBP');
				}
				else {
					$m('uk_international_standard', 'Standard delivered (7-21 business days)', 4.99, 'GBP');
					$m('uk_international_priority', 'Priority delivered (1-5 business days)', 19.99, 'GBP');
				}
				break;
			case 'us':
				if ('US' === $to) {
					$m('us_domestic_standard', 'Standard delivered (3-6 business days)', 0, 'USD');
					$m('us_domestic_priority', 'Priority delivered (1-2 business days)', 19.99, 'USD');
				}
				else if (!df_eu($to)) {
					$m('us_international_standard', 'Standard delivered (7-21 business days)', 4.99, 'USD');
					$m('us_international_priority', 'Priority delivered (1-5 business days)', 19.99, 'USD');
				}
				break;
		}
		return $r;
	}

	/**
	 * 2018-05-13
	 * @override
	 * @see IC::getAllowedMethods()
	 * 1) @used-by \Magento\Shipping\Model\Config\Source\Allmethods::toOptionArray():
	 *	foreach ($carriers as $carrierCode => $carrierModel) {
	 *		if (!$carrierModel->isActive() && (bool)$isActiveOnlyFlag === true) {
	 *			continue;
	 *		}
	 *		$carrierMethods = $carrierModel->getAllowedMethods();
	 *		if (!$carrierMethods) {
	 *			continue;
	 *		}
	 *		$carrierTitle = $this->_scopeConfig->getValue(
	 *			'carriers/' . $carrierCode . '/title',
	 *			\Magento\Store\Model\ScopeInterface::SCOPE_STORE
	 *		);
	 *		$methods[$carrierCode] = ['label' => $carrierTitle, 'value' => []];
	 *		foreach ($carrierMethods as $methodCode => $methodTitle) {
	 *			$methods[$carrierCode]['value'][] = [
	 *				'value' => $carrierCode . '_' . $methodCode,
	 *				'label' => '[' . $carrierCode . '] ' . $methodTitle,
	 *			];
	 *		}
	 *	}
	 * https://github.com/magento/magento2/blob/2.2.3/app/code/Magento/Shipping/Model/Config/Source/Allmethods.php#L34-L67
	 * 2) @used-by \Magento\InstantPurchase\Model\ShippingMethodChoose\CarrierFinder::getCarriersForCustomerAddress()
	 *	$request = new DataObject([
	 *		'dest_country_id' => $address->getCountryId()
	 *	]);
	 *	$carriers = [];
	 *	foreach ($this->carriersConfig->getActiveCarriers($this->storeManager->getStore()->getId()) as $carrier) {
	 *		$checked = $carrier->checkAvailableShipCountries($request);
	 *		if (false !== $checked && null === $checked->getErrorMessage() && !empty($checked->getAllowedMethods())) {
	 *			$carriers[] = $checked;
	 *		}
	 *	}
	 * https://github.com/magento/magento2/blob/2.2.3/app/code/Magento/InstantPurchase/Model/ShippingMethodChoose/CarrierFinder.php#L41-L62
	 * @return array(string => string)
	 */
	function getAllowedMethods() {return [0 => 'Default'];}

	/**
	 * 2018-05-13
	 * @used-by \Df\Shipping\Method::codeS()
	 */
	const CODE = 'frugue';
}