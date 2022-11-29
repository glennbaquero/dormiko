<template>
	<div>
		<div class="spinner" :style="'display:'+display">
		    <div class="lds-facebook"><div></div><div></div><div></div></div>
		</div>
	</div>
</template>

<script>
	export default{
		props: {
			display: String,
		}
	}
</script>