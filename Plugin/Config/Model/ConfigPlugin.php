<?php
/**
 * @author        Theodor Flavian Hanu <th@cloudlab.at>.
 * @copyright    Copyright(c) 2020 CloudLab AG (http://cloudlab.ag)
 * @link        http://www.cloudlab.ag
 */

namespace Printq\Core\Plugin\Config\Model;


use Psr\Log\LoggerInterface;

class ConfigPlugin
{

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $adminSession;
    /**
     * @var \PrintqAdminChangesLogger
     */
    protected $logger;

    /**
     * ConfigPlugin constructor.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Backend\Model\Auth\Session                $adminSession
     * @param \Printq\Core\Logger\AdminChanges                   $logger
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Backend\Model\Auth\Session $adminSession,
        LoggerInterface $logger
    ) {
        $this->scopeConfig  = $scopeConfig;
        $this->adminSession = $adminSession;
        $this->logger       = $logger;
    }


    public function beforeSave( \Magento\Config\Model\Config $subject ) {

        $groups     = $subject->getData( 'groups' );
        $section    = $subject->getData( 'section' );
        $resultArr  = array();
        $changed    = false;
        $adminUser  = $this->adminSession->getUser();
        if($adminUser){
        $adminEmail = $adminUser->getEmail();
        }
        else {
            $adminEmail = 'cli-command';
        }
        foreach ( $groups as $key1 => $group ) {
            if( !isset( $group['fields']) ) {
                continue;
            }
            foreach ( $group['fields'] as $key2 => $value ) {

                $oldValue = $this->scopeConfig->getValue( $section . '/' . $key1 . '/' . $key2, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $subject->getStore() );
                if( null === $oldValue ) {
                    $oldValue = '';
                }
                if( !empty( $value['value'] ) && $oldValue !== $value['value'] ) {
                    $changed_values['path']        = $section . '/' . $key1 . '/' . $key2;
                    $changed_values['newvalue']    = $value['value'];
                    $changed_values['oldvalue']    = $oldValue;
                    $resultArr['values_changed'][] = $changed_values;
                    $changed                       = true;
                }
            }
        }
        if ( $changed ) {
            $resultArr['ip_address']  = $_SERVER['REMOTE_ADDR'] ?? '';
            $resultArr['user_agent']  = $_SERVER['HTTP_USER_AGENT'] ?? '';
            $resultArr['admin_email'] = $adminEmail;
            $resultArr['date']        = date( 'd:m:Y H:i:s' );
            $this->logger->info( base64_encode( serialize( $resultArr ) ) );
        }
    }
}
