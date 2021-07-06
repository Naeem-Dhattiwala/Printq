<?php
/**
 * @author        Theodor Flavian Hanu <th@cloudlab.at>.
 * @copyright     Copyright(c) 2020 CloudLab AG (http://cloudlab.ag)
 * @link          http://www.cloudlab.ag
 */

namespace Printq\Core\Setup;


use Magento\Framework\App\DeploymentConfig;
use Magento\Framework\Config\Data\ConfigData;
use Magento\Framework\Config\File\ConfigFilePool;
use Magento\Framework\Setup\ConfigOptionsListInterface;
use Magento\Framework\Setup\Option\TextConfigOption;

class ConfigOptionsList implements ConfigOptionsListInterface
{

    const CONFIG_PATH_PRINTQ_WEBSHOP_ID = 'PRINTQ_WEBSHOP_ID';
    const OPTION_PRINTQ_WEBSHOP_ID = 'printq-webshop-id';

    /**
     * @inheritDoc
     */
    public function getOptions()
    {
        return [
            new TextConfigOption(
                self::OPTION_PRINTQ_WEBSHOP_ID,
                TextConfigOption::FRONTEND_WIZARD_TEXT,
                self::CONFIG_PATH_PRINTQ_WEBSHOP_ID,
                'Storedata identifier used in memcache',
                BP
            ),
        ];
    }

    /**
     * @inheritDoc
     */
    public function createConfig(array $options, DeploymentConfig $deploymentConfig)
    {
        $configData = new ConfigData(ConfigFilePool::APP_ENV);

        $value = null;
        if (isset($options[self::OPTION_PRINTQ_WEBSHOP_ID])) {
            $value = $options[self::OPTION_PRINTQ_WEBSHOP_ID];
        } elseif ($deploymentValue = $deploymentConfig->get(self::CONFIG_PATH_PRINTQ_WEBSHOP_ID)) {
            $value = $deploymentValue;
        } else {
            $value = BP;
        }
        $configData->set(self::CONFIG_PATH_PRINTQ_WEBSHOP_ID, $value);
        return [$configData];
    }

    /**
     * @inheritDoc
     */
    public function validate(array $options, DeploymentConfig $deploymentConfig)
    {
        return [];
    }
}
