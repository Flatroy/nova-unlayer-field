Nova.booting((Vue, router, store) => {
  Vue.component('index-nova-unlayer-field', require('./components/IndexField'))
  Vue.component('detail-nova-unlayer-field', require('./components/DetailField'))
  Vue.component('form-nova-unlayer-field', require('./components/FormField'))
})
