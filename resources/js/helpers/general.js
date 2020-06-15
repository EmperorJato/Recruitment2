import Axios from 'axios';

export function initialize(store, router){
    
    router.beforeEach((to, from, next) => {
        const requireAuth = to.matched.some(record => record.meta.requireAuth);
        const currentUser = store.state.currentUser;
        
        if(requireAuth && !currentUser){
            next('/login');
        } else if (to.path == '/login' && currentUser){
            let role = currentUser.role;
            switch(role) {
                case "admin":
                    next('/admin/dashboard')
                break;

                case "user":
                    next('/user/dashboard')
                break;

                case "hr":
                    next('/hr/dashboard')
                break;

                case "super_admin":
                    next('/super_admin/dashboard')
                break;

                default: 
                    next('/')
            }
        } else {
            next()
        }
    })

    Axios.interceptors.response.use(null,(error) => {
        if(error.response.status == 401){
            store.commit('logout');
            router.push('/login');
        }
        return Promise.reject(error.response);
    });
    
    if(store.getters.currentUser){
        setAutorization(store.getters.currentUser.token)
    }
}

export function setAutorization(token){
    Axios.defaults.headers.common["Authorization"] = `Bearer ${token}`
}