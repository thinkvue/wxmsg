<?php


/**
 * 获取授权token
 * @param {string} $code 通过get_authorize_url获取到的code
 * @param {int} $account_id 公众号/小程序的id
 * @param {string} $anonymous_code 限字节跳动小程序通过login获取到的anonymous_code
 * @return ['code'=>1,'token'=>token,'openid'=>openid,'msg'=>errMsg];
 */
function getTokenOpenid($code,$account_id=1,$anonymous_code="")
{
    $model=model('WechatAccount');
    $account=$model->get($account_id);
    if(!$account)
        return ['code'=>-1, 'msg'=>'找不到指定的微信公众号账号:'.$account_id];
    $appid=$account['appid'];
    $appsecret=$account['appsecret'];
    $token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsecret}&code={$code}&grant_type=authorization_code";
    $data = http_send($token_url);
    if ($data['code'] == 200) {
        if(isset($data['data']['errcode']))
            return ['code'=>-4002, 'msg'=>$code.':'.$appid.":".$data['data']['errmsg']];
        return ['code'=>1,'token'=>$data['data']['access_token'],'openid'=>$data['data']['openid']];
    }
    return ['code'=>-1, 'msg'=>'非法请求，不支持的客户端请求'];
}
