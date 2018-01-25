
import projects from './../components/project-lists/router';
import overview from './../components/project-overview/router';
import categories from './../components/categories/router';
import add_ons from './../components/add-ons/router';
import my_tasks from './../components/my-tasks/router';
import calendar from './../components/calendar/router';
import reports from './../components/reports/router';
import progress from './../components/progress/router';
import {general, email} from './../components/settings/router';
import activities from './../components/project-activities/router';
import files from './../components/project-files/router';
import {task_lists, single_list} from './../components/project-task-lists/router';
import {discussions, single_discussion} from './../components/project-discussions/router';
import {milestones} from './../components/project-milestones/router';

import Empty from '@components/common/empty.vue';

weDevs_PM_Routers.push({
	path: '/', 
    component:  Empty,
    name: 'project_root',

	children: wedevsPMGetRegisterChildrenRoute('project_root')
});

var router = new pm.VueRouter({
	routes: weDevs_PM_Routers,
});

router.beforeEach((to, from, next) => {
  	pm.NProgress.start();
	next();
});

export default router;
