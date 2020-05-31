import Vue from 'vue'
import Vuex from 'vuex'
import { mapState } from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
	state: {
		wechat_id:1,
		hasLogin: false,
		rememberKey:undefined,
		authkey:undefined,
		sessionid:undefined,
		userInfo:{},
		authList:[],
		menusList:[]
	},
	mutations: {
		login(state, provider) {
			state.hasLogin = true;
			state.rememberKey = provider.rememberKey;
			state.userInfo = provider.userInfo;
			state.authList = provider.authList;
			state.menusList = provider.menusList;
			if(provider.rememberKey){
				uni.setStorage({key:'rememberKey', data:provider.rememberKey});
				state.rememberKey = provider.rememberKey;
			}
			if(provider.userInfo){
				uni.setStorage({key:'userInfo', data:provider.userInfo});
				state.userInfo = provider.userInfo;
			}
			if(provider.authList){
				uni.setStorage({key:'authList', data:provider.authList});
				state.authList = provider.authList;
			}
			if(provider.menusList){
				uni.setStorage({key:'menusList', data:provider.menusList});
				state.menusList = provider.menusList;
			}
			if(provider.authkey){
				uni.setStorage({key:'authkey', data:provider.authkey});
				state.authkey = provider.authkey;
			}
			if(provider.sessionid){
				uni.setStorage({key:'sessionid', data:provider.sessionid});
				state.sessionid = provider.sessionid;
			}
		},
		logout(state) {
			state.hasLogin = false;
			state.rememberKey = undefined;
			state.authkey = undefined;
			state.sessionid = undefined;
			state.userInfo = {};
			state.authList = [];
			state.menusList = [];
			uni.removeStorage({key:'rememberKey'});
			uni.removeStorage({key:'authkey'});
			uni.removeStorage({key:'sessionid'});
			uni.removeStorage({key:'userInfo'});
			uni.removeStorage({key:'authList'});
			uni.removeStorage({key:'menusList'});
		},
		setWechatId(state,wechat_id){
			state.wechat_id=wechat_id?wechat_id:1
		}
	},
	getters:{
		getWechatId(state){
			return state.wechat_id
		},
		hasLogin(state){
			return state.hasLogin
		}
		
	}
})

export default store
