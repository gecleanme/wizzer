<script setup>
import {Head} from '@inertiajs/vue3';
import {computed, onMounted, ref, watch} from "vue";
import "@geoapify/geocoder-autocomplete/styles/round-borders.css";
import { GeocoderAutocomplete } from '@geoapify/geocoder-autocomplete';
import Layout from "@/Layouts/Layout.vue";

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
        let options = { month: 'short', day: 'numeric'};
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

function dt2LocalT(){
    const offsetSeconds = props.now.timezone; //api given
    let nowUtc = Date.now() + new Date().getTimezoneOffset() * 60000;
    let date = new Date(nowUtc + offsetSeconds * 1000);
    return  date.toLocaleTimeString(undefined, { hour: '2-digit', minute: '2-digit', hour12:true });
}



const toFahrenheit = (Ctemp) => {
    let temp = (Ctemp * 9/5) + 32;
    return temp.toFixed(0);
}

const showInF = ref(false);
const shownTemp = (temp) => {
    if (showInF.value)
        return toFahrenheit(temp) + '°F';
    return temp + '°C';
}

const timeNow = ref(dt2LocalT())

watch(showInF, ()=> {
    shownTemp()
})

//weather background business starts

let weatherIcon = ref(iconNow);

let gradients = {
    '01d.png': 'bg-gradient-to-br from-blue-200 via-gray-200 to-orange-200',
    '02d.png': 'bg-gradient-to-br from-blue-200 via-white to-blue-300',
    '03d.png': 'bg-gradient-to-br from-blue-200 via-white to-blue-300',
    '04d.png': 'bg-gradient-to-br from-gray-300 via-white to-gray-400',
    '05d.png': 'bg-gradient-to-br from-blue-200 via-gray-200 to-orange-200',
    '06d.png': 'bg-gradient-to-br from-blue-200 via-gray-200 to-orange-200',
    '07d.png': 'bg-gradient-to-br from-blue-200 via-gray-200 to-orange-200',
    '08d.png': 'bg-gradient-to-br from-blue-200 via-gray-200 to-orange-200',
    '09d.png': 'bg-gradient-to-br from-blue-400 via-blue-300 to-gray-400',
    '10d.png': 'bg-gradient-to-br from-blue-400 via-blue-300 to-gray-400',
    '11d.png': 'bg-gradient-to-br from-gray-600 via-purple-700 to-gray-800',
    '13d.png': 'bg-gradient-to-br from-blue-200 via-white to-gray-200',
    '50d.png': 'bg-gradient-to-br from-gray-200 via-yellow-200 to-gray-400',


    '01n.png': 'bg-gradient-to-br from-gray-800 via-blue-900 to-black',
    '02n.png': 'bg-gradient-to-br from-blue-800 via-gray-800 to-blue-900',
    '03n.png': 'bg-gradient-to-br from-blue-800 via-gray-800 to-blue-900',
    '04n.png': 'bg-gradient-to-br from-gray-800 via-gray-700 to-gray-900',
    '05n.png': 'bg-gradient-to-br from-blue-200 via-gray-200 to-orange-200',
    '06n.png': 'bg-gradient-to-br from-blue-200 via-gray-200 to-orange-200',
    '07n.png': 'bg-gradient-to-br from-blue-200 via-gray-200 to-orange-200',
    '08n.png': 'bg-gradient-to-br from-blue-200 via-gray-200 to-orange-200',
    '09n.png': 'bg-gradient-to-br from-blue-800 via-blue-900 to-gray-800',
    '10n.png': 'bg-gradient-to-br from-blue-800 via-blue-900 to-gray-800',
    '11n.png': 'bg-gradient-to-br from-gray-800 via-purple-900 to-black',
    '13n.png': 'bg-gradient-to-br from-gray-800 via-gray-700 to-gray-900',
    '50n.png': 'bg-gradient-to-br from-gray-700 via-gray-600 to-gray-800',


};

let currentGradient = computed(() => gradients[weatherIcon.value]);


//autocomplete field
onMounted(()=>{
    const autocomplete = new GeocoderAutocomplete(
        document.getElementById("autocomplete"),
        import.meta.env.VITE_GEOCODER_KEY,
        {
            type:"city",
            placeholder:"Enter City Name",
            limit:3,
            lang:"en",
            skipIcons:true
        });

    autocomplete.on('select', (location) => {
        let urlParams;
        location.properties.city ? urlParams = `${location.properties.city}, ${location.properties.state}, ${location.properties.country_code}` : urlParams = `${location.properties.state}, ${location.properties.country_code}`
        window.location.href = `?location=${urlParams}`;
    });
})

</script>
<script>
export default {
    layout: Layout,
};

</script>

<template>

    <Head title="Index"/>

    <div class="flex flex-col items-center justify-center min-w-screen min-h-screen text-gray-700 p-10 bg-gradient-to-br from-blue-400 via-blue-300 to-gray-400">

        <div id="autocomplete" class="mb-8 w-full lg:w-1/3 mx-auto relative autocomplete-container"></div>

        <div class="relative h-10 min-w-32">
            <div class="absolute top-0 left-0 md:left-64 h-16 min-w-16">
                <label class="relative inline-flex cursor-pointer">
                    <input type="checkbox" value="" class="sr-only peer" :checked="showInF" @click="showInF=!showInF">
                    <span class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></span>
                    <span class="ms-3 text-sm font-medium">Fahrenheit</span>

                </label>
            </div>
        </div>

        <!-- Component Start -->
        <div class="w-full max-w-screen-sm bg-white p-10 rounded-xl ring-8 ring-white ring-opacity-40 opacity-80">
            <div class="flex justify-between">
                <div class="flex flex-col">
                    <span class="text-6xl font-bold">{{ shownTemp(infoNow.temp.toFixed(0))}}</span>
                    <span class="font-semibold mt-1 text-gray-500">{{ now.name }}</span>
                    <span class="text-sm font-semibold text-gray-400">Feels like {{ shownTemp(infoNow.feels_like.toFixed(0)) }}</span>
                    <span class="font-semibold text-md mt-4">Lw: {{ shownTemp(infoNow.temp_min.toFixed(1)) }} / Hi: {{ shownTemp(infoNow.temp_max.toFixed(1)) }}</span>


                </div>
                <div class="flex flex-col">
                    <img :src="iconNow" alt="Icon" />
                    <span class="font-semibold mt-1 text-sm text-center overflow-auto">{{descNow}}</span>
                    <span class="font-semibold mt-1 text-sm text-center overflow-auto">Local Time: {{ timeNow }}</span>

                </div>

            </div>
        </div>
        <div
            class="flex flex-col space-y-6 w-full max-w-screen-sm bg-white p-10 mt-10 rounded-xl ring-8 ring-white ring-opacity-40 opacity-80">
            <div class="flex justify-between items-center"
            v-for="(day,index) in fiveDays"
                 :key="index"
            >
                <span class="font-semibold text-lg w-1/4">{{dtToShort(day.dt_txt)}}</span>
                <div class="flex items-center justify-end w-1/4 pr-10">
                    <span class="font-semibold">{{shownTemp(day.main.temp_max.toFixed(0))}}</span>
                </div>
                <img :src="'https://openweathermap.org/img/wn/' + day.weather[0].icon + '.png'" alt="icon">

                <span class="font-semibold text-md w-1/4 text-right">{{ day.weather[0].description.toUpperCase() }}</span>
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

.geoapify-autocomplete-input {
    outline: none;
    line-height: 36px;
    height: 50px;
    padding: 0 31px 0 7px;
    width: calc(100% - 40px);
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 5px;
    font-size: 14px;
    text-align: center;
}
</style>
