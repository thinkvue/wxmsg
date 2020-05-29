<?php
// bsf管理模板函数文件

/**
 * 给树状菜单添加level并去掉没有子菜单的菜单项
 * @param  array   $data  [description]
 * @param  integer $root  [description]
 * @param  string  $child [description]
 * @param  string  $level [description]
 */
function memuLevelClear($data, $root=1, $child='child', $level='level')
{
    if (is_array($data)) {
        foreach($data as $key => $val){
        	$data[$key]['selected'] = false;
        	$data[$key]['level'] = $root;
        	if (!empty($val[$child]) && is_array($val[$child])) {
				$data[$key][$child] = memuLevelClear($val[$child],$root+1);
        	}else if ($root<3&&$data[$key]['menu_type']==1) {
        		unset($data[$key]);
        	}
        	if (empty($data[$key][$child])&&($data[$key]['level']==1)&&($data[$key]['menu_type']==1)) {
        		unset($data[$key]);
        	}
        }
        return array_values($data);
    }
    return array();
}

/**
 * [rulesDeal 给树状规则表处理成 module-controller-action ]
 * @AuthorHTL
 * @DateTime  2017-01-16T16:01:46+0800
 * @param     [array]                   $data [树状规则数组]
 * @return    [array]                         [返回数组]
 */
function rulesDeal($data)
{   
    if (is_array($data)) {
        $ret = [];
        foreach ($data as $k1 => $v1) {
            $str1 = $v1['name'];
            if (is_array($v1['child'])) {
                foreach ($v1['child'] as $k2 => $v2) {
                    $str2 = $str1.'-'.$v2['name'];
                    if (is_array($v2['child'])) {
                        foreach ($v2['child'] as $k3 => $v3) {
                            $str3 = $str2.'-'.$v3['name'];
                            $ret[] = $str3;
                        }
                    }else{
                        $ret[] = $str2;
                    }
                }
            }else{
                $ret[] = $str1;
            }
        }
        return $ret;
    }
    return [];
}


// +-----------------------------------------------------------
// | 以下函数为标准返回['code'=>code,'msg'=>msg,'data'=>data]
// +-----------------------------------------------------------

/**
 * 获取授权token
 * @param string $code 通过get_authorize_url获取到的code
 * @param string $anonymous_code 限字节跳动小程序通过login获取到的anonymous_code
 * @return ['code'=>1,'token'=>token,'openid'=>openid,'msg'=>errMsg];
 */
function getTokenOpenid($code,$anonymous_code="")
{
    // $clientType=2; //TODO:调试
    $clientType=getClientType();
    if($clientType==1){ //微信小程序
        $appid = getSystemConfig('APPID_WXXCX');
        $appsecret = getSystemConfig('SECRET_WXXCX');
        $token_url = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$appsecret}&js_code={$code}&grant_type=authorization_code";
        $data = http_send($token_url);
        if ($data['code'] == 200) {
            if($data['data']['errcode']!=0)
                return ['code'=>-4002, 'msg'=>$data['data']['errmsg']];
            return ['code'=>1,'session_key'=>$data['data']['session_key'],'openid'=>$data['data']['openid']];
        }
    }elseif($clientType==2){ //微信公众号
        $appid = getSystemConfig('APPID_WEIXIN');
        $appsecret = getSystemConfig('SECRET_WEIXIN');
        $token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsecret}&code={$code}&grant_type=authorization_code";
        $data = http_send($token_url);
        if ($data['code'] == 200) {
            if(isset($data['data']['errcode']))
                return ['code'=>-4002, 'msg'=>$data['data']['errmsg']];
            return ['code'=>1,'token'=>$data['data']['access_token'],'openid'=>$data['data']['openid']];
        }
    }elseif($clientType==3){ //QQ
        $appid = getSystemConfig('APPID_QQ');
        $appsecret = getSystemConfig('SECRET_QQ');
        $token_url = "https://api.q.qq.com/sns/jscode2session?appid={$appid}&secret={$appsecret}&js_code={$code}&grant_type=authorization_code";
        $data = http_send($token_url);
        if ($data['code'] == 200) {
            if($data['data']['errcode']!=0)
                return ['code'=>-4002, 'msg'=>$data['data']['errmsg']];
            return ['code'=>1,'session_key'=>$data['data']['session_key'],'openid'=>$data['data']['openid']];
        }
    }elseif($clientType==4){ //支付宝 未支持
        $appid = getSystemConfig('APPID_ALIPAY');
        $appsecret = getSystemConfig('SECRET_ALIPAY');
    }elseif($clientType==5){ //百度
        $appid = getSystemConfig('APPID_BAIDU');
        $appsecret = getSystemConfig('SECRET_BAIDU');
        $data=['code'=>$code,'client_id'=>$appsecret,'sk'=>$appsecret];
        $token_url = "https://spapi.baidu.com/oauth/jscode2sessionkey ";
        $data = http_send($token_url,'POST',$data);
        if ($data['code'] == 200) {
            if(isset($data['data']['error']))
                return ['code'=>-4002, 'msg'=>$data['data']['error_description']];
            return ['code'=>1,'session_key'=>$data['data']['session_key'],'openid'=>$data['data']['openid']];
        }
    }elseif($clientType==6){ //头条
        $appid = getSystemConfig('APPID_BYTE');
        $appsecret = getSystemConfig('SECRET_BYTE');
        $data=['code'=>$code,'appid'=>$appsecret,'secret'=>$appsecret,'anonymous_code'=>$anonymous_code];
        $token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsecret}&code={$code}&grant_type=authorization_code";
        $data = http_send($token_url);
        if ($data['code'] == 200) {
            if($data['data']['errcode']!=0)
                return ['code'=>-4002, 'msg'=>$data['data']['errmsg']];
            return ['code'=>1,
                    'session_key'=>$data['data']['session_key'],
                    'openid'=>$data['data']['openid'],
                    'anonymous_openid'=>$data['data']['anonymous_openid']
                ];
        }
    }
    return ['code'=>-1, 'msg'=>'非法请求，不支持的客户端请求'];
}






