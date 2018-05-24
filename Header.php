<?php
namespace Frugue\Shipping;
use Magento\Framework\View\Element\AbstractBlock as _P;
use Magento\Store\Api\StoreResolverInterface as IStoreResolver;
// 2018-05-12
/** @final Unable to use the PHP «final» keyword here because of the M2 code generation. */
class Header extends _P {
	/**
	 * 2018-05-12
	 * @override
	 * @see _P::_toHtml()
	 * @used-by _P::toHtml():
	 *		$html = $this->_loadCache();
	 *		if ($html === false) {
	 *			if ($this->hasData('translate_inline')) {
	 *				$this->inlineTranslation->suspend($this->getData('translate_inline'));
	 *			}
	 *			$this->_beforeToHtml();
	 *			$html = $this->_toHtml();
	 *			$this->_saveCache($html);
	 *			if ($this->hasData('translate_inline')) {
	 *				$this->inlineTranslation->resume();
	 *			}
	 *		}
	 *		$html = $this->_afterToHtml($html);
	 * https://github.com/magento/magento2/blob/2.2.0/lib/internal/Magento/Framework/View/Element/AbstractBlock.php#L643-L689
	 * @return string
	 */
	final protected function _toHtml() {return
		'us' !== df_store_code() || !df_eu(df_is_localhost() ? 'HR' : df_visitor()->iso2()) ? null :
			df_tag('div', 'header-info dfe-frugue-header', df_tag(
				'div', 'container', df_cc_s(
					'<i class="icon-truck"></i>Need EU shipping?'
					,sprintf('Please <a href="%s" title="%s"><strong>switch to our EU store</strong></a>.',
						df_url('stores/store/switch', [IStoreResolver::PARAM_NAME => 'uk']), 'our EU store'
					)
					,sprintf('Frugue USA <a href="%s" title="%s">does not ship to EU</a>.',
						df_url() . 'shipping-delivery', 'our delivery terms'
					)
				)
			)) //. df_style_inline_hide('.rd-navbar .header-info')
	;}
}