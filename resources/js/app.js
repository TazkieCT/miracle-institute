import Alpine from 'alpinejs'
import assessmentApp from './components/assessment'

window.Alpine = Alpine
Alpine.data('assessmentApp', assessmentApp)
Alpine.start()