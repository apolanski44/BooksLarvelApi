import { createApp } from 'vue';
import ExampleComponent from './components/ExampleComponent.vue';
import router from './router';

const app = createApp(ExampleComponent);
app.use(router);
app.mount('#app'); 
