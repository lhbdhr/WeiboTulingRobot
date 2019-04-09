<?php

//接口要求返回的字符串需要是utf8编码。

header( 'Content-type: text/html; charset=utf-8' );

//加载SDK

require_once 'CallbackSDK.php';

//设置app_key对应的app_secret

define("APP_SECRET", "d94d38bde3197b333f75375f104784f7");

//初始化SDK

$call_back_SDK = new CallbackSDK();

$call_back_SDK->setAppSecret(APP_SECRET);



//签名验证

$signature = $_GET["signature"];

$timestamp = $_GET["timestamp"];

$nonce = $_GET["nonce"];

if (!$call_back_SDK->checkSignature($signature, $timestamp, $nonce)) {

    die("check signature error");

}



//首次验证url时会有'echostr'参数，后续推送消息时不再有'echostr'字段

//若存在'echostr'说明是首次验证,则返回'echostr'的内容。

if (isset($_GET["echostr"])) {

    die($_GET["echostr"]);

}



//处理开放平台推送来的消息,首先获取推送来的数据.

$post_msg_str = $call_back_SDK->getPostMsgStr();



/**

 * 设置接口默认返回值为空字符串。

 * 请注意数据编码类型。接口要求返回的字符串需要是utf8编码

 * 需要说明的是开放平台判断推送成功的标志是接口返回的http状态码,

 * 只要应用的接口返回的状态为200就会认为消息推送成功，如果http状态码不为200则会重试，共重试3次。

 */

$str_return = '';

if (!empty($post_msg_str)) {

    //sender_id为发送回复消息的uid，即蓝v自己

    $sender_id = $post_msg_str['receiver_id'];

    //receiver_id为接收回复消息的uid，即蓝v的粉丝

    $receiver_id = $post_msg_str['sender_id'];


    $keyword = $post_msg_str['text'];
    //回复text类型的消息示例。

    $data_type = "text";

    if($keyword=='订阅事件消息'){

        $data = $call_back_SDK->textData("感谢您的关注,回复1,报考条件查询工具，回复2，消防工程师是什么，回复3，消防工程师有什么用，回复4，消防工程师前景怎么样");

    }elseif ($keyword=='关注事件消息') {
        # code...
    }elseif ($keyword=='取消关注事件消息'||$keyword=='取消订阅事件消息') {
        $data = $call_back_SDK->textData("不要取消嘛，请看这里");
    }else{

        //图灵API
        $apiKey = "dcb6379f29f64379ab4a2cf9bd0b8d97";
        $apiURL = "http://openapi.tuling123.com/openapi/api/v2";

        //设置报文头, 构建请求报文

        $post_dataStr = array(
            "perception" => array(
                'inputText' => array(
                    'text' => $keyword
            )
        ),
            "userInfo" => array(
                'apiKey' => $apiKey,
                'userId' => '190574'
        )
    );


        $post_data = json_encode($post_dataStr);
        $headers = array();
        array_push($headers, "Content-Type: application/json; charset=utf-8");
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$apiURL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $result = curl_exec($ch);
        if($result === FALSE ){
            echo "CURL Error:".curl_error($ch);
        }
        // 4. 释放curl句柄
        curl_close($ch);
        $formatResult = json_decode($result,true);
        $code = $formatResult['intent']['code'];
        $reply = $formatResult['results'][0]['values']['text'];

        $defaultreply = '您发言太快了，稍等一会儿再来吧。';

        switch ($code) {
        case '5000':
           $data = $call_back_SDK->textData("您发言太快了，稍等一会儿再来吧。");
            break;
        case '6000':
           $data = $call_back_SDK->textData("您发言太快了，稍等一会儿再来吧。");
            break;
        case '4000':
           $data = $call_back_SDK->textData("您发言太快了，稍等一会儿再来吧。");
            break;
        case '4001':
           $data = $call_back_SDK->textData("您发言太快了，稍等一会儿再来吧。");
            break;
        case '4002':
           $data = $call_back_SDK->textData("您发言太快了，稍等一会儿再来吧。");
            break;
        case '4003':
           $data = $call_back_SDK->textData("您发言太快了，稍等一会儿再来吧。");
            break;
        case '4005':
           $data = $call_back_SDK->textData("您发言太快了，稍等一会儿再来吧。");
            break;
        case '4007':
           $data = $call_back_SDK->textData("您发言太快了，稍等一会儿再来吧。");
            break;
        case '4100':
           $data = $call_back_SDK->textData("您发言太快了，稍等一会儿再来吧。");
            break;
        case '4200':
           $data = $call_back_SDK->textData("您发言太快了，稍等一会儿再来吧。");
            break;
        case '4300':
           $data = $call_back_SDK->textData("您发言太快了，稍等一会儿再来吧。");
            break;
        case '4300':
           $data = $call_back_SDK->textData("您发言太快了，稍等一会儿再来吧。");
            break;
        case '4400':
           $data = $call_back_SDK->textData("您发言太快了，稍等一会儿再来吧。");
            break;
        case '4300':
           $data = $call_back_SDK->textData("您发言太快了，稍等一会儿再来吧。");
            break;
        case '4500':
           $data = $call_back_SDK->textData("您发言太快了，稍等一会儿再来吧。");
            break;
        case '4600':
           $data = $call_back_SDK->textData("您发言太快了，稍等一会儿再来吧。");
            break;
        case '4602':
           $data = $call_back_SDK->textData("您发言太快了，稍等一会儿再来吧。");
            break;
        case '7002':
           $data = $call_back_SDK->textData("您发言太快了，稍等一会儿再来吧。");
            break;
        case '8008':
           $data = $call_back_SDK->textData("您发言太快了，稍等一会儿再来吧。");
            break;

        default:
            $data = $call_back_SDK->textData($reply);
            break;
        }
    }


    //回复articles类型的消息示例。

    //    $data_type = "articles";

    //    $article_data = array(

    //        array("display_name" => "第一个故事",

    //            "summary" => "今天讲两个故事，分享给你。谁是公司？谁又是中国人？",

    //            "image" => "http://storage.mcp.weibo.cn/0JlIv.jpg",

    //            "url" => "http://e.weibo.com/mediaprofile/article/detail?uid=1722052204&aid=983319"),

    //        array("display_name" => "第二个故事",

    //            "summary" => "今天讲两个故事，分享给你。谁是公司？谁又是中国人？",

    //            "image" => "http://storage.mcp.weibo.cn/0JlIv.jpg",

    //            "url" => "http://e.weibo.com/mediaprofile/article/detail?uid=1722052204&aid=983319")

    //    );

    //    $data = $call_back_SDK->articleData($article_data);



    //回复position类型的消息示例。

    //    $data_type = "position";

    //    $longitude = "123.01";

    //    $latitude = "154.2";

    //    $data = $call_back_SDK->positionData($longitude, $latitude);
    
    


    $str_return = $call_back_SDK->buildReplyMsg($receiver_id, $sender_id, $data, $data_type);

}

echo json_encode($str_return);