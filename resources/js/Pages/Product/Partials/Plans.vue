<script setup>



const data = computed(() => usePage().props.data);
const app = computed(() => usePage().props.app);

const products = computed(() => data.value.products);
const plansLikes = computed(() => data.value.plansLikes);

const checkLikes = (planId) => {
	return plansLikes.value?.find((p) =>  p.product_id == planId )?.like; 
}



const showModal = ref(false);
const selectedPlan = ref('');

const handleShowModal = (product) => {
	showModal.value = true;
	selectedPlan.value = product;
};

const handleCloseModal = () => {
	showModal.value = false;
	selectedPlan.value = {};
};


const updatePlanLike = (planId, like) => {
	router.post(route('plan.like.update'), { 'product_id': planId, 'like_type': like})
}

</script>
<template>
	<div class="grid grid-cols-1 md:grid-cols-3 gap-3 pt-3  ">
		<template v-for="product in products" :key="product.id">
		<div
		class="text-gray-900 p-4 mt-4 bg-white rounded-lg border border-[#0ea5e9] shadow dark:bg-secondary-dark  dark:text-white">
			<div class="widget-lists ">
				<div class="flex items-center justify-between">
					
					</div>
					<div class="text-light font-semibold text-center">
						<div  class="text-center h-12">
					
						<div class="fs-2x  text-[22px] text-[#abd0e5]  ">{{ (product.name) }} </div>

				
					
					</div>



					

				</div>
			</div>
			
			<div class="flex items-center justify-between p-2">
<p :class="[checkLikes(product.id) == 1 ? 'text-success' : '']">
	<span class=" cursor-pointer" @click="updatePlanLike(product.id, 1)">
		<Icon name="up" class="h-7" />{{ product.likes_count + product.admin_like_count }}
	</span>
</p>

<p :class="[checkLikes(product.id) == 0 ? 'text-danger' : '']">
	<span class=" cursor-pointer" @click="updatePlanLike(product.id, 0)">
		<Icon name="down" class="h-7" />{{ product.dislikes_count + product.admin_dislike_count }}
	</span>
</p>
</div>

		</div>
		
	</template>
	</div>
	

</template>
