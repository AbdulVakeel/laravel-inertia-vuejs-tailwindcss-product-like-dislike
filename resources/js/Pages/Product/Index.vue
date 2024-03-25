<script setup>
import Plans from './Partials/Plans.vue';


const data = computed(() => usePage().props.data);

</script>

<template>
		<AppContainer>

			
		<Plans />
		</AppContainer>
	

</template>

