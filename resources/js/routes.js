import ExampleComponent from './pages/ExampleComponent';
export default {
  mode: 'history',
  base: "/home",
  routes: [
    {
      path: "*",
      component: ExampleComponent
    },
    {
      path: "/",
      component: ExampleComponent
    },
    {
      path: "/exampleComponent",
      component: ExampleComponent
    }
  ]
}
