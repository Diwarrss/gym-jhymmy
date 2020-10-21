import ExampleComponent from './pages/ExampleComponent';
import Perfil from './pages/Perfil';
import Pagos from './pages/Pagos';
import Medidas from './pages/Medidas';
import Usuarios from './pages/Usuarios';
import Generos from './pages/Generos';
import Estados from './pages/Estados';
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
