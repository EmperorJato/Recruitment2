import Login from './views/LoginComponent.vue';
import SuperAdmin from './views/SuperAdminComponent.vue';
import User from './views/UserComponent.vue';
import UserDashboard from './components/User/Dashboard.vue';
import UserRequested from './components/User/Requested.vue';
import UpdateRequirements from './components/User/UpdateRequirements.vue';
import UserNewRequest from './components/User/NewRequest.vue';
import Admin from './views/AdminComponent.vue';
import AdminDashboard from './components/Admin/Dashboard.vue';
import AdminRibshack from './components/Admin/Ribshack.vue';
import AdminDelcom from './components/Admin/Delcom.vue';
import AdminRamx from './components/Admin/Ramx.vue';
import AdminRequest from './components/Admin/AdminRequest.vue';
import HR from './views/HrComponent.vue';
import HRDashboard from './components/Hr/Dashboard.vue';
import HRPending from './components/Hr/Pending.vue'
import HRRequirements from './components/Hr/Requirements.vue';
import HRScreening from './components/Hr/Screening.vue';
import HRMpr from './components/Hr/MPR.vue';
import HRApplicants from './components/Hr/Applicants.vue';
import HRViewApplicants from './components/Hr/ViewApplicants.vue';
import AdminView from './components/Admin/View.vue'
import Roles from './components/SuperAdmin/RolesComponent.vue';
import Applicant from './views/ApplicantComponent.vue';
import NotFound from './views/NotFound.vue';
import HomePage from './views/HomePage.vue';
import store from "./store";



const user = (to, from, next) => {
    
    if(store.state.currentUser == null){
        next('/login');
    } else if(store.state.currentUser.role == "user"){
        next();
    } else {
        next('*');
    }
}

const admin = (to, from, next) => {

    if(store.state.currentUser == null){
        next('/login')
    } else {
        if(store.state.currentUser.role == "admin"){
            next();
        } else {
            next('*');
        }
    }
    

} 

const hr = (to, from, next) => {
    if(store.state.currentUser == null){
        next('/login')
    } else {
        if(store.state.currentUser.role == "hr"){
            next();
        } else {
            next('*');
        }
    }
}


export const routes = [

    {
        path : "/",
        component : HomePage,
        name : 'HomePage',
    },
    
    {
        path : "/opportunities",
        component : Applicant,
        name : 'Applicant',
    },
    
    {
        path : "/login",
        component : Login,
        name : 'Login',
    },
    
    {
        path : "/super_admin",
        component : SuperAdmin,
        name : 'SuperAdmin',
        children : [
            
            {
                path : "roles",
                component : Roles,
                name : 'Roles'
            },
            
        ],
    },

    {
        path : "/admin",
        component : Admin,
        name : 'Admin',
        children : [
            
            {
                path : "dashboard",
                component : AdminDashboard,
                name : 'AdminDashboard'
            },

            {
                path : "delcom",
                component : AdminDelcom,
                name : 'AdminDelcom'
            },
            {
                path : "ribshack",
                component : AdminRibshack,
                name : 'AdminRibshack'
            },
            {
                path : "ramx",
                component : AdminRamx,
                name : 'AdminRamx'
            },
            {
                path : "request",
                component : AdminRequest,
                name : 'AdminRequest'
            },
            {
                path : "request/:id?",
                component : AdminView,
                name : 'AdminView'
            }
            
        ],
        beforeEnter: admin,
    },

    {
        path : "/user",
        component : User,
        name : 'User',
        children : [
            
            {
                path : "dashboard",
                component : UserDashboard,
                name : 'UserDashboard',
            },

            {
                path : "requested",
                component : UserRequested,
                name : 'UserRequested',
            },
            {
                path : "update-requirements",
                component : UpdateRequirements,
                name : 'UpdateRequirements',
            },

            {
                path : "requesting/:id?",
                component : UserNewRequest,
                name : 'UserNewRequest',
            },
            
        ],
        beforeEnter: user,
    },

    {
        path : "/hr",
        component : HR,
        name : 'HR',
        children : [
            
            {
                path : "dashboard",
                component : HRDashboard,
                name : 'HRDashboard'
            },

            {
                path : "pending",
                component : HRPending,
                name : 'HRPending'
            },

            {
                path : "screening",
                component : HRScreening,
                name : 'HRScreening'
            },

            {
                path : "requirements",
                component : HRRequirements,
                name : 'HRRequirements'
            },
           
            {
                path : "mpr",
                component : HRMpr,
                name : 'HRMpr'
            },
            {
                path : "applicants",
                component : HRApplicants,
                name : 'HRApplicants'
            },
            {
                path : "applicant/view/:id?",
                component : HRViewApplicants,
                name : 'HRViewApplicants'
            },
            
            
        ],
        beforeEnter: hr,
    },

    {
        path : "*",
        redirect : "/404_Not_Found",
    },

    {
        path : "/404_Not_Found",
        component : NotFound,
        name : 'NotFound'
    }

];