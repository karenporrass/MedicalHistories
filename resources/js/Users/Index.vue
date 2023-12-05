
<template >
	<div class=" cross-center">
		<div>
			<h3 class=" pt-4">Edita tu perfil</h3>
		</div>
	</div>
	<div class="row justify-content-center ">

		<div class="card row mb-4 mx-2 mt-4 text-center">
			<h5 class="p-3">Información Personal
			</h5>

			<div class="card-body">
				<form @submit.prevent="updateInfo">
					<div class="row mb-3">
						<label for="name" class="col-md-3 col-form-label text-md-end">Nombre</label>

						<div class="col-md-7">
							<input id='name' class="w-100" v-model="info_user.name">

						</div>
					</div>
					<div class="row mb-3">
						<label for="name" class="col-md-3 col-form-label text-md-end">Apellidos</label>

						<div class="col-md-7">
							<input id='name' class="w-100" v-model="info_user.last_name">

						</div>
					</div>
					<div class="row mb-3">
						<label for="name" class="col-md-3 col-form-label text-md-end">Documento</label>

						<div class="col-md-7">
							<input id='name' class="w-100" v-model="info_user.document_number">

						</div>
					</div>
					<div class="row mb-3">
						<label for="name" class="col-md-3 col-form-label text-md-end">Celular</label>

						<div class="col-md-7">
							<input id='name' class="w-100" v-model="info_user.phone">

						</div>
					</div>
					<div class="row mb-3">
						<label for="name" class="col-md-3 col-form-label text-md-end">Direccion</label>

						<div class="col-md-7">
							<input id='name' class="w-100" v-model="info_user.address">

						</div>
					</div>
					<div class="row mb-3">
						<label for="name" class="col-md-3 col-form-label text-md-end">Direccion</label>

						<div class="col-md-7">
							<input id='name' class="w-100" v-model="info_user.email">

						</div>
					</div>

					<div class="row mb-0">
						<div class="col-md-4"></div>
						<div class="col-md-4">
							<button type="submit">Actualizar</button>
						</div>
						<div class="col-md-4"></div>

					</div>
				</form>
			</div>
		</div>

	</div>
</template>

<script setup>
	import { ref, onMounted } from "vue";

	const props = defineProps({
		info: {
			type: Object,
			default: null,
		},
	});
	const info_user = ref(props.info);

	async function updateInfo() {
		try {
			const response = await axios.put(
				`/user/update/${info_user.value.id}`,
				info_user.value
			);
			if (response.data.saved) {
				Swal.fire({
					title: "Se actualizo La informacion",
					icon: "success",
				});
			}
		} catch (error) {
			Swal.fire({
				title: "No se puede actualizar",
				text: `Revise todos los campos`,
				icon: "error",
			});
		}
	}
</script>
