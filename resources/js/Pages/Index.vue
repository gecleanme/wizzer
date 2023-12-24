<script setup>
import {Head} from '@inertiajs/vue3';
import {computed} from "vue";

const props =defineProps({
    now: {
        type: Object,
        required: true,
    },
    fiveDay: {
        type: Object,
        required: true,
    },
});
const infoNow = computed(() => {
   return props.now.main;
})

const iconNow = computed(() =>{
    return `https://openweathermap.org/img/wn/${props.now.weather[0].icon}@2x.png`
})

const descNow = computed(() =>{
    return props.now.weather[0].description.toUpperCase()
})

const fiveDay = () => {

    let uniqueDates = [];
    let uniqueObjects = [];

    for (let day of props.fiveDay) {
        let currentDate = day.dt_txt
        let d = new Date(currentDate);
        let options = { month: 'short', day: 'numeric' };
        let finalDate= d.toLocaleDateString('en-US', options);
        if (!uniqueDates.includes(finalDate)) {
            uniqueDates.push(finalDate);
            uniqueObjects.push(day)
        }
    }
    uniqueObjects.shift();
    return uniqueObjects;
}

let fiveDays = fiveDay();

function dtToShort (dt){
    let d = new Date(dt);
    let options = { weekday:'short',month: 'short', day: 'numeric' };
    return d.toLocaleDateString('en-US', options);
}

console.log(fiveDays)
</script>

<template>

    <Head title="Index"/>

    <div
        class="flex flex-col items-center justify-center min-w-screen min-h-screen text-gray-700 p-10 bg-gradient-to-br from-blue-200 via-gray-200 to-orange-200 ">

        <!-- Component Start -->
        <div class="w-full max-w-screen-sm bg-white p-10 rounded-xl ring-8 ring-white ring-opacity-40">
            <div class="flex justify-between">
                <div class="flex flex-col">
                    <span class="text-6xl font-bold">{{ infoNow.temp.toFixed(0)}}°C</span>
                    <span class="font-semibold mt-1 text-gray-500">{{ now.name }}</span>
                    <span class="text-sm font-semibold text-gray-400">Feels like {{ infoNow.feels_like.toFixed(0) }}°C</span>
                    <span class="font-semibold text-md mt-4">Lw: {{ infoNow.temp_min.toFixed(0) }}°C / Hi: {{ infoNow.temp_max.toFixed(0) }}°C</span>


                </div>
                <div class="flex flex-col">
                    <img :src="iconNow" alt="Icon" />
                    <span class="font-semibold mt-1 text-sm text-center overflow-auto">{{descNow}}</span>
                </div>

            </div>
        </div>
        <div
            class="flex flex-col space-y-6 w-full max-w-screen-sm bg-white p-10 mt-10 rounded-xl ring-8 ring-white ring-opacity-40">
            <div class="flex justify-between items-center"
            v-for="(day,index) in fiveDays"
                 :key="index"
            >
                <span class="font-semibold text-lg w-1/4">{{dtToShort(day.dt_txt)}}</span>
                <div class="flex items-center justify-end w-1/4 pr-10">
                    <span class="font-semibold">12%</span>
                    <svg class="w-6 h-6 fill-current ml-1" viewBox="0 0 16 20" version="1.1"
                         xmlns="http://www.w3.org/2000/svg">
                        <g transform="matrix(1,0,0,1,-4,-2)">
                            <path
                                d="M17.66,8L12.71,3.06C12.32,2.67 11.69,2.67 11.3,3.06L6.34,8C4.78,9.56 4,11.64 4,13.64C4,15.64 4.78,17.75 6.34,19.31C7.9,20.87 9.95,21.66 12,21.66C14.05,21.66 16.1,20.87 17.66,19.31C19.22,17.75 20,15.64 20,13.64C20,11.64 19.22,9.56 17.66,8ZM6,14C6.01,12 6.62,10.73 7.76,9.6L12,5.27L16.24,9.65C17.38,10.77 17.99,12 18,14C18.016,17.296 14.96,19.809 12,19.74C9.069,19.672 5.982,17.655 6,14Z"
                                style="fill-rule:nonzero;"/>
                        </g>
                    </svg>
                </div>
                <svg class="h-8 w-8 fill-current w-1/4" xmlns="http://www.w3.org/2000/svg" height="24"
                     viewBox="0 0 24 24" width="24">
                    <path d="M0 0h24v24H0V0z" fill="none"/>
                    <path
                        d="M6.76 4.84l-1.8-1.79-1.41 1.41 1.79 1.79zM1 10.5h3v2H1zM11 .55h2V3.5h-2zm8.04 2.495l1.408 1.407-1.79 1.79-1.407-1.408zm-1.8 15.115l1.79 1.8 1.41-1.41-1.8-1.79zM20 10.5h3v2h-3zm-8-5c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm-1 4h2v2.95h-2zm-7.45-.96l1.41 1.41 1.79-1.8-1.41-1.41z"/>
                </svg>
                <span class="font-semibold text-lg w-1/4 text-right">18° / 32°</span>
            </div>
        </div>
        <!-- Component End  -->

    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
