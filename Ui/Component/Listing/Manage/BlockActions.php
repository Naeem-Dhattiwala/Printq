<?php
    /**
     *
     * @author        Delescu Andrei Vlad <ad@cloudlab.at>.
     * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
     * @link          https://cloudlab.ag/
     * @date          03/22/2021
     */
    namespace Printq\CustomAddress\Ui\Component\Listing\Manage;
    
    use Magento\Framework\UrlInterface;
    use Magento\Framework\View\Element\UiComponent\ContextInterface;
    use Magento\Framework\View\Element\UiComponentFactory;
    use Magento\Ui\Component\Listing\Columns\Column;
    
    /**
     * Class BlockActions
     */
    class BlockActions extends Column {
        
        /**
         * Url path
         */
        const URL_PATH_EDIT = 'customaddress/manage/edit';
        const URL_PATH_DELETE = 'customaddress/manage/delete';
        const URL_PATH_DETAILS = 'customaddress/manage/details';
        
        /**
         * @var UrlInterface
         */
        protected $urlBuilder;
        
        /**
         * Constructor
         *
         * @param ContextInterface   $context
         * @param UiComponentFactory $uiComponentFactory
         * @param UrlInterface       $urlBuilder
         * @param array              $components
         * @param array              $data
         */
        public function __construct(
            ContextInterface $context,
            UiComponentFactory $uiComponentFactory,
            UrlInterface $urlBuilder,
            array $components = [],
            array $data = []
        ) {
            $this->urlBuilder = $urlBuilder;
            parent::__construct( $context, $uiComponentFactory, $components, $data );
        }
        
        /**
         * @param array $items
         *
         * @return array
         */
        /**
         * Prepare Data Source
         *
         * @param array $dataSource
         *
         * @return array
         */
        public function prepareDataSource( array $dataSource ) {
            if( isset( $dataSource['data']['items'] ) ) {
                foreach( $dataSource['data']['items'] as & $item ) {
                    if( isset( $item['id'] ) ) {
                        $item[$this->getData( 'name' )] = [
                            'edit'   => [
                                'href'  => $this->urlBuilder->getUrl(
                                    static::URL_PATH_EDIT,
                                    [
                                        'id' => $item['id']
                                    ]
                                ),
                                'label' => __( 'Edit' )
                            ],
                            'delete' => [
                                'href'    => $this->urlBuilder->getUrl(
                                    static::URL_PATH_DELETE,
                                    [
                                        'id' => $item['id']
                                    ]
                                ),
                                'label'   => __( 'Delete' ),
                                'confirm' => [
                                    'title'   =>__('Delete address'),
                                    'message' => __('Are you sure you want to delete the address?')
                                ]
                            ]
                        ];
                    }
                }
            }
            
            return $dataSource;
        }
    }
