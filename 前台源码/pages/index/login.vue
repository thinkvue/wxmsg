<template>
	<view class="container">
		<view class="left-bottom-sign"></view>
		<view class="right-top-sign"></view>
		<!-- 设置白色背景防止软键盘把下部绝对定位元素顶上来盖住输入框等 -->
		<view class="wrapper">
			<view class="left-top-sign">LOGIN</view>
			<view class="welcome">
				欢迎回来！
			</view>
			<view class="input-content">
				<view class="input-item">
					<text class="tit">手机号码</text>
					<input 
						type="number" 
						placeholder="请输入手机号码"
						maxlength="11"
						data-key="mobile" 
						v-model="data.mobile" 
						@input="inputChange"
					/>
				</view>
				<view class="cu-form-group margin-top">
					<input 
						type="number" 
						placeholder="请输入手机验证码"
						placeholder-class="input-empty"
						maxlength="4"
						data-key="password"
						v-model="data.msgcode"
						@input="inputChange"
						@confirm="toLogin" 
					/>
					<button class='cu-btn round bg-blue' @click="getMsgCode">{{msgcodeSec>0?'等待'+msgcodeSec+'s' : '发送验证码'}}</button>
				</view>	
			</view>
			<button class="confirm-btn" @click="toLogin" :disabled="logining">登录</button>
		</view>
	</view>
</template>

<script>
	export default{
		data(){
			return {
				mobile: '',
				password: '',
				logining: true,
				msgcodeSec:0,
				data:{
					mobile:'',
					msgcode:''
				}
			}
		},
		onLoad(options){
			if(options.code){
				let data={
					code:options.code,
					wechat_id:this.$store.getters.getWechatId
				}
				this.loginByOpenid(data)
			}
		},
		methods: {
			inputChange(e){
				setTimeout(() => { this.logining=!this.checkData() }, 10)
			},
			checkData(){
				var patt=/^[1](([3][0-9])|([4][5-9])|([5][0-3,5-9])|([6][5,6])|([7][0-8])|([8][0-9])|([9][1,8,9]))[0-9]{8}$/
				return patt.test(this.data.mobile) && this.data.msgcode>999 
			},
			getMsgCode(){
				if(this.msgcodeSec>0) return;
				let code=_g.getRandomString(32);
				let timestamp=_g.getTimestamp().toString();
				let data={
					timestamp,
					mobile:this.data.mobile,
					code,
					token:_g.md5(_g.sha1(this.data.mobile+_g.md5(timestamp)+code))
				}
				this.$http.request('/admin/base/mobilecode',data,'POST').then((data) => {
						if(data.code>0)
							this.msgcodeSec=60
							this.intervalID=setInterval(()=>{
								if(this.msgcodeSec>0){
									this.msgcodeSec-=1
								}
								else
									clearInterval(this.intervalID)
							},1000)
					},(res)=>{
						if(res.data.code)
							_g.showToast(res.data.error)
						else
							_g.showToast('请求失败')
					})				
			},
			toLogin(){
				this.logining = true;
				this.$http.request('/api/info/login',this.data,'POST').then((data)=>{
					this.logining=false
					this.$store.commit('login',data.data)
					uni.reLaunch({
						url:'/pages/index/index'
					})
				},(res)=>{
					this.logining=false
					if(res.data.code)
						_g.showToast(res.data.error)
					else{
						_g.showToast('登录失败，服务器出错')
					}
				})
			},
			loginByOpenid(data){
				this.logining = true;
				this.$http.request('/api/info/loginbywechat',data,'POST').then((data)=>{
					this.logining=false
					this.$store.commit('login',data.data)
					uni.reLaunch({
						url:'/pages/index/index'
					})
				},(res)=>{
					this.logining=false	
					if(res.data.code)
						_g.showToast(res.data.error)
					else
						_g.showToast('登录失败，请咨询客服')
				})
			}
		},

	}
</script>

<style lang='scss'>
	page{
		background: #fff;
	}
	.container{
		padding-top: 115px;
		position:relative;
		width: 100vw;
		height: 100vh;
		overflow: hidden;
		background: #fff;
	}
	.wrapper{
		position:relative;
		z-index: 90;
		background: #fff;
		padding-bottom: 40upx;
	}
	.back-btn{
		position:absolute;
		left: 40upx;
		z-index: 9999;
		padding-top: var(--status-bar-height);
		top: 40upx;
		font-size: 40upx;
		color: $font-color-dark;
	}
	.left-top-sign{
		font-size: 120upx;
		color: $page-color-base;
		position:relative;
		left: -16upx;
	}
	.right-top-sign{
		position:absolute;
		top: 80upx;
		right: -30upx;
		z-index: 95;
		&:before, &:after{
			display:block;
			content:"";
			width: 400upx;
			height: 80upx;
			background: #b4f3e2;
		}
		&:before{
			transform: rotate(50deg);
			border-radius: 0 50px 0 0;
		}
		&:after{
			position: absolute;
			right: -198upx;
			top: 0;
			transform: rotate(-50deg);
			border-radius: 50px 0 0 0;
			/* background: pink; */
		}
	}
	.left-bottom-sign{
		position:absolute;
		left: -270upx;
		bottom: -320upx;
		border: 100upx solid #d0d1fd;
		border-radius: 50%;
		padding: 180upx;
	}
	.welcome{
		position:relative;
		left: 50upx;
		top: -90upx;
		font-size: 46upx;
		color: #555;
		text-shadow: 1px 0px 1px rgba(0,0,0,.3);
	}
	.input-content{
		padding: 0 60upx;
	}
	.input-item{
		display:flex;
		flex-direction: column;
		align-items:flex-start;
		justify-content: center;
		padding: 0 30upx;
		background:$page-color-light;
		height: 120upx;
		border-radius: 4px;
		margin-bottom: 50upx;
		&:last-child{
			margin-bottom: 0;
		}
		.tit{
			height: 50upx;
			line-height: 56upx;
			font-size: $font-sm+2upx;
			color: $font-color-base;
		}
		input{
			height: 60upx;
			font-size: $font-base + 2upx;
			color: $font-color-dark;
			width: 100%;
		}	
	}

	.confirm-btn{
		width: 630upx;
		height: 76upx;
		line-height: 76upx;
		border-radius: 50px;
		margin-top: 70upx;
		background: $uni-color-primary;
		color: #fff;
		font-size: $font-lg;
		&:after{
			border-radius: 100px;
		}
	}
	.forget-section{
		font-size: $font-sm+2upx;
		color: $font-color-spec;
		text-align: center;
		margin-top: 40upx;
	}
	.register-section{
		position:absolute;
		left: 0;
		bottom: 50upx;
		width: 100%;
		font-size: $font-sm+2upx;
		color: $font-color-base;
		text-align: center;
		text{
			color: $font-color-spec;
			margin-left: 10upx;
		}
	}
	:btn-blue{
		background-color: #8dc63f;
	}
</style>
