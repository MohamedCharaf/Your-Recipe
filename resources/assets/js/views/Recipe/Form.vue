<template>
	<div>
		<div class="recipe__show">
			<div class="recipe__header">
				<h3>{{action}} Recipe</h3>
				<div>
					<button class="btn btn__primary" :disabled="isProcessing" @click="save">
						Save
					</button>

					<button class="btn" @click="$router.back()" :disabled="isProcessing">
						Cancel
					</button>
				</div>
			</div>
		</div>

		<div class="recipe__row">
			<div class="recipe__image">
				<div class="recipe__box">
				<image-uploader v-model="form.image"></image-uploader>
				<small class="error__control" v-if="error.image">
					{{error.image[0]}}
				</small>
				</div>
			</div>

			<div class="recipe__details">
				<div class="recipe__details_inner">

					<div class="form__group">
						<label>Name</label>
						<input type="text" class="form__control" v-model="form.name">
						<small class="error__control" v-if="error.name">
							{{error.name[0]}}
						</small>
					</div>

					<div class="form__group">
						<label>Description</label>
						<textarea class="form__control" v-model="form.description"/>
						<small class="error__control" v-if="error.description">
							{{error.description[0]}}
						</small>
					</div>

				</div>
			</div>
		</div>

		<div class="recipe__row">
			<div class="recipe__ingredients">
				<div class="recipe__box">
					<h3 class="recipe__sub_title">Ingredients</h3>
					<div v-for="(ingredient, index) in form.ingredients" class="recipe__form">
						<input type="text" class="form__control" v-model="ingredient.name"
						:class="[error[`ingredients.${index}.name`] ? 'error__bg' : '']">

						<input type="text" class="form__control  form_qty" v-model="ingredient.qty"
						:class="[error[`ingredients.${index}.qty`] ? 'error__bg' : '']">

						<button class="btn btn__danger" @click="remove('ingredients', index)">
							&times;
						</button>
					</div>
					<button class="btn" @click="addIngredient">Add Ingredient</button>
				</div>
			</div>

			<div class="recipe__directions">
				<div class="recipe__directions_inner">
					<h3 class="recipe__sub_title">Directions</h3>
					<div v-for="(direction, index) in form.directions" class="recipe__form">
						<textarea class="form__control" v-model="direction.description"
						:class="[error[`directions.${index}.description`] ? 'error__bg' : '']"/>

						<button class="btn btn__danger" @click="remove('directions', index)">
							&times;
						</button>
					</div>
					<button class="btn" @click="addDirection">Add Direction</button>
				</div>
			</div>
		</div>


	</div>
</template>

<script type="text/javascript">
	import Vue from 'vue'
	import Flash from '../../helpers/flash'
	import { post, get, remove, put } from '../../helpers/api'
	import { toMulipartedForm } from '../../helpers/form'
	import ImageUploader from '../../components/ImageUploader.vue'

	export default {
		components: {
			ImageUploader
		},

		data() {
			return {
				form: {
					ingredients:[],
					directions:[]
				},
				error: {},
				isProcessing: false,
				initializeUrl: `/api/recipes/create`,
				storeUrl:'/api/recipes',
				action: 'Create',
			}
		},
		created() {
			if(this.$route.meta.mode === 'edit') {
				this.initializeUrl = `/api/recipes/${this.$route.params.id}/edit`;
				this.storeUrl = `/api/recipes/${this.$route.params.id}?_method=PUT`;
				this.action = 'Update';
			}

			get(this.initializeUrl)
			.then((response) => {
				Vue.set(this.$data, 'form', response.data.form);
			});
		},
		methods: {
			save() {
				this.isProcessing = true;
				const form = toMulipartedForm(this.form, this.$route.meta.mode);

				post(this.storeUrl, form)
					.then((response) => {
						if(response.data.saved) {
							Flash.setSuccess(response.data.message);
							this.$router.push(`/recipes/${response.data.id}`);
						}
					})
					.catch((error) => {
						if(error.response.status === 422) {
							this.error = error.response.data.errors;
						}
					});
					this.isProcessing = false;
			},
			addDirection() {
				this.form.directions.push({description: ''});
			},
			addIngredient() {
				this.form.ingredients.push({
					name: '', 
					qty: ''
				})
			},
			remove(type, index) {
				if(this.form[type].length > 1) {
					this.form[type].splice(index, 1);
				}
			}

		}
	}
</script>