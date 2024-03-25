<script setup>
import PlanFormModal from './Partials/PlanFormModal.vue';

const app = computed(() => usePage().props.app);
const data = computed(() => usePage().props.data);
const products = computed(() => data.value.products);
const columns = computed(() => data.value.columns);


const showModal = ref(false);
const selectedItem = ref('');
const handleShowModal = (item) => {
	selectedItem.value = item;
	showModal.value = true;
};

const handleCloseModal = () => {
	showModal.value = false;
	selectedItem.value = {};
};
/* End */
</script>

<template>
	<AppContainer>

		<SectionCard class="mt-4 h-full overflow-hidden">
			<div class="mb-3 p-5 flex items-center justify-between flex-wrap gap-3">
				<Button as="button" shadow="primary" class="py-1" @click="handleShowModal({})">
					<Icon name="plus" class="h-6" />
				</Button>
			</div>
			<LoadingProgressBar v-if="processing" />

			<DataTable :items="products" :columns="columns" class="rounded-xl" @onSort="onSort" :key="Date.now().toString() + 1">
				

			

				<template #cell(name)="{ item }">
					{{ item.name }}
				</template>


				<template #cell(status)="{ item }">
					<Badge class="whitespace-nowrap" v-if="item.status" type="info"> {{ __('Active') }} </Badge>
					<Badge class="whitespace-nowrap" v-else type="danger"> {{ __('Inactive') }} </Badge>
				</template>

			

				<template #cell(actions)="{ item }">
					<Button intent="text" siz="xs" as="button" @click="handleShowModal(item)">
						<Icon name="edit" class="h-4" />
					</Button>
				</template>

			
			</DataTable>

			<div v-if="showModal">
				<PlanFormModal :product="selectedItem" :show="showModal" @close="handleCloseModal()" />
			</div>

		</SectionCard>
	</AppContainer>
</template>

<script>
import Layout from '@/Layouts/AdminLayout.vue';
import { defineComponent } from 'vue';

export default defineComponent({
	layout: Layout,
});
</script>
