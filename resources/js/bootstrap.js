import _ from 'lodash'
import * as bootstrap from 'bootstrap'
import axios from 'axios'
import Swal from 'sweetalert2'
import 'sweetalert2/src/sweetalert2.scss'
import jquery from 'jquery'
import '@fortawesome/fontawesome-free/js/all.js'

window.$ = jquery
window._ = _
window.axios = axios
window.bootstrap = bootstrap
window.Swal = Swal.mixin({
	customClass: {
		confirmButton: 'btn btn-primary',
		cancelButton: 'btn btn-outline-danger',
		denyButton: 'btn btn-outline-secondary'
	},
	buttonsStyling: false
})

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest' // ajax

const csrf_token = document.head.querySelector('meta[name="csrf-token"]')
if (csrf_token) {
	window.csrf_token = csrf_token.content
	window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.csrf_token
} else
	console.error(
		'CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token'
	)
