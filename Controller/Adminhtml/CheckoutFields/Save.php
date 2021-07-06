<?php
/**
 *
 * @author        Krunal Padmashali <kp@cloudlab.at>.
 * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
 * @link          https://cloudlab.ag/
 * @date          07/01/2021
 */
namespace Printq\CheckoutFields\Controller\Adminhtml\CheckoutFields;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Serialize\Serializer\Json as SerializerJson;
use Printq\CheckoutFields\Model\CustomFieldFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Filter\FilterManager;
use Magento\Framework\View\LayoutFactory;

/**
 * Custom Field save controller.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * @var FilterManager
     */
    protected $filterManager;

    /**
     * @var CustomFieldFactory
     */
    protected $customFieldFactory;

    /**
     * @var LayoutFactory
     */
    private $layoutFactory;

    /**
     * @var SerializerJson|null
     */
    private $serializerJson;

    /**
     * @param Context $context
     * @param CustomFieldFactory $customFieldFactory
     * @param FilterManager $filterManager
     * @param LayoutFactory $layoutFactory
     * @param FormData|null $formDataSerializer
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Context $context,
        CustomFieldFactory $customFieldFactory,
        FilterManager $filterManager,
        LayoutFactory $layoutFactory,
        SerializerJson $serializerJson = null
    ) {
        parent::__construct($context);
        $this->filterManager = $filterManager;
        $this->customFieldFactory = $customFieldFactory;
        $this->layoutFactory = $layoutFactory;
        $this->serializerJson = $serializerJson
            ?: ObjectManager::getInstance()->get(SerializerJson::class);
    }

    /**
     * @inheritdoc
     *
     * @return Redirect
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @throws \Zend_Validate_Exception
     */
    public function execute()
    {
        try {
            $optionsData = $this->serializerJson
                ->unserialize($this->getRequest()->getParam('serialized_options', '[]'));

            if (!is_array($optionsData)) {
                $message = __("The field couldn't be saved due to an error. Verify your information and try again. "
                    . "If the error persists, please try again later.");
                $this->messageManager->addErrorMessage($message);
                return $this->returnResult('printq_checkoutfields/*/edit', ['_current' => true]);
            }
            $optionData = [];
            $default_values = [];

            foreach ($optionsData as $key => $option) {
                $decodedFieldData = [];
                parse_str($option, $decodedFieldData);
                if (isset($decodedFieldData['default'])) {
                    $default_values[] = $decodedFieldData['default'][0];
                }
                $optionData = array_replace_recursive($optionData, $decodedFieldData);
            }
            $optionData['default'] = $default_values;

        } catch (\InvalidArgumentException $e) {
            $message = __("The field couldn't be saved due to an error. Verify your information and try again. "
                . "If the error persists, please try again later.");
            $this->messageManager->addErrorMessage($message);
            return $this->returnResult('printq_checkoutfields/*/edit', ['_current' => true]);
        }
        $data = $this->getRequest()->getPostValue();
        $data = array_replace_recursive(
            $data,
            $optionData
        );

        if ($data) {

            $fieldId = $this->getRequest()->getParam('field_id');
            if (!empty($data['field_id']) && $data['field_id'] != $fieldId) {
                $fieldId = $data['field_id'];
            }

            $model = $this->customFieldFactory->create();
            if ($fieldId) {
                $model->load($fieldId);
            }
            $fieldCode = $model && $model->getId()
                ? $model->getFieldCode()
                : $this->getRequest()->getParam('field_code');
            if (!$fieldCode) {
                $frontendLabel = $this->getRequest()->getParam('field_label')[0] ?? '';
                $fieldCode = $this->generateCode($frontendLabel);
            }
            $data['field_code'] = $fieldCode;

            if ($fieldId) {
                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('This field no longer exists.'));
                    return $this->returnResult('printq_checkoutfields/*/', []);
                }

                $data['field_code'] = $model->getFieldCode();
                $data['input_type'] = $data['input_type'] ?? $model->getInputType();
            }

            $data['store_ids'] = implode(',', $data['store_ids']);
            if (isset($data['field_label'][0])) {
                $data['frontend_label'] = $data['field_label'][0];
            } else {
                $data['frontend_label'] = '';
            }

            $model->addData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the custom field.'));
                if ($this->getRequest()->getParam('back', false)) {
                    return $this->returnResult(
                        'printq_checkoutfields/*/edit',
                        ['id' => $model->getId(), '_current' => true]
                    );
                }
                return $this->returnResult('printq_checkoutfields/*/', []);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->_session->setAttributeData($data);
                return $this->returnResult(
                    'printq_checkoutfields/*/edit',
                    ['id' => $fieldId, '_current' => true]
                );
            }
        }
        return $this->returnResult('printq_checkoutfields/*/', []);
    }

    /**
     * Provides an initialized Result object.
     *
     * @param string $path
     * @param array $params
     * @param array $response
     * @return Json|Redirect
     */
    private function returnResult($path = '', array $params = [])
    {
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath($path, $params);
    }
}
