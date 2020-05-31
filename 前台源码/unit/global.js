import {createHash} from 'crypto'
const commonFn = {
  j2s(obj) {
    return JSON.stringify(obj)
  },
  shallowRefresh(name) {
    router.replace({ path: '/refresh', query: { name: name }})
  },
  closeGlobalLoading() {
    setTimeout(() => {
      store.dispatch('showLoading', false)
    }, 0)
  },
  openGlobalLoading() {
    setTimeout(() => {
      store.dispatch('showLoading', true)
    }, 0)
  },
  cloneJson(obj) {
    return JSON.parse(JSON.stringify(obj))
  },
  toastMsg(type, msg) {
    switch (type) {
      case 'normal':
        bus.$message(msg)
        break
      case 'success':
        bus.$message({
          message: msg,
          type: 'success'
        })
        break
      case 'warning':
        bus.$message({
          message: msg,
          type: 'warning'
        })
        break
      case 'error':
        bus.$message.error(msg)
        break
    }
  },
  clearVuex(cate) {
    store.dispatch(cate, [])
  },
  getHasRule(val) {
    const moduleRule = 'admin'
    let userInfo = Lockr.get('userInfo')
    if (userInfo.id == 1) {
      return true
    } else {
      let authList = moduleRule + Lockr.get('authList')
      return _.includes(authList, val)
    }
  },
  
  /**
   * 生成随机字符串
   * @param {Object} int length 生成字符串的长度
   */
  getRandomString(length,charStr="abcdefghijklmnopqrstuvwxyz0123456789"){
		var text = "";
		for( var i=0; i < length; i++ )
			text += charStr.charAt(Math.floor(Math.random() * charStr.length));
		return text;
   },
   
   getTimestamp(){
	   const dateTime = new Date().getTime();
	   return Math.floor(dateTime / 1000);
   },
   
   showLoading(title){
		uni.showLoading({
			title:title || "发送请求..."
		})
   },
   
   hideLoading(){
	   uni.hideLoading()
   },
   
   showToast(title){
	   uni.showToast({title,icon:'none'})
   },
   
   hideToast(){
	   uni.hideToast()
   },

	/**
	* @param {string} algorithm
	* @param {any} content
	* @return {string}
	*/
	encrypt(algorithm, content){
		let hash = createHash(algorithm)
		hash.update(content)
		return hash.digest('hex')
	},
   
	/**
	* @param {any} content
	* @return {string}
	*/
	sha1(content){
		return this.encrypt('sha1', content)
	},
   
	/**
	* @param {any} content
	* @return {string}
	*/
	md5(content){
		return this.encrypt('md5', content)
	}
	
	
   
}

export default commonFn
