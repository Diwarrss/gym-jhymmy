import ExampleComponent from './pages/ExampleComponent';
import Perfil from './components/Perfil';
import Pagos from './components/Pagos';
import Medidas from './components/Medidas';
import Usuarios from './components/Usuarios';
import Generos from './components/Generos';
import Estados from './components/Estados';
import Error404 from './pages/404';
export default {
  mode: 'history',
  base: '/home',
  routes: [
    {
      path: '/home/*',
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
    },
    {
      path: '/medidas',
      name: 'medidas',
      component: Medidas
    },
    {
      path: '/pagos',
      name: 'pagos',
      component: Pagos
    },
    {
      path: '/usuarios',
      name: 'usuarios',
      component: Usuarios
    },
    {
      path: '/generos',
      name: 'generos',
      component: Generos
    },
    {
      path: '/estados',
      name: 'estados',
      component: Estados
    }
  ]
}
