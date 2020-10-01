import ExampleComponent from './components/ExampleComponent';
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
