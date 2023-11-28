import { defineConfig } from 'vite'
import path from 'path'

import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
	plugins: [
		laravel({
			input: ['resources/scss/app.scss', 'resources/js/app.js'],
			refresh: true
		}),
		vue()
	],
	resolve: {
		alias: {
			vue: 'vue/dist/vue.esm-bundler.js'
			// '@': path.resolve(__dirname, 'resources/js'),
			// '~': path.resolve(__dirname, 'node_modules')
		}
	}
})
