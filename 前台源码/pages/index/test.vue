<template>
	<view>
		
	</view>
</template>

<script>
	import vue from 'vue'
	import vuex from 'vuex'
	export default {
		data() {
			return {
				
			}
		},
		onLoad() {
			console.log(this.$store.getters.getWechatId)
			console.log(this.$store.state.wechat_id)
			console.log(this.$store.getters.hasLogin)
			console.log(this.$store.state.hasLogin)
		},
		methods: {
			request(){
				this.$http.request(url,data,'POST').then((data)=>{
					
				},(res)=>{
					
				})
			}
		}
	}
</script>

<style>

</style>
