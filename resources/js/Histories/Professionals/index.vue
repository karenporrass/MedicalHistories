<template>
	<div style="display: flex; ">
		<div class="card w-100 mt-4">
			<div class="card-body">
				<div class="bg-white p-2 rounded">
					<div class="align-items-center justify-content-center flex-column cross-center mb-3 fw-bold text-center">
						<h1 class="fw-bolder mt-5">Historias</h1>
						<a data-bs-toggle="modal" data-bs-target="#HistoriesModal" class="btn btn-outline-primary rounded-pill mt-2">Crear Nueva Historia <i class="fa-solid fa-plus"></i></a>
					</div>

					<div>

						<div class="mt-5">

							<div class="overflow-auto">
								<table id="CategoriesTable" class="table table-hover table-bordered table-stripped w-100">
									<thead>
										<tr>
											<th>#</th>
											<th>Nombre</th>
											<th>Estado</th>
											<th>Antencedentes</th>
										</tr>

										<tr v-for="history in histories" :key="history">
											<td>{{ history.code_history }}</td>
											<td>{{ history.patient.name }}</td>
											<td>{{ history.state_patient }}</td>
											<td>{{ history.health_history }}</td>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="HistoriesModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="HistoriesModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-body p-4">

						<h4 class="fw-bold">Crear Historia</h4>
						<input v-model="document" type="text" class="form-control my-3" id="interactive_link" placeholder="Cedula Paciente">
						<input v-model="history_info.state_patient" type="text" class="form-control my-3" id="interactive_link" placeholder="Estado">
						<input v-model="history_info.health_history" type="text" class="form-control my-3" id="interactive_link" placeholder="Antencedentes">
						<div class="text-center">
							<a @click="saveHistory()" data-bs-target="#HistoriesModal" class="btn btn-outline-primary rounded-pill">Guardar</a>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</template>

<script setup>
	import { ref, onMounted } from "vue";

	const props = defineProps({
		histories: {
			type: Object,
			default: null,
		},
	});
	const histories = ref(props.histories);
	const errors = ref(null);
	let history_info = ref({
		patient_id: "",
		review: 0,
		state_patient: "",
		health_history: "",
	});
	let document = ref();
	let user = ref();

	async function getUser() {
		errors.value = null;
		try {
			const response = await axios.get(`/user/${document.value}`);

			if (
				response &&
				response.data &&
				response.data.users &&
				response.data.users.length === 1
			) {
				user.value = response.data.users[0].id;
				history_info.value.patient_id = user.value;
			} else {
				Swal.fire({
					title: "No se puede crear la historia",
					text: "El usuario no existe",
					icon: "error",
				});
			}
		} catch (error) {
			console.error("Error al obtener datos del servidor:", error);
		}
	}

	async function saveHistory() {
		await getUser();
		if (user.value) {
			errors.value = null;
			try {
				const response = await axios.post(
					"/history/save",
					history_info.value
				);
				document.value = null;
				history_info.value = {};
				if (response.data.saved == true) {
					Swal.fire({ title: "Historia Creada", icon: "success" });
				}
			} catch (error) {
				Swal.fire({
					title: "No se puede crear la historia",
					text: "Revise todos los campos",
					icon: "error",
				});
			} finally {
				user.value = "";
				getHistories();
			}
		}
	}

	async function getHistories() {
		const { data } = await axios.get(`/history/histories-professional-show`);
		histories.value = data[0];
	}
</script>
