<template><view>
	<view class="cu-bar bg-cyan">
		<view class="content text-bold">
			ThinkVue微信消息
		</view>
	</view>
	<view class="container">
		<block class="flex flex-wrap" v-for="item in data" :key="item.id">
			<view class="padding-sm radius shadow bg-gradual-pink  margin-top shadow shadow-lg">
				<view class=" cuIcon-keyboard flex flex-wrap">
					<view class="text-white text-df text-bold text-center margin-left" selectable=true>  {{item.token}}</view>
				</view>
				<view class="flex justify-between margin-top">
					<view class="token_des text-white">
						<view class="cuIcon-comment flex flex-wrap">
							<view class="token_remark margin-left">{{item.remark}}</view>
						</view>
						<view class="cuIcon-time flex flex-wrap">
							<view class="token_create_time margin-left">{{item.create_time}}</view>
						</view>
					</view>
					<view class="flex">
						<button class="cu-btn round bg-green padding-sm" @click="copyvalue(item.token)">复制</button>
						<button class="cu-btn round bg-red padding-sm margin-left" @click="listToken('',item.id)">删除</button>
					</view>
				</view>
			</view>
		</block>
		<view class="padding-sm radius shadow bg-gradual-pink margin-top shadow shadow-lg" v-if="data.length==0">
			<view class="cuIcon-keyboard flex flex-wrap">
				<view class="text-white text-df text-bold margin-left" selectable=true>没有数据，请点击下方按钮添加</view>
			</view>
		</view>
		<view class="flex flex-direction margin-top">
			<button class="margin-top cu-btn round bg-blue shadow shadow-lg" @click="modalShow=true">添加token</button>
		</view>
		<view class="cu-modal" :class="modalShow?'show':''">
			<view class="cu-dialog">
				<view class="cu-bar bg-white justify-end">
					<view class="content">Token备注</view>
					<view class="action" @tap="hideModal">
						<text class="cuIcon-close text-red"></text>
					</view>
				</view>
				<view class="padding-xl">
					<input type="text" v-model="remark" placeholder="请输入便于记住用途的关键字" />
				</view>
				<view class="cu-bar bg-white justify-end">
					<view class="action">
						<button class="cu-btn line-green text-green" @tap="hideModal">取消</button>
						<button class="cu-btn bg-green margin-left" @tap="commintAdd">确定</button>
		
					</view>
				</view>
			</view>
		</view>
		
	</view>
</view></template>

<script>
	
	export default {
		data() {
			return {
				data:[],
				modalShow:false,
				remark:''
			}
		},
		onLoad(options) {
			this.$store.commit('setWechatId',options.wechat_id) //保存微信公众号号
			if(!this.$store.getters.hasLogin)
			{
				let rememberKey=uni.getStorageSync('rememberKey')
				if (rememberKey) { //如果之前登录过
					let data = {rememberKey}
					this.$http.request('/api/info/relogin',data,'POST').then((data) => {
						this.$store.commit('login', data.data)
					},(res)=>{
						this.$store.commit('logout')
						this.$http.toLoginPage();
					})
				} else { //如果没有登录过,转到登录页
					this.$http.toLoginPage();
				}
			}
			this.listToken();
		},
		methods: {
			hideModal(){
				this.modalShow=false
				this.remark=""
			},
			commintAdd()
			{
				this.modalShow=false
				if(!this.remark){
					_g.showToast("Token备注不能为空")
					return
				}
				this.listToken(this.remark)
				this.remark=""
			},
			copyvalue(value){
				console.log('复制');
				uni.setClipboardData({
				    data: value,
				    success: function () {
				        console.log('success');
						_g.showToast("复制成功，请直接粘贴！")
				    },
					fail:function(){
						_g.showToast("没有权限，无法复制到剪贴板，请手动复制")
					}
				});
			},
			listToken(add_remark,del_id){
				let url='/api/token/list'
				let data={wechat_id:this.$store.getters.getWechatId}
				let toast=""
				if(add_remark){
					url='/api/token/add'
					data={wechat_id:this.$store.getters.getWechatId,remark:add_remark}
					toast="添加token成功"
				}else if(del_id){
					url='/api/token/delete'
					data={wechat_id:this.$store.getters.getWechatId,id:del_id}
					toast="删除token成功"
				}
				this.$http.request(url,data,'POST').then((data)=>{
					this.data=data.data.token
					if(toast) _g.showToast(toast)
				},(res)=>{
					if(res.data.code)
						_g.showToast(res.data.error)
					else
						_g.showToast('请求失败，请咨询客服')
				})
			},			
		}
	}
</script>

<style>
	.container {
		padding: 20px;
		font-size: 14px;
		line-height: 24px;
	}
	.margin-left{
		margin-left: 15rpx;
		
	}
</style>
