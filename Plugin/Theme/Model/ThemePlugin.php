<?php
/**
 * @author        Theodor Flavian Hanu <th@cloudlab.at>.
 * @copyright    Copyright(c) 2020 CloudLab AG (http://cloudlab.ag)
 * @link        http://www.cloudlab.ag
 */

namespace Printq\Core\Plugin\Theme\Model;


class ThemePlugin
{
    /**
     * @var \Magento\Framework\View\Design\Theme\ThemeList
     */
    private $themeList;

    public function __construct(
        \Magento\Framework\View\Design\Theme\ThemeList $themeList
    ) {
        $this->themeList = $themeList;
    }

    /**
     * @param \Magento\Theme\Model\Theme $subject
     * @param $result
     *
     * @return \Magento\Framework\View\Design\ThemeInterface|null
     */
    public function afterGetParentTheme(\Magento\Theme\Model\Theme $subject, $result)
    {
        if ( ! $result && $subject->getThemePath() != 'Printq/base' && 'frontend' == $subject->getArea()) {
            //only enter this part when themes do not inherit
            // (directly or indirectly) Magento/blank theme
            try {
                $printqBaseTheme = $this->themeList->getThemeByFullPath('frontend/Printq/base');

                $subject->setParentTheme($printqBaseTheme);
                $result = $printqBaseTheme;
            } catch (\UnexpectedValueException $e) {
                //just pass by
            }
        }
        return $result;
    }
}
