<?php
    /**
     *
     * @author        Delescu Andrei Vlad <ad@cloudlab.at>.
     * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
     * @link          https://cloudlab.ag/
     * @date          03/22/2021
     */
    
    namespace Printq\Core\Block\Cart\Item\Renderer\Actions;
    
    use Magento\Checkout\Block\Cart\Item\Renderer\Actions\Generic;
    use Magento\Framework\View\Element\Template;

    class PrintqEdit extends Generic
    {
        public function __construct(
            Template\Context $context,
            array $data = []
        ) {
            parent::__construct( $context, $data );
        }
    
    }
