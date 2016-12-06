<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 简易替换插件，可用作镜像类CDN地址转换，方便以后整站迁移。
 *
 * @package SimpleCDN
 * @author PigKnife
 * @version 0.1
 * @link https://www.mierhuo.com
 */
class SimpleCDN_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate(){
        Typecho_Plugin::factory("Widget_Archive")->beforeRender = array('SimpleCDN_Plugin', 'replace_content');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     *
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){
    }

    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){
        /** 设置替换规则 */
        $to_replace = new Typecho_Widget_Helper_Form_Element_Text('to_replace', NULL, '', _t('替换前地址'));
        $replace_to = new Typecho_Widget_Helper_Form_Element_Text('replace_to', NULL, '', _t('替换后地址'));
        $form->addInput($to_replace);
        $form->addInput($replace_to);
    }

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}

    /**
     * 插件实现方法
     *
     * @access public
     * @param Widget_Archive $archive
     * @return void
     */
    public static function replace_content(Widget_Archive $archive)
    {
        $to_replace = Typecho_Widget::widget('Widget_Options')->plugin('SimpleCDN')->to_replace;
        $replace_to = Typecho_Widget::widget('Widget_Options')->plugin('SimpleCDN')->replace_to;
        foreach($archive->stack as $index=>$con){
            if(array_key_exists('text', $con)){
                $archive->stack[$index]['text'] = str_replace($to_replace, $replace_to, $con['text']);
            }
        }
        reset($archive->stack);
        $archive->text = str_replace($to_replace, $replace_to, $archive->text);
    }
}
