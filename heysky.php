<?php

# My Taobao Store: https://shop157230460.taobao.com

class Heysky {

    protected $command; # 短信MT_REQUEST 语音VO_REQUEST
    protected $cpid;    # 短信平台用户名
    protected $cppwd;   # 短信平台用户密码
    protected $da;      # 目标号码，多个用逗号分割 861380000000
    protected $sa;      # （可选）发送者号码，语音信息不支持该参数
    protected $dc;      # 消息编码：15->GBK 8->Unicode 0->ISO8859-1
    protected $sm;      # 消息内容，经编码后的字符
    protected $lang;    # （可选）语音朗读语言，短信消息不支持该参数

    protected $api_address;     # API URL

    public function __construct($cpid, $cppwd) {
        $this->api_address = 'http://api2.santo.cc/submit';
        $this->cpid = $cpid;
        $this->cppwd = $cppwd;
        $this->dc = 15; # GBK
    }

    public function DataEncoding($dc) {
        # 消息编码：15->GBK 8->Unicode 0->ISO8859-1
        if (in_array($dc, array(15, 8, 0))) {
            $this->dc = $dc;
        }
    }

    public function sendMessage($da, $sm) {
        $this->command = 'MT_REQUEST';
        return $this->_send($da, $sm);
    }

    public function sendVoice($da, $sm) {
        $this->command = 'VO_REQUEST';
        return $this->_send($da, $sm);
    }

    protected function _data() {
        return http_build_query(
            array(
                'command' => $this->command,
                'cpid' => $this->cpid,
                'cppwd' => $this->cppwd,
                'da' => $this->da,
                'dc' => $this->dc,
                'sm' => $this->sm
            )
        );
    }

    protected function _send($da, $sm) {
        $this->da = $da;
        $this->sm = $sm;

        $url = $this->api_address . '?' . $this->_data();
        #echo $url;

        # use curl to make http request
        $curl_handler = curl_init();
        curl_setopt($curl_handler, CURLOPT_URL, $url);
        curl_setopt($curl_handler, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl_handler);
        curl_close($curl_handler);

        parse_str($response, $response_array);
        return $response_array;
    }
}

/*
# test
$api = new Heysky('test', 'santo20160201');
$response = $api->sendMessage('8615122131257', 'd1e9d6a4c2eb31323334');
print_r($response);
 */
