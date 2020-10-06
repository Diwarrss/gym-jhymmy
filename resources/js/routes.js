import ExampleComponent from './pages/ExampleComponent';
import Perfil from './pages/Perfil';
import Error404 from './pages/404';
export default {
  mode: 'history',
  base: '/home',
  routes: [
    {
      path: '*',
      component: Error404
    },
    {
      path: '/',
      name: 'home',
      component: ExampleComponent
    },
    {
      path: '/exampleComponent',
      name: 'example-component',
      component: ExampleComponent
    },
    {
      path: '/perfil',
      name: 'perfil',
      component: Perfil
    }
  ]
}
