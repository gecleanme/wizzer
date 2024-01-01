<script setup>
import { onMounted } from "vue";
import "@geoapify/geocoder-autocomplete/styles/round-borders.css";
import { GeocoderAutocomplete } from "@geoapify/geocoder-autocomplete";

onMounted(() => {
    const autocomplete = new GeocoderAutocomplete(
        document.getElementById("autocomplete"),
        import.meta.env.VITE_GEOCODER_KEY,
        {
            type: "city",
            placeholder: "Enter City Name",
            limit: 3,
            lang: "en",
            skipIcons: true,
        },
    );

    autocomplete.on(
        "select",
        ({ properties: { city, state, country_code } }) => {
            const urlParams = city
                ? `${city}, ${state}, ${country_code}`
                : `${state}, ${country_code}`;
            window.location.href = `?location=${urlParams}`;
        },
    );
});
</script>

<template>
    <div id="autocomplete"></div>
</template>

<style>
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
