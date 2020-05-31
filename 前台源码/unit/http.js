/*
 * @Author: lijian@midofa.com
 * @URL: http://midofa.com
 * @Date: 2019-08-30 16:57:44
 * @LastEditors: lijian@midofa.com
 * @LastEditTime: 2020-05-13 18:53:41
 * @FilePath: \\msgThinkVue\\unit\\http.js
 * @Description:  
 */
var app=undefined
// import 
const apiMethods = {
	/**
	 * @description  发送请求
	 * @param {String} url 请求URL地址
	 * @param {Object} data 请求数据
	 * @param {String} method = [GET|POST|PUT|DELDTE] :请求方法，默认GET。按惯例大写
	 * @param {Object} headers:请求头，默认为{}。自动加载保存在本地存储中的authkey（会覆盖形参）
	 * @param {Int} timeout:超时时间，单位毫秒，默认为5000
	 * @return {Promise}
	 */
	request(url, data={}, method = 'GET',isShow=true, headers = {}, timeout = 5000) {
		if(isShow){_g.showLoading();} //显示loading框
		if(!uni.getStorageSync("authkey")){
			uni.setStorage({key:'authkey',data:_g.getRandomString(32)}) //跨域请求session依据
			uni.setStorage({key:'sessionid',data:_g.getRandomString(32)})
		}
		headers.authkey = uni.getStorageSync("authkey") || _g.getRandomString(32)
		headers.sessionid = uni.getStorageSync("sessionid") || _g.getRandomString(26)
		let re=/^https?\:\/\//
		if(!re.test(url)) url=app.$config.BASE_URL+url  //如果是绝对地址则不加配置文件中的域名
		return new Promise((resolve, reject) => { //返回promise对象
			uni.request({
				url: url,
				data: data,
				header: headers,
				timeout: timeout,
				method: method,
				success: (res) => {
					if (app.$config.ISDEV) console.log("请求成功：", res);
					if(isShow) uni.hideLoading()
					if(res.data.code>0)
						resolve(res.data)
					else if(res.data.code==-1001){ //登录超时
						let rememberKey=uni.getStorageSync('rememberKey')
						if (rememberKey) { //如果之前登录勾选了记住登录状态则重新登录
							let data = {rememberKey}
							this.request('/api/info/relogin',data,'POST').then((data) => {
								app.$store.commit('login', data.data)
								this.request(url, data, method,isShow, headers, timeout).then((data)=>{
									resolve(data)
								},(res)=>{
									reject(res)
								})
							},(res)=>{
								reject(res)
								app.$store.commit('logout')
								this.toLoginPage() //重新登录失败（改了密码等）则跳转至登录页
							})
						} else { //如果没有记住登录状态,转到登录页
							_g.showToast(res.error)
							reject(res)
							setTimeout(()=>{
								this.toLoginPage();
							},2000);
						}
					}else{
						reject(res)
					}
				},
				fail: (res) => {
					if(isShow) uni.hideLoading()
					if (app.$config.ISDEV) console.log("请求失败：", res);
					reject(res)
				},
			})
		})
	},

	/**
	 * 挂载全局app 
	 * @param {object} app_instance 全局APP对象
	 */
	mount(app_instance){
		app=app_instance;
	},

	/**
	 * 跳转到登录页
	 * @param {type} 
	 * @return: 
	 */
	toLoginPage(){
		let url=encodeURIComponent(location.origin+app.$config.BASE_PATH+'/pages/index/login?wechat_id='+app.$store.getters.getWechatId)
		let re=/%3A\d+%2F/
		if(re.test(url)){ //如果包含端口，即在开发环境中，则不跳转微信接口，否则跳转至微信网页授权接口
			uni.navigateTo({url:'/pages/index/login'})
			console.log("不支持定自义端口，不跳转微信接口");
			return
		}
		url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='+
			app.$config.APPID[app.$store.getters.getWechatId]+
			'&redirect_uri='+url+
			'&response_type=code&scope=snsapi_base&state=thinkvue#wechat_redirect';
		console.log(url);
		location.href=url
	}
}
export default apiMethods
