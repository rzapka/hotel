import VueRouter from "vue-router";

import Restaurant from "../components/restaurant/Restaurant";
import Rooms from "../components/rooms/Rooms";
import Room from "../components/rooms/Room";
import BookRoom from "../components/rooms/BookRoom";
import Main from "../components/main/Main";
import Login from "../components/auth/Login";
import Register from "../components/auth/Register";
import Logout from "../components/auth/Logout";
import Attractions from "../components/attractions/Attractions";
import Spa from "../components/attractions/Spa";
import Bowling from "../components/attractions/Bowling";
import Hall from "../components/attractions/Hall";
import FoodDelivery from "../components/attractions/FoodDelivery";
import Employee from "../components/employee/Employee";
import RoomDetails from "../components/employee/views/rooms/RoomDetails";
import RoomAdd from "../components/employee/views/rooms/RoomAdd";
import Notifications from "../components/employee/views/notifications/Notifications";
import MealDetails from "../components/employee/views/restaurant/MealDetails";
import MealAdd from "../components/employee/views/restaurant/MealAdd";
import AttractionDetails from "../components/employee/views/attractions/AttractionDetails";
import Opinions from "../components/opinions/Opinions";
import OpinionAdd from "../components/opinions/OpinionAdd";
import OpinionEdit from "../components/opinions/OpinionEdit";
import UserDetails from "../components/employee/views/users/UserDetails";
import Reservations from "../components/reservations/Reservations";
import RoomNumberAdd from "../components/employee/views/rooms/RoomNumberAdd";

const routes = [
    {
        path: '/',
        name: 'Main',
        component: Main
    },
    {
        path: '/restauracja',
        name: 'Restaurant',
        component: Restaurant
    },
    {
        path: '/pokoje',
        name: 'Rooms',
        component: Rooms
    },
    {
        path: '/pokoje/:id',
        name: 'Room',
        component: Room,
        props: true
    },
    {
        path: '/zarezerwuj-pokoj/:id',
        name: 'BookRoom',
        component: BookRoom,
        props: true
    },
    {
        path: '/logowanie',
        name: 'Login',
        component: Login
    },
    {
        path: '/rejestracja',
        name: 'Register',
        component: Register
    },
    {
        path: '/logout',
        name: 'Logout',
        component: Logout
    },
    {
        path: '/atrakcje',
        name: 'Attractions',
        component: Attractions,
    },
    {
        path: '/atrakcje/spa',
        name: 'Spa',
        component: Spa
    },
    {
        path: '/atrakcje/kregle',
        name: 'Bowling',
        component: Bowling
    },
    {
        path: '/atrakcje/sala',
        name: 'Hall',
        component: Hall
    },
    {
        path: '/atrakcje/jedzenie',
        name: 'FoodDelivery',
        component: FoodDelivery
    },
    {
        path: '/panel-pracownika',
        name: 'Employee',
        component: Employee
    },
    {
        path: '/edytuj-pokoj/:id',
        name: 'RoomDetails',
        component: RoomDetails,
        props:true
    },
    {
        path: '/dodaj-pokoj',
        name: 'RoomAdd',
        component: RoomAdd
    },
    {
        path: '/edytuj-posilek/:id',
        name: 'MealDetails',
        component: MealDetails,
        props:true
    },
    {
        path: '/dodaj-posilek',
        name: 'MealAdd',
        component: MealAdd
    },
    {
        path: '/edytuj-atrakcje/:id',
        name: 'AttractionDetails',
        component: AttractionDetails,
        props:true
    },
    {
        path: '/powiadomienia',
        name: 'Notifications',
        component: Notifications
    },
    {
        path: '/opinie',
        name: 'Opinions',
        component: Opinions
    },
    {
        path: '/dodaj-opinie',
        name: 'OpinionAdd',
        component: OpinionAdd
    },
    {
        path: '/edytuj-opinie/:id',
        name: 'OpinionEdit',
        component: OpinionEdit,
        props: true
    },
    {
        path: '/edytuj-uzytkownika/:id',
        name: 'UserDetails',
        component: UserDetails,
        props: true
    },
    {
        path: '/rezerwacje',
        name: 'Reservations',
        component: Reservations,
    },
    {
        path: '/dodaj-nowy-pokoj',
        name: 'RoomNumberAdd',
        component: RoomNumberAdd,
    },
]

export default new VueRouter({
    mode: 'history',
    routes,
    linkActiveClass: "active",
})
