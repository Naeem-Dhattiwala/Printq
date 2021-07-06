var config = {
    'map'   : {
        '*' : {
            /**
             * todo: remove this when update recaptcha module
             */
            'MSP_ReCaptcha/js/reCaptcha' : 'Printq_Core/js/reCaptcha'
        }
    },
    'paths': {
        'printq_fancybox': 'fancybox/jquery.fancybox.pack',
        /*'printq_select2': 'printq/select/select2.min',
        'printq_draggableBackground': 'printq/oie/jquery-draggable-background/draggable_background',
        'printq_jquery_pep': 'printq/oie/jquery.pep/jquery.pep',
        'printq_jcarousel': 'jcarousel/jquery.jcarousel.min',
        'printq_ui_rotatable': 'printq/oie/jquery-ui/ui-rotatable/jquery.ui.rotatable',
        'printq_jquery_cropper': 'printq/oie/jquery-cropper/jquery-cropper.min',
        'cropperjs': 'printq/oie/cropperjs/cropper.min',
        'printq_rotatable_patch_oie': 'printq/oie/jquery/resizable-rotatable.patch',
        'printq_patch_draggable': 'printq/oie/jquery/patch_draggable',
        'printq_justifiedGallery': 'printq/oie/justifiedGallery/jquery.justifiedGallery.min',
        'printq_ramda': 'printq/oie/ramda/ramda',
        'jquery_ui': 'printq/oie/jquery-ui/jquery-ui-1.11.4',
        'Magento_Ui/js/form/element/file-uploader': 'Printq_Core/js/form/element/file-uploader'*/
    },
    'shim': {
        'printq_fancybox': {
            exports: 'printq_fancybox',
            'deps': ['jquery','jquery/ui']
        },
       /* 'printq_select2': {
            exports: 'printq_select2',
            'deps': ['jquery', 'jquery/ui']
        },
        'printq_draggableBackground': {
            exports: 'printq_draggableBackground',
            'deps': ['jquery','jquery/ui']
        },
        'printq_jquery_pep': {
            exports: 'printq_jquery_pep',
            'deps': ['jquery', 'jquery/ui']
        },
        'printq_jcarousel': {
            exports: 'printq_jcarousel',
            'deps': ['jquery', 'jquery/ui']
        },
        'printq_ui_rotatable': {
            exports: 'printq_ui_rotatable',
            'deps': ['jquery', 'jquery/ui']
        },
        'printq_jquery_cropper': {
            exports: 'printq_jquery_cropper',
            'deps': ['jquery', 'jquery/ui']
        },
        'cropperjs': {
            exports: 'cropperjs',
            'deps': ['jquery', 'jquery/ui']
        },
        'printq_rotatable_patch_oie': {
            'deps': ['jquery', 'jquery/ui']
        },
        'printq_patch_draggable': {
            exports: 'printq_patch_draggable',
            'deps': ['jquery', 'jquery/ui']
        },
        'printq_ramda': {
            exports: 'printq_ramda',
            'deps': ['jquery', 'jquery/ui']
        },
        'jquery_ui': {
            exports: 'printq_ramda',
            'deps': ['jquery', 'jquery/ui']
        }*/
    }
};
