<?php
class AutoSlug_Action extends Typecho_Widget implements Widget_Interface_Do
{
    /**
     * 插件配置
     *
     * @access private
     * @var Typecho_Config
     */
    private $_config;

    /**
     * 构造方法
     *
     * @access public
     * @var void
     */
    public function __construct($request, $response, $params = NULL)
    {
        parent::__construct($request, $response, $params);
        /* 获取插件配置 */
        $this->_config = parent::widget('Widget_Options')->plugin('AutoSlug');
    }

    /**
     * 转换为英文或拼音
     *
     * @access public
     * @return void
     */
    public function transform()
    {
        $word = $this->request->filter('strip_tags', 'trim', 'xss')->q;

        if (empty($word)) {
            return;
        }

        $result = call_user_func(array($this, $this->_config->mode), $word);
        $result = preg_replace('/[[:punct:]]/', '', $result);
        $result = str_replace(array('  ', ' '), '-', strtolower(trim($result)));
        $message = array('result' => $result);

        $this->response->throwJson($message);
    }

    /**
     * 百度翻译
     *
     * @access public
     * @param string $word 待翻译的字符串
     * @return string
     */
    public function baidu($word)
    {
        $data = array('client_id' => $this->_config->bdKey, 'q' => $word, 'from' => 'zh', 'to' => 'en');
        $data = http_build_query($data);
        $url = 'http://openapi.baidu.com/public/2.0/bmt/translate' . '?' . $data;
        $result = $this->translate($url);

        if (isset($result['error_code'])) {
            return;
        }

        return $result['trans_result'][0]['dst'];
    }

    /**
     * 有道翻译
     *
     * @access public
     * @param string $word 待翻译的字符串
     * @return string
     */
    public function youdao($word)
    {
        $data = array(
            'keyfrom' => $this->_config->ydFrom,
            'key' => $this->_config->ydKey,
            'type' => 'data',
            'doctype' => 'json',
            'version' => '1.1',
            'q' => $word
        );
        $data = http_build_query($data);
        $url = 'http://fanyi.youdao.com/openapi.do' . '?' . $data;
        $result = $this->translate($url);

        if ($result['errorCode'] > 0) {
            return;
        }

        return $result['translation'][0];
    }

    /**
     * 谷歌翻译
     *
     * @access public
     * @param string $word 待翻译的字符串
     * @return string
     */
    public function google($word)
    {
        $data = array('from' => 'chinese', 'to' => 'english', 'text' => $word);
        $data = http_build_query($data);
        $url = 'http://brisk.eu.org/api/translate.php' . '?' . $data;
        $result = $this->translate($url);

        if (empty($result)) {
            return;
        }

        return $result['res'];
    }


    /**
     * 发送翻译API请求
     *
     * @access public
     * @param string $url 请求地址
     * @return array
     */
    public function translate($url)
    {
        $client = Typecho_Http_Client::get();
        $client->setTimeout(50)->send($url);

        if (200 === $client->getResponseStatus()) {
            return Json::decode($client->getResponseBody(), true);
        }
    }

    /**
     * 转换成拼音
     *
     * @access public
     * @param string $word 待转换的字符串
     * @return string
     */
    public function pinyin($word)
    {
        require_once 'Pinyin.php';
        return Pinyin::getPinyin($word);
    }

    /**
     * 绑定动作
     *
     * @access public
     * @return void
     */
    public function action()
    {
        $this->on($this->request->isAjax())->transform();
    }
}
