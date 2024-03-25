<script setup>
import { useForm } from '@inertiajs/vue3';

const { product, show, maxWidth, closeable } = defineProps({
	product: [Array, Object],
	show: { type: Boolean, default: false },
	maxWidth: { type: String, default: '2xl' },
	closeable: { type: Boolean, default: true },
});

const emit = defineEmits(['close']);

const data = computed(() => usePage().props.data);
const app = computed(() => usePage().props.app);
const times = computed(() => data.value.times);

const form = useForm({
	id: product?.id ?? '',
	name: product?.name ?? '',
	status: product?.status ?? '',
	admin_like_count: product?.admin_like_count ?? 0,
	admin_dislike_count: product?.admin_dislike_count ?? 0,

	_method: product?.id ? 'put' : 'post',

	// ...plan,
});

const submit = () => {


	if (form.id) {
		form.post(route('admin.products.update', form.id), {
			preserveState: true,
			onSuccess: () => {

				emit('close');
			},
		});
	} else {
		form.post(route('admin.products.store'), {
			preserveState: true,
			onSuccess: () => {
				emit('close');
			},
		});
	}
};

const updateStatus = () => {
	if (form.id) {
		form.post(route('admin.products.status.update', form.id), {
			preserveState: true,
			preserveScroll: true,
			onSuccess: () => {
				emit('close');
			},
		});
	}
};


</script>
<template>
	<Modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="emit('close')">
		<SectionCard class="rounded-none dark:rounded-none">
			<div class="flex items-center justify-end w-full px-3 pt-3 cursor-pointer" @click="emit('close')">
				<Icon name="close" class="h-7" />
			</div>
			<header class="border-b border-secondary/10 dark:border-secondary mb-5 -mt-5">
				<h1 class="px-14 mb-2 text-dark text-xl font-bold inline-flex items-center">
					<span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-info-light/20 mr-4">
						<Icon name="plan" class="h-7" />
					</span>
					{{ product?.id ? __('Edit product ') : __('New product ') }}
				</h1>
			</header>

			<main class="px-14 pb-7">
				<ValidationErrors class="my-5" />
				<div>
					<div class="md:grid grid-cols-1 md:grid-cols-2 gap-x-5">
						
						<TextInput label="Product name" :placeholder="__('Product Name')" id="name" v-model="form.name"
							:error="form.errors.name" class="w-full" />

							<TextInput label="Admin Likes Count"
							id="admin_like_count" :placeholder="__('Likes')" v-model="form.admin_like_count"
							:error="form.errors.admin_like_count" class="w-full" />

							<TextInput label="Admin Dislikes Count"
							id="admin_dislike_count" :placeholder="__('Likes')" v-model="form.admin_dislike_count"
							:error="form.errors.admin_dislike_count" class="w-full" />

						
						
					</div>
				</div>
			</main>


			<footer class="border-t border-secondary/10 dark:border-secondary pb-5">
				<div class="mt-3 flex items-center justify-between px-14">
					<Button :key="randomKey()" v-if="product.status == 1" as="button" intent="danger" shadow="danger"
						@click="updateStatus">
						{{ __('Disable') }}
					</Button>
					<Button :key="randomKey() + 1" v-else as="button" intent="success" shadow="success"
						@click="updateStatus">{{
							__('Enable')
						}}</Button>




					<Button :processing="form.processing" :disabled="form.processing" intent="primary" as="button"
						class="mt-5" @click="submit">{{ __('Save') }}</Button>

				</div>

				<!-- <ValidationErrors /> -->
			</footer>
		</SectionCard>
	</Modal>
</template>
