<template>
	<div v-if="show" :class="`alert ${variant}`">
		<ul class="list-type-square">
			<li v-for="(error, key) in errorBag" :key="key">
				<span v-for="(errorItem, innerKey) in error" :key="innerKey"> {{ errorItem }}</span>
			</li>
		</ul>
	</div>
</template>

<script>
	export default {
		props: {
			errors: {
				required: true,
			},
			variant: {
				type: String,
				required: false,
				default: () => "alert-danger",
			},
		},
		data() {
			return {
				show: false,
				errorBag: null,
			};
		},
		watch: {
			errors() {
				if (this.errors) {
					const response = this.errors.response;
					if (!response) {
						this.errorBag = { frontend: ["Error de Interfaz."] };
						Swal.fire("Oops!", "Error de Interfaz.", "error");
					} else {
						switch (response.status) {
							case 400:
								this.errorBag = { error: [response.data.message] };
								Swal.fire(
									"Ops",
									"No tienes los permisos suficientes.",
									"error"
								);
								break;
							case 401:
								this.errorBag = {
									unauthorized: [
										"No tienes los permisos suficientes.",
									],
								};
								Swal.fire(
									"Ops",
									"No tienes los permisos suficientes.",
									"error"
								);
								break;
							case 403:
								this.errorBag = {
									forbidden: [response.data.message],
								};
								Swal.fire("Ops", response.data.message, "error");
								break;
							case 404:
								this.errorBag = {
									NotFound: [
										"El servidor no ha encontrado la petición.",
									],
								};
								Swal.fire(
									"Ops",
									"404 El servidor no ha encontrado la petición.",
									"error"
								);
								break;
							case 422:
								this.errorBag =
									response.data.errors ?? response.data;
								Swal.fire(
									"Ops",
									"Error en los datos enviados.",
									"error"
								);
								break;
							case 500:
								this.errorBag = {
									error: [
										"No eres tú, somos nosotros. Estamos trabajando para brindarte la mejor experiencia posible. Intenta más tarde.",
									],
								};
								Swal.fire(
									"Ops",
									"Error de servidor. Por favor, intenta mas tarde.",
									"error"
								);
								break;
						}
					}

					this.show = true;
				} else this.show = false;
			},
		},
	};
</script>
