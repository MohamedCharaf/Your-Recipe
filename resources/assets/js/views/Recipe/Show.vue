<template>
	<div class="recipe__show">
		<div class="recipe__row">
			<div class="recipe__image">	
				<div class="recipe__box">
					<img :src="`/images/${recipe.image}`" v-if="recipe.image">
				</div>
			</div>

			<div class="recipe__details">
				<div class="recipe__details_inner">
					<small>Submitted by: {{recipe.user.name}}</small>
					<h1 class="recipe__title">{{recipe.name}}</h1>
					<p class="recipe__description">{{recipe.description}}</p>
					<div v-if="auth.api_token && auth.user_id === recipe.user.id">
						<router-link :to="`/recipes/${recipe.id}/edit`" class="btn btn__primary">
							Edit
						</router-link>
						<button class="btn btn__danger" @click="remove" :disabled="isRemoving">
							Delete
						</button>
					</div>
				</div>
			</div>
		</div>	

	<div class="recipe__row">
		<div class="recipe__ingredients">
			<div class="recipe__box">
				<h3 class="recipe__sub_title">Ingredients</h3>
				<ul>
					<li v-for="ingredient in recipe.ingredients">
						<span>{{ingredient.name}}</span>
						<span>{{ingredient.qty}}</span>
					</li>
				</ul>
			</div>
		</div>

			<div class="recipe__directions">
				<div class="recipe__directions_inner">
					<h3 class="recipe__sub_title">Directions</h3>
					<ul>
						<li v-for="(direction, i) in recipe.directions">
							<strong> {{i + 1}}</strong>
							{{direction.description}}
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
</template>

<script type="text/javascript">
	import Auth from '../../store/auth'
	import Flash from '../../helpers/flash'
	import { get, remove } from '../../helpers/api'


	export default {
		data() {
			return {
				auth: Auth.state, 
				isRemoving: false,
				recipe: {
					user: {},
					ingredients: [],
					directions: []
				}
			}
		},

		created() {
			get(`/api/recipes/${this.$route.params.id}`)
			.then((response) => {
				this.recipe = response.data.recipe;
			});
		},

		methods: {
			remove() {
				this.isRemoving = true;

				remove(`/api/recipes/${this.$route.params.id}`)
					.then((response) => {
					if(response.data.deleted) {
						Flash.setSuccess('Recipe Deleted Successfully');
						this.$router.push('/recipes');
					}
				});
			}
		}
	}
</script>