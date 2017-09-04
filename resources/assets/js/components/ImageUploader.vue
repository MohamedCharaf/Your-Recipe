<template>
	<div class="image">
		<image-previewer :preview="value" @close="$emit('input', null)" v-if="value"></image-previewer>

		<div class="image__upload" v-else>
			<input type="file" accept="images/*" @change="upload">
		</div>
	</div>
</template>

<script type="text/javascript">
	import ImagePreviewer from './ImagePreviewer.vue'

	export default {
		components: {
			ImagePreviewer
		},

		props: {
			value: {
				type: [String, File],
				default: null
			}
		},

		methods: {
			upload(e) {
				const files = e.target.files;
				if(files && files.length > 0) {
					this.$emit('input', files[0]);
				}
			}
		}
	}
</script>