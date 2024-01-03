<script setup>
import { Head } from "@inertiajs/vue3";
import LocationAutocomplete from "@/Components/LocationAutocomplete.vue";
import useWeather from "@/Composables/useWeather.js";

const props = defineProps({
    now: {
        type: Object,
        required: true,
    },
    fiveDay: {
        type: Object,
        required: true,
    },
});

const {
    infoNow,
    iconNow,
    descNow,
    fiveDays,
    dtToShort,
    dt2LocalT,
    toFahrenheit,
    showInF,
    shownTemp,
    timeNow,
    currentGradient,
} = useWeather(props.now, props.fiveDay);
</script>

<script>
import Layout from "@/Layouts/Layout.vue";

export default {
    layout: Layout,
};
</script>

<template>
    <Head title="Quick Weather" />

    <div
        class="flex flex-col items-center justify-center min-w-screen min-h-screen text-gray-700 p-10"
        :style="'background:' + currentGradient"
    >
        <LocationAutocomplete
            class="mb-8 w-full lg:w-1/3 mx-auto relative autocomplete-container"
        />

        <div class="relative h-10 min-w-32">
            <div class="absolute top-0 left-0 md:left-64 h-16 min-w-16">
                <label class="relative inline-flex cursor-pointer">
                    <input
                        type="checkbox"
                        value=""
                        class="sr-only peer"
                        :checked="showInF"
                        @click="showInF = !showInF"
                    />
                    <span
                        class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"
                    ></span>
                    <span class="ms-3 text-sm font-medium">Fahrenheit</span>
                </label>
            </div>
        </div>

        <!-- Component Start -->
        <div
            class="w-full max-w-screen-sm bg-white p-10 rounded-xl ring-8 ring-white ring-opacity-40 opacity-80"
        >
            <div class="flex justify-between">
                <div class="flex flex-col">
                    <span class="text-6xl font-bold">{{
                        shownTemp(infoNow.temp.toFixed(0))
                    }}</span>
                    <span class="font-semibold mt-1 text-gray-500">{{
                        now.name
                    }}</span>
                    <span class="text-sm font-semibold text-gray-400"
                        >Feels like
                        {{ shownTemp(infoNow.feels_like.toFixed(0)) }}</span
                    >
                    <span class="font-semibold text-md mt-4"
                        >Lw: {{ shownTemp(infoNow.temp_min.toFixed(1)) }} / Hi:
                        {{ shownTemp(infoNow.temp_max.toFixed(1)) }}</span
                    >
                </div>
                <div class="flex flex-col">
                    <img :src="iconNow" alt="Icon" />
                    <span
                        class="font-semibold mt-1 text-sm text-center overflow-auto"
                        >{{ descNow }}</span
                    >
                    <span
                        class="font-semibold mt-1 text-sm text-center overflow-auto"
                        >Local Time: {{ timeNow }}</span
                    >
                </div>
            </div>
        </div>
        <div
            class="flex flex-col space-y-6 w-full max-w-screen-sm bg-white p-10 mt-10 rounded-xl ring-8 ring-white ring-opacity-40 opacity-80"
        >
            <div
                class="flex justify-between items-center"
                v-for="(day, index) in fiveDays"
                :key="index"
            >
                <span class="font-semibold text-lg w-1/4">{{
                    dtToShort(day.dt_txt)
                }}</span>
                <div class="flex items-center justify-end w-1/4 pr-10">
                    <span class="font-semibold">{{
                        shownTemp(day.main.temp_max.toFixed(0))
                    }}</span>
                </div>
                <img
                    :src="
                        'https://openweathermap.org/img/wn/' +
                        day.weather[0].icon +
                        '.png'
                    "
                    alt="icon"
                />

                <span class="font-semibold text-md w-1/4 text-right">{{
                    day.weather[0].description.toUpperCase()
                }}</span>
            </div>
        </div>
        <!-- Component End  -->
    </div>
</template>
