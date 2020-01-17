<?php
/*
 * Velan Info Services India Pvt Ltd.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://store.velanapps.com/License.txt
 *
  /***************************************
 *         MAGENTO EDITION USAGE NOTICE *
 * *************************************** */
/* This package designed for Magento COMMUNITY edition
 * Velan Info Services does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Velan Info Services does not provide extension support in case of
 * incorrect edition usage.
  /***************************************
 *         DISCLAIMER   *
 * *************************************** */
/* Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future.
 * ****************************************************
 * @category            velanapps
 * @package             Log Manager
 * @author              Velan Team 
 * @supported versions  Magento 2.0.2 - Magento 2.1.7
 * @copyright           Copyright (c) 2016 - 2017 Velan Info Services India Pvt Ltd. (http://www.velanapps.com)
 * @license             http://store.velanapps.com/License.txt
 */

namespace Velanapps\Logmanager\Framework\Logger\Handler;

class System extends \Magento\Framework\Logger\Handler\System
{
    /**
     * @var string
     */
    protected $fileName = '/var/log/system.log';

    protected $scopeConfig;

	public function write(array $record)
    {
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
		$this->scopeConfig = $objectManager->create("\Magento\Framework\App\Config\ScopeConfigInterface");
		if($this->scopeConfig->getValue('velanapps/system_debug_log/system_log')){
			if (isset($record['context']['is_exception']) && $record['context']['is_exception']) {
				unset($record['context']['is_exception']);
				$this->exceptionHandler->handle($record);
			} else {
				unset($record['context']['is_exception']);
				$record['formatted'] = $this->getFormatter()->format($record);
				parent::write($record);
			}
		}
    }
}
