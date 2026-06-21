import { createRouter, createWebHistory } from 'vue-router';
import Home from '../pages/home/Index.vue';
import Projects from '../pages/projects/Index.vue';
import AppLayout from '../layouts/AppLayout.vue';
import ProjectDetails from '../pages/projects/ProjectDetails.vue';
import MakeQuotation from '../pages/MakeQuotation.vue';
const routes = [
  {
    path: '/',
    component: AppLayout,
    children: [
      { path: '', name: 'home', component: Home },
      { path: '/contact', name: 'Contact US', component: Home },
      { path: '/projects', name: 'Projects', component: Projects },
      { path: 'makequotation', name: 'make-qutation', component: MakeQuotation },
      {
      path: '/projects/:slug',
      name: 'project-details',
      component: ProjectDetails,
      props: true, // passes :id as a prop to the component
    },
      // add more pages here
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
