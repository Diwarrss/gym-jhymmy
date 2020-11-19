import Profile from './pages/Profile';
import Payment from './pages/Payment';
import Tracing from './pages/Tracing';
import User from './pages/User';
import Gender from './pages/Gender';
import State from './pages/State';
import Error404 from './pages/404';
import AccessControl from './pages/AccessControl';
import CancellationReason from './pages/CancellationReason';
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
      component: Tracing
    },
    {
      path: '/profile',
      name: 'profile',
      component: Profile
    },
    {
      path: '/tracing',
      name: 'tracing',
      component: Tracing
    },
    {
      path: '/payment',
      name: 'payment',
      component: Payment
    },
    {
      path: '/user',
      name: 'user',
      component: User
    },
    {
      path: '/gender',
      name: 'gender',
      component: Gender
    },
    {
      path: '/state',
      name: 'state',
      component: State
    },
    {
      path: '/access_control',
      name: 'access_control',
      component: AccessControl
    },
    {
      path: '/cancellation_reason',
      name: 'cancellation_reason',
      component: CancellationReason
    }
  ]
}
