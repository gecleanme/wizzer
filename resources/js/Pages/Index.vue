<script setup>
import {Head} from '@inertiajs/vue3';
import {computed, onMounted, ref, watch} from "vue";
import "@geoapify/geocoder-autocomplete/styles/round-borders.css";
import { GeocoderAutocomplete } from '@geoapify/geocoder-autocomplete';


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

watch(showInF, ()=> {
    shownTemp()
})



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

        window.location.href = `?location=${(location.properties.address_line1)}`;

    });

    autocomplete.on('suggestions', (suggestions) => {
        // process suggestions here
    });


})
</script>

<template>

    <Head title="Index"/>

    <div
        class="flex flex-col items-center justify-center min-w-screen min-h-screen text-gray-700 p-10 bg-gradient-to-br from-blue-200 via-gray-200 to-orange-200 ">

        <div id="autocomplete" class="mb-8 w-1/3 mx-auto relative autocomplete-container"></div>


        <!-- Component Start -->
        <div class="w-full max-w-screen-sm bg-white p-10 rounded-xl ring-8 ring-white ring-opacity-40">
            <div class="flex justify-between">
                <div class="flex flex-col">
                    <span class="text-6xl font-bold">{{ shownTemp(infoNow.temp.toFixed(0))}}</span>
                    <span class="font-semibold mt-1 text-gray-500">{{ now.name }}</span>
                    <span class="text-sm font-semibold text-gray-400">Feels like {{ shownTemp(infoNow.feels_like.toFixed(0)) }}</span>
                    <span class="font-semibold text-md mt-4">Lw: {{ shownTemp(infoNow.temp_min.toFixed(0)) }} / Hi: {{ shownTemp(infoNow.temp_max.toFixed(0)) }}</span>


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
