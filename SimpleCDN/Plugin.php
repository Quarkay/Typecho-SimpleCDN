<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 简易替换插件，可用作镜像类CDN地址转换，方便以后整站迁移。
 *
 * @package SimpleCDN
 * @author Quarkay
 * @version 1.0.0
 * @link https://www.quarkay.com
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
        // 设置替换分割符和替换规则
        $sep_flag = new Typecho_Widget_Helper_Form_Element_Text('sep_flag', NULL, '-_-', _t('规则分割符'), _t('规则分割符默认为 -_- ，可根据需要进行设置。'));
        $to_replace = new Typecho_Widget_Helper_Form_Element_Text('to_replace', NULL, '', _t('替换前地址'));
        $replace_to = new Typecho_Widget_Helper_Form_Element_Text('replace_to', NULL, '', _t('替换后地址'));
        $form->addInput($sep_flag);
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
        // 先得到函数参数避免重复运算
        list($to_replace, $replace_to) = self::prepare_replace_args();

        // 依次对队列中文章的指定内容进行替换
        foreach($archive->stack as $index=>$con){
            // 替换文章标题
            if(array_key_exists('text', $con)){
                $archive->stack[$index]['text'] = preg_replace($to_replace, $replace_to, $con['text']);
            }
            // 替换文章内容
            if(array_key_exists('title', $con)){
                $archive->stack[$index]['title'] = preg_replace($to_replace, $replace_to, $con['title']);
            }
        }

        // 对 Widget_Archive->row 中对应信息进行更新
        $archive->text = preg_replace($to_replace, $replace_to, $archive->text);
        $archive->title = preg_replace($to_replace, $replace_to, $archive->title);
    }

    /**
     * 准备替换规则参数
     *
     */
    private static function prepare_replace_args()
    {
        // 获取规则分割符
        $sep_flag = Typecho_Widget::widget('Widget_Options')->plugin('SimpleCDN')->sep_flag;

        // 分割得到规则并进行预处理
        $to_replace = explode($sep_flag, Typecho_Widget::widget('Widget_Options')->plugin('SimpleCDN')->to_replace);
        $to_replace = array_map(self::sep_callback(), $to_replace);
        $replace_to = explode($sep_flag, Typecho_Widget::widget('Widget_Options')->plugin('SimpleCDN')->replace_to);
        return array($to_replace, $replace_to);
    }

    /**
     * 替换规则预处理
     *
     * @return Callback Function
     */
    private static function sep_callback()
    {
        return function($item){
            // 若本身就是Pattern参数格式，则无需处理
            return preg_match('/^\/.*\/[a-z]*$/i', $item) ? $item : '/'.$item.'/';
        };
    }

}
