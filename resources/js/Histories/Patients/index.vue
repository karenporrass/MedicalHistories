<template>
	<div style="display: flex; ">
		<div class="card w-100 mt-4">
			<div class="card-body">
				<div class="bg-white p-2 rounded">
					<div class="align-items-center justify-content-center flex-column cross-center mb-3 fw-bold text-center">
						<h1 class="fw-bolder mt-5">Historias</h1>
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
											<th>Acciones</th>
										</tr>

										<tr v-for="history in histories" :key="history">
											<td>{{ history.code_history }}</td>
											<td>{{ history.patient.name }}</td>
											<td>{{ history.state_patient }}</td>
											<td>{{ history.health_history }}</td>
											<td>
												<div class='actions'>
													<a v-if="history.review == 1">
														📌</a>

													<a v-else href='#' @click='updateHistory(history.id), review = 1'>
														✅</a>

												</div>
											</td>
										</tr>
									</thead>
								</table>
							</div>
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
	let review = ref();

	async function updateHistory(id) {
		errors.value = null;
		review.value = 1;
		try {
			const response = await axios.put(`/history/update/${id}`, {
				review: 1,
			});
			if (response.data.saved) {
				Swal.fire({
					title: "La historia se marco como asistida",
					icon: "success",
				});
				console.log("edite");
			}
		} catch (error) {
			errors.value = error;
		} finally {
			review.value = null;
			getHistories();
		}
	}

	async function getHistories() {
		const { data } = await axios.get(`/history/histories-patient-show`);
		histories.value = data[0];
	}
</script>
