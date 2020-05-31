<template>
	<view>
		<view class="cu-bar bg-purple">
			<view class="content text-bold">
				ThinkVue微信消息
			</view>
		</view>
		<view class="container">
			<view v-if="tokens.length>0">
				<view class="cu-form-group margin-top">
					<view class="title">token</view>
					<picker @change="PickerChange" :value="index" :range="picker">
						<view class="picker">
							{{index>-1?picker[index]:'请选择发送消息的令牌'}}
						</view>
					</picker>
				</view>
				
				<view class="cu-form-group margin-top">
						<view class="title">title</view>
						<input placeholder="显示为微信消息标题" name="input" v-model="title" @input="makeUrl()"></input>
				</view>	
				<view class="cu-form-group flex flex-direction align-start margin-top">
						<view >生成URL</view>
						<textarea :value="url" placeholder="" />
				</view>	
				<view class="flex flex-direction margin-top">
					<button class="margin-top cu-btn round bg-blue shadow shadow-lg" @click="trySend">测试发送</button>
				</view>
				<view v-if="result.length>0">
					<view class="margin-top">
							<view>返回结果：</view>
							<view>{{result}}</view>
					</view>
				</view>
			</view>
			<view v-else>
				<view class="padding-sm radius shadow bg-gradual-pink margin-top shadow shadow-lg">
					<view class="cuIcon-keyboard flex flex-wrap">
						<view class="text-white text-df text-bold margin-left" selectable=true>没有Token数据，请先添加</view>
					</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	
	export default {
		data() {
			return {
				tokens:[],
				index:-1,
				picker:[],
				title:"", 
				url:'',
				result:""
			}
		},
		onLoad() {
			// this.listToken()
		},
		onShow() {
			this.listToken()
		},
		methods: {
			makeUrl(){
				setTimeout(()=>{
				if(this.index>-1 && this.title.length>0)
					this.url=this.$config.BASE_URL+"/msg?token="+this.tokens[this.index].token+"&title="+encodeURI(this.title)
				else
					this.url=""
					},10)
			},
			PickerChange(e){
				this.index = e.detail.value
				if(this.index==-1)this.index=0
				this.makeUrl()
			},
			listToken(){
				let url='/api/token/list'
				let data={wechat_id:this.$store.getters.getWechatId}
				this.$http.request(url,data,'POST').then((data)=>{
					this.tokens=data.data.token
					this.picker=[];
					this.tokens.forEach((value, index, array)=>{
						this.picker.push(value.remark + ':' + value.token)
					});
				},(res)=>{
					if(res.data.code)
						_g.showToast(res.data.error)
					else
						_g.showToast('请求失败，网络连接失败')
				})
			},
			trySend(){
				this.$http.request(this.url,{},'GET').then((data)=>{
					this.result=JSON.stringify(data)
				},(res)=>{
					this.result=JSON.stringify(res.data)
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
	.auto-height{
		height: 100rpx;
	}
</style>
