import './bootstrap'
import { createApp } from 'vue'
import vSelect from 'vue-select'

import Users from './Users/Index.vue'
import HistoriesProfessional from './Histories/Professionals/index.vue'
import HistoriesPatient from './Histories/Patients/index.vue'
import BackendError from './Errors/BackendError.vue'

const app = createApp({
	components: {
		HistoriesProfessional,
		HistoriesPatient
	}
})
app.component('backend-error', BackendError)

app.component('v-select', vSelect)
// app.component('backend-error', BackendError)
app.mount('#app')
