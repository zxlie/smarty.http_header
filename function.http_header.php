<?php
/**
 * @param     {Array}  $params      smarty-function的参数列表，具体参数如下：
 *
 * @p-config  {String} location     地址跳转，类似Javascript中的location.href="xxx"；此参数优先级最高
 *
 * @p-config  {String} refresh      N秒后自动重定向到url参数指定的页面
 * @p-config  {String} url          需要被自动跳转的地址
 *
 * @p-config  {String} contentType  contentType的简写，默认是：html；可选值有：html,js,javascript,json,xml,css,text
 * @p-config  {String} charset      指定返回内容的字符集，默认是UTF-8；如：UTF-8,GBK等
 *
 * @param     {Object} $smarty      内置对象，Smarty
 *
 * @version   1.0
 * @author    zhaoxianlie（xianliezhao@foxmail.com）
 */
function smarty_function_http_header($params, &$smarty) {

    // 获取location
    $location = $params['location'];

    // 获取refresh
    $refresh = $params['refresh'];

    // location的header比其他一切都高
    if(!empty($location)) {
        header("Location:$location");
    }
    // refresh的优先级其次
    elseif(!empty($refresh)){
        // 如果没有配置url参数，表示当前页面自动刷新
        $url = empty($params['url']) ? get_current_page_url() : $params['url'];
        header("Refresh:$refresh;$url");
    }else{
        // 获取contentType
        $contentType = (empty($params['contentType'])) ? 'html' : $params['type'];

        // 获取charset
        $charset = (empty($params['charset'])) ? 'UTF-8' : $params['charset'];

        $contentTypeMap = array(
            'html'          => 'text/html',
            'json'          => 'application/json',
            'javascript'    => 'application/x-javascript',
            'js'            => 'application/x-javascript',
            'xml'           => 'text/xml',
            'css'           => 'text/css',
            'text'          => 'text/plain'
        );
        if (array_key_exists($contentType, $contentTypeMap)) {
            $mime = $contentTypeMap[$contentType];
        } else {
            $mime = "text/plain";
        }
        header("Content-Type:$mime; charset=$charset;");
    }
}


/**
 * 获取当前页面的完整url
 * @return string
 */
function get_current_page_url() {
    $pageURL = 'http';

    if ($_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
    $pageURL .= "://";

    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}


