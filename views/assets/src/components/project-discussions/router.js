
weDevsPmRegisterModule('projectDiscussions', 'project-discussions');

const discussions_route = resolve => {
    require.ensure(['./discussions.vue'], () => {
        resolve(require('./discussions.vue'));
    });
}

const individual_discussion = resolve => {
    require.ensure(['./individual-discussions.vue'], () => {
        resolve(require('./individual-discussions.vue'));
    });
}

weDevsPMRegisterChildrenRoute('project_root', 
    [
        {
            path: ':project_id/discussions/', 
            component: discussions_route,
            name: 'discussions',

            children: [
                {
                    path: 'pages/:current_page_number', 
                    component: discussions_route,
                    name: 'discussion_pagination',
                },
            ]
        }
    ]
)

weDevsPMRegisterChildrenRoute('project_root', 
    [
        { 
            path: '/:project_id/discussions/:discussion_id', 
            component: individual_discussion,
            name: 'individual_discussions' 
        }
    ]
)


 